var djdareabyip;
function getSuitService(r){
	if (djdareabyip) djdareabyip.getSuitService(r);
}
(function(){
	var Ip = {
	    iplocation : {"局域网": { id: 1 },"北京": { id: 1 },"上海": { id: 2 },"天津": { id: 3 },"重庆": { id: 4 },"河北": { id: 5 },"山西": { id: 6 },"河南": { id: 7 },"辽宁": { id: 8 },"吉林": { id: 9 },"黑龙江": { id: 10 },"内蒙古": { id: 11 },"江苏": { id: 12 },"山东": { id: 13 },"安徽": { id: 14 },"浙江": { id: 15 },"福建": { id: 16 },"湖北": { id: 17 },"湖南": { id: 18 },"广东": { id: 19 },"广西": { id: 20 },"江西": { id: 21 },"四川": { id: 22 },"海南": { id: 23 },"贵州": { id: 24 },"云南": { id: 25 },"西藏": { id: 26 },"陕西": { id: 27 },"甘肃": { id: 28 },"青海": { id: 29 },"宁夏": { id: 30 },"新疆": { id: 31 },"台湾": { id: 32 },"香港": { id: 42 },"澳门": { id: 43 }},
	    ipServiceUrl : "#/ows/GetIPLocation.aspx",
	    name:"",
	    getProvinceIdByName : function(name) {
	         for (var o in this.iplocation) {
	             if (name.indexOf(o, 0) != -1) {this.name = o;return this.iplocation[o].id;}
	         }
	         return 0;
	    }
	};
	var cookieEditer = {
		getCookie:function (name) {
			var start = document.cookie.indexOf(name + "=");
			var len = start + name.length + 1;
			if ((!start) && (name != document.cookie.substring(0, name.length))) return null;
			if (start == -1) return null;
			var end = document.cookie.indexOf(';', len);
			if (end == -1) end = document.cookie.length;
			return unescape(document.cookie.substring(len, end));
		},
		setCookie:function (name, value, expires, path, domain, secure) {
			var today = new Date();
			today.setTime(today.getTime());
			if (expires) {
				expires = expires * 1000 * 60 * 60 * 24;
			}
			var expires_date = new Date(today.getTime() + (expires));
			document.cookie = name + '=' + escape(value) +
		        ((expires) ? ';expires=' + expires_date.toGMTString() : '') + //expires.toGMTString()
		        ((path) ? ';path=' + path : '') +
		        ((domain) ? ';domain=' + domain : '') +
		        ((secure) ? ';secure' : '');
		}
	};	
	function djdAreaByIp(v){
		if (arguments&&arguments[0]) this.serviceHost = arguments[0];
	}
	djdAreaByIp.prototype={
		serviceHost : "#",
		commonServiceUrl : function(){return this.serviceHost+"/vclist/getvcList.action";},
		limitBuyServiceUrl : function(){return this.serviceHost+"/vclist/getvcListbyqianggou.action";},
		/**图片随机地址**/
		getRandomImgUrl : function(size,para){
		    var url = para[0]?para[0]:para[2];
			if (url) {
				if (para[1]) return "http://img30.#/n"+size+"/"+url;
				return "http://img"+Math.floor(Math.random()*4+10)+".#/n"+size+"/"+url;
			}
		    return "#/images/none/none_"+(size=="5"?"50":"130")+".gif";
		},
		/**商品地址**/
		getProductUrl:function(id){
		    return "#/product/"+id+".html";
		},
		getSingelProductHtml:function(v,b){
		    if (!v) return "";
		    var purl = this.getProductUrl(v.wid);
		    return "<div class=\"p-img\"><a href=\""+purl+"\" target=\"_blank\"><img width=\"100\" height=\"100\" app=\"image:product\" alt=\""+v.title+"\" src=\""+this.getRandomImgUrl("4",[v.imgurl,v.upimgUrl,v.prouductUrl])+"\"></a></div>"
		           +"<div class=\"p-name\"><a href=\""+purl+"\" title=\""+v.title+"\" target=\"_blank\">"+v.title+"<font color=\"#ff6600\">"+(v.wareTitle?v.wareTitle:"")+"</font></a></div>"
		           +"<div class=\"p-price\">京东价：<strong><img src=\"#/gp"+v.wid+",2.png\" onerror=\"this.src='#/images/no2.gif'\" app=\"image:price\"></strong></div>"
		           +(b?"<div class=\"extra\"><span class=\"evaluate\"><a href=\"#"+v.wid+"-1-1.html\" target=\"_blank\">已有<span id=\"pl"+v.wid+"\">0</span>人评论</a></span><span id=\"p"+v.wid+"\"></span></div>":"");
		},
		/**今日推荐**/
		RecommentDataBind:function(v){
		    if (v&&v.length>0){
		        var vl = v.length;
		        var datalist = new Array(vl);
		        for (var i=0;i<vl;i++){
		            datalist[i] = this.getSingelProductHtml(v[i],false);
		        }
		        var uls = $("#bargain-list ul");
		        for (var i=0,j=uls.length;i<j;i++){
		            var lis = $(uls[i]).find("li");
		            for (var k=0,h=lis.length;k<h;k++){
		                if (vl>=k) $(lis[k]).html(datalist[k]);
		            }
		        }
		    }
		},
		/**特价商品**/
		getProductSpecialHtml:function(v){
		    var r = "";
		    if (v&&v.length>0){
		        r += "<ul>";
		        for (var i=0,j=v.length;i<j;i++){
		            r += "<li>"+this.getSingelProductHtml(v[i],true)+"</li>";
		        }
		    r += "</ul>";
		    }
		    return r;
		},
		/**优惠套装**/
		ipack : {},
		upimgUrls : {},
		packpids : {},
		currpacks : $("#suit div[class^='mc tabcon']"),
		getPackMainPid : function(v){
			if (v.prouductUrl && v.prouductUrl.indexOf("#/suite/") != -1){
				var array = v.prouductUrl.replace("#/suite/","").replace(".html","").split("-");
				if (array[1]){
					this.packpids[array[1]] = array[0];
					return array[1];
				}
			}
			return v.wid.toString();
		},
		getSuitService:function(r){
		    if (r.data&&r.data.length>0){
		        var t = r.data[0];
				for (var i=0,j=r.data.length;i<j;i++ )
				{
					if (r.data[i].PackId == this.packpids[r.data[i].MainSkuId]){
						t = r.data[i];
						i = j;
					}
				}
		        var purl = this.getProductUrl(t.MainSkuId);
		        var packs = "<div class='master'><div class='p-img'><a href='"+purl+"' target='_blank'><img src='"+this.getRandomImgUrl("4",[t.MainSkuPicUrl,this.upimgUrls[t.MainSkuId.toString()],null])+"' width='100' height='100' alt='"+t.MainSkuName+"' /></a></div>"
		                +"<div class='p-name'><a href='"+purl+"' target='_blank'>"+t.MainSkuName+"</a></div>"
		                +"<div class='icon-add'></div></div><div class='suits' id='suits-"+i+"'><ul class='list-h'>";
		        for (var i=0,j=t.ProductList.length;i<j;i++){
		            purl = this.getProductUrl(t.ProductList[i].SkuId);
		            packs += "<li><div class='p-img'><a href='"+purl+"' target='_blank'><img src='"+this.getRandomImgUrl("4",[t.ProductList[i].SkuPicUrl,null,null])+"' width='100' height='100' alt='"+t.ProductList[i].SkuName+"' /></a></div>"
		                       + "<div class='p-name'><a href='"+purl+"' target='_blank'>"+t.ProductList[i].SkuName+"</a></div></li>";
		        }
		        packs += "</ul></div><div class='infos'><div class='p-name'><a href='#/suite/"+t.PackId+"-"+t.MainSkuId+".html' target='_blank'>"+t.PackName+"</a></div>"
		                   +"<div class='p-price'>套装价：<strong>"+t.PackPrice+"</strong></div><div class='p-market'>原价：<del>"+t.PackListPrice+"</del></div>"
		                   +"<div class='p-saving'>立即节省："+t.Discount.replace("￥","")+"元</div>"
		                   +"<div class='btns'><a href='#"+t.PackId+"&pcount=1&ptype=2&mainSkuId="+t.MainSkuId+"' class='btn-buy'>购买套装</a></div></div>";
		        if (this.currpacks[this.ipack[t.MainSkuId.toString()]]) $(this.currpacks[this.ipack[t.MainSkuId.toString()]]).html(packs);	
		    }
		},
		getPack:function(id){
		    $.getJSONP("#/PromotionData.aspx?pid="+id+"&type=pack",getSuitService);
		},
		packDataBind:function(v){
		    if (v&&v.length>0){
		        for (var i=0,j=v.length;i<j;i++){
		            var wid = this.getPackMainPid(v[i]);
					this.ipack[wid] = i;
					this.upimgUrls[wid] = v[i].upimgUrl;
		            this.getPack(wid);
		        }
		    }
		},
		/**限时抢购**/
		getLimitBuyHtml:function(v){
		    var r = "",t=null,purl="";
		    if (v&&v.length>0){
		        r += "<ul>";
		        for (var i=0,j=v.length>2?2:v.length;i<j;i++){
		            t = v[i];
		            purl = this.getProductUrl(t.wid);
		            r += "<li><div class='p-img'><a href='"+purl+"' target='_blank'><img width='100' height='100' app='image:product' alt='"+t.title+"' src='"+this.getRandomImgUrl("4",[t.imgurl,t.upimgUrl,t.prouductUrl])+"'></a>"
		               + "<div class='pi9'></div></div><div class='p-name'><a href='"+purl+"' title='"+t.title+"' target='_blank'>"+t.title+"<font color='#ff6600'>"+(t.wareTitle?t.wareTitle:"")+"</font></a>"
		               + "</div><div class='p-price'>抢购价：<strong>"+(t.price==0?"<img src='#/images/no2.gif' app='image:price'>":("￥"+t.price.toFixed(2)))+"</strong>（"+t.discount+"折）</div></li>";
		        }
		        r += "</ul>";
		    }
		    return r;
		},
		/**好评佳品排行榜**/
		getProductGoodRankHtml:function(v){
		    var r = "",t=null,purl="";
		    if (v&&v.length>0){
		        r += "<ul class=\"tabcon\">";
		        for (var i=0,j=v.length;i<j;i++){
		            t = v[i];
		            purl = this.getProductUrl(t.wid);
		            r += "<li><span>"+(i+1)+"</span>"
		               +"<div class=\"p-img\"><a href=\""+purl+"\" target=\"_blank\"><img width=\"50\" height=\"50\" app=\"image:product\" alt=\""+t.title+"\" src=\""+this.getRandomImgUrl("5",[t.imgurl,t.upimgUrl,t.prouductUrl])+"\"></a></div>"
		               +"<div class=\"p-name\"><a href=\""+purl+"\" title=\""+t.title+"\" target=\"_blank\">"+t.title+"<font color=\"#ff6600\">"+(t.wareTitle?t.wareTitle:"")+"</font></a></div>"
		               +"<div class=\"p-price\"><strong><img src=\"#/gp"+t.wid+",1.png\" onerror=\"this.src='#/images/no2.gif'\" app=\"image:price\"></strong></div>"
		               +"<div class=\"clr\"></div>"
		               +"<div class=\"evaluate\"><a href=\"#"+t.wid+"-1-1.html\" target=\"_blank\">已有<span id=\"pl"+t.wid+"\">0</span>人评论</a></div>"
		               +"</li>";
		        }
		        r += "</ul>";
		    }
		    return r;
		},
		getCommentsCount:function(r){
		    for (var i=0,j=r.CommentsCount.length;i<j;i++){
		        $("span[id='pl"+r.CommentsCount[i].SkuId+"']").html(r.CommentsCount[i].CommentCount);
		    }
		},
		commentCountsBind:function(){
		    var clist = $("span[id^='pl']");
		    if (clist){
		        var ids = "";
		        for (var i=0,j=clist.length;i<j;i++){
		            ids += $(clist[i]).attr("id").replace("pl","")+",";
		        }
		        var o = this;
			    $.ajax({
	                 type: "GET",
	                 url: "#",
	                 dataType: "jsonp",
	                 data: { method: "GetCommentsCount", referenceIds:ids,referenceType:"Product"},
	                 success: function(r) {
	                     o.getCommentsCount(r);
	                 }
	             });
		    }
		},
		pInfoBind:function(){
		        var idsp = "";
		        var obj = $("#plist li");
		        for (var i = 0; i < obj.length; i++) {
			       idsp += (obj.eq(i).find("span[id^=p]")).eq(1).attr("id").replace("p","")+",";
		        }
		        idsp = idsp.slice(0, -1);
			    var url="#/PromotionFlag.aspx?pid="+idsp+"&jsoncallback=?" ;
			    $.getJSON(url,function (json){
				    if (!json){return;}
				    json=json.data;
				    var pInfo;
				    for (var i=0;i<json.length;i++){
					    pInfo="";
					    for (var j=0;j<json[i].PF.length;j++){
						    switch (json[i].PF[j]){
							    case 1:
								    pInfo+="<a class=\"pt1\" title=\"本商品正在降价销售中\">直降</a>";
								    break;
							    case 2:
								    pInfo+="<a class=\"pt2\" title=\"购买本商品送赠品\">赠品</a>";
								    break;
							    case 3:
								    pInfo+="<a class=\"pt3\" title=\"购买本商品返优惠券\">返券</a>";
								    break;
							    case 4:
								    pInfo+="<a class=\"pt4\" title=\"购买本商品送积分\">送积分</a>";
								    break;
							    default:
								    return;
						    }
					    }
					    document.getElementById("p"+json[i].Pid).innerHTML=pInfo;
				    }
			    });
		},
		rfidJson : {},
		pageAreaComDataBind:function(v){
		    var str = "";
		    var loadcommentcounts = false,loadpinfo=false;
		    for(var o in v){
		        str = "";
		        if (o==this.rfidJson.ProductRecomment.toString()) {
		            this.RecommentDataBind(v[o]);
		        } else if (o==this.rfidJson.ProductSpecial.toString()) {
		            str = this.getProductSpecialHtml(v[o]);
		            if (str&&str != "") {
		                loadcommentcounts = true;
		                loadpinfo = true;
		            }
		        } else if (o==this.rfidJson.ProductSuit.toString()) {
		            this.packDataBind(v[o]);
		        } else if (o==this.rfidJson.ProductGoodRank.toString()){
		            str = this.getProductGoodRankHtml(v[o]);
		            if (str&&str != "") loadcommentcounts = true;
		        } 
		        if (str&&str != "") $("div[rfid='"+o+"']").html(str);
		    }
		    if (loadcommentcounts) this.commentCountsBind();/*评论数加载*/
		    if (loadpinfo) this.pInfoBind();/*返卷赠品信息加载*/
		},
		limitBuyDataBind:function(v){
		    var str = "";
		    for(var o in v){ 
		        str = "";
		        if (o==this.rfidJson.ProductLimitBuy.toString()) str = this.getLimitBuyHtml(v[o]);
		        if (str&&str != "") $("div[rfid='"+o+"']").html(str);
		    }
		},
	    getIpLocation:function(){
	         var o = this;
	         $.ajax({ type: "GET",
	             url: Ip.ipServiceUrl,
	             dataType: "jsonp",
	             success: function(r) {
	                 o.getAreaInfo(r.ip);
	                 cookieEditer.setCookie("ipLocation", Ip.name, 30, "/", "#", false);
	             }
	         });
	    },
	    getAreaInfo:function(name){
	         var o = this;
             var proid = 0;
             if (name) proid = Ip.getProvinceIdByName(name);
             if (proid==0) return;
             o.rfidJson = {ProductRecomment:parseInt($("#bargain-list").attr("rfid")),ProductSpecial:parseInt($("#ProductSpecial").attr("rfid")),ProductSuit:parseInt($("#suit").attr("rfid")),ProductGoodRank:parseInt($("#ProductGoodRank").attr("rfid")),ProductLimitBuy:parseInt($("#ProductLimitBuy").attr("rfid"))};
             var para = "[{\"size\":6,\"sizeNation\":0,\"provinecId\":" + proid + ",\"rfid\":"+o.rfidJson.ProductRecomment+",\"categoryId\":798,\"compare\":1}," /**今日推荐**/
                             + "{\"size\":6,\"sizeNation\":2,\"provinecId\":" + proid + ",\"rfid\":"+o.rfidJson.ProductSpecial+",\"categoryId\":877,\"compare\":1}," /**特价商品**/
                             + "{\"size\":2,\"sizeNation\":0,\"provinecId\":" + proid + ",\"rfid\":"+o.rfidJson.ProductSuit+",\"categoryId\":1706,\"compare\":1}," /**优惠套装**/
                             + "{\"size\":8,\"sizeNation\":0,\"provinecId\":" + proid + ",\"rfid\":"+o.rfidJson.ProductGoodRank+",\"categoryId\":880,\"compare\":1}]" ;/**好评佳品排行榜**/
             $.ajax({
                 type: "GET",
                 url: o.commonServiceUrl(),
                 dataType: "jsonp",
                 data: {key:proid+"-"+o.rfidJson.ProductRecomment+"-"+o.rfidJson.ProductSpecial+"-"+o.rfidJson.ProductSuit+"-"+o.rfidJson.ProductGoodRank, jsonstr: encodeURIComponent(para) },
                 success: function(r) {
                     o.pageAreaComDataBind(r);
                 }
             });
             /**限时抢购**/
             $.ajax({
                 type: "GET",
                 url: o.limitBuyServiceUrl(),
                 dataType: "jsonp",
                 data: {key:proid+"-"+o.rfidJson.ProductLimitBuy, jsonstr: encodeURIComponent("[{\"size\":2,\"sizeNation\":0,\"provinecId\":" + proid + ",\"rfid\":"+o.rfidJson.ProductLimitBuy+",\"categoryId\":0,\"compare\":1}]") },
                 success: function(r) {
                     o.limitBuyDataBind(r);
                 }
             });
	    },
		init:function() {
	         var proname = cookieEditer.getCookie("ipLocation");
	         if (proname) { this.getAreaInfo(proname); }else{ this.getIpLocation(); }
		}
	};
	djdareabyip = new djdAreaByIp("#");
	djdareabyip.init();
})();