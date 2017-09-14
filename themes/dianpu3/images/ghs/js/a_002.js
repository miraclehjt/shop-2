/**
* @description: 店内搜索模块方法库
* @author zengyang
* 
* {prefixUrl:'${popProduct.getBaseUrl($!domainKey)}',defKeyword:'$!defKeyword',keyword:'$!keyword',isShowPriceSift:'$!showPriceSift',appId:'$!appId',venderId:'$!venderId',shopId:'$!shopId',categoryId:'$!categoryId',cmsModId:'$!cms_mod_id'}
*/

(function($){
	jshop.module.search = {};
	$.extend(jshop.module.search, jshop.module);
	
	$.extend(jshop.module.search, {
		/*
		 * 给鼠标当前出发的节点增加一个样式：主要应用在鼠标移动到节点，节点伸缩与展开等。
		 * 参数传递：如{node:'li', defaultClass:'jCurrent', defaultShow:0}。参数node为单个节点名；参数defaultClass可任意命名，只要css里面有这个名字。
		 */
		shopSearch:function(args){
			if(args == undefined){
				if(validateData($(this).attr("module-param"))){
					var args = eval('('+$(this).attr("module-param")+')');
				}
			}
			var param = $.extend({priceDefaultClass : "input.inputSmall" , newKeyWord : "input.inputMiddle" , searchButton : "button" , jHotwords : ".jHotwords a"}),
			    namespace = {defKeyword : "" , keyword : "" , isShowPriceSift : "" , cmsModId : "" , appId : "" , venderId : "" , categoryId : "" , shopId : ""},
				elem = $(this).find(param.node),
				paramKeys = paramKeys || {},
				priceElem = $(this).find(param['priceDefaultClass']),
				len = 0,
				target = $(this),
				subfixUrl = "-1-1-24.html";
				for(var pos in namespace) {
					if(typeof args[pos] == "undefined") {
						alert("店内搜索模块module-param中缺少参数：" + pos);
						return;
					}
				}
				$.extend(namespace , args);
				$.extend(param , namespace);
				var defKeyWordVal = param["defKeyword"]; 
				var baseUrl = param['prefixUrl'] + "/view_search-" + param['appId'] + "-" + param['venderId'] + "-" + param['shopId'] + "-" + param['categoryId']+"-"+5;//5是orderby默认按上架时间排序
			//注册店内搜索事件的按钮
				target.find(param['searchButton']).click(function(){
				_submit(null, param['cmsModId']);
			});
			//注册搜索框的相关事件
		    function _keywordEvent() {
		    	target.find(param['newKeyWord']).bind({
		    		focus: function() {
		    		    var newKeyWordVal = $(this).val();
		    		    if(defKeyWordVal == newKeyWordVal) {
		    		    	$(this).val("");
		    		    }
		    		},
		    		keydown: function(e) {
		    			_enterBtnEvent(e);
		    		}
		    	});
		    }
		    
		    //回车事件，直接触发搜索
		    function _enterBtnEvent (e) {
		    	var e = window.event || e,
			    	keyCode = e.keyCode;
		    	if(keyCode == 13) {
		    		_submit(null, param["cmsModId"]);
		    	}
		    };
		    
		    //热门搜索词点击事件
		    function _hotwordsClickEvent () {
		    	target.find(param['jHotwords']).each(function (index , n) {
		    		var hotword = $(n).html();
		    		$(n).click(function(){
		    			_submit(hotword , param['cmsModId']);
		    		});
		    	});
		    }
		    
		    //注册价格查询得相关事件
		    function _priceSearchEvent () {
		    	priceElem.each(function (index, n) {
		    		$(n).bind({
			    		keydown : function (e) {
		    				var value = $(n).val();
			    			_enterBtnEvent(e);
			    		},
			    		blur: function() {
			    			if(priceElem.length == 2 ) {
				    			var minPrice = priceElem.eq(0).val(),
				    			    maxPrice = priceElem.eq(1).val();
				    			if(minPrice == "") {
				    				priceElem.eq(0).val("￥");
				    			}
				    			if(maxPrice == "") {
				    				priceElem.eq(1).val("￥");
				    			}
				    		}
			    		},
			    		change : function() {
			    			var value = $(n).val();
			    			var val = value.replace(/\D/g,'');
			    			$(n).val(val);
			    		},
			    		keyup : function () {
			    			var value = $(n).val();
			    			var val = value.replace(/\D/g,'');
			    			$(n).val(val);
			    		},
			    		afterpaste : function () {
			    			var value = $(n).val();
			    			var val = value.replace(/\D/g,'');
			    			$(n).val(val);
			    		}		
			    	});	
		    	});
		    };
		    function _submit(hotwords , mod_id) {
		    	var isGlobalSearch, //1：全店搜索，0：类目下搜索
		    	    keyword = null,//搜索关键词
		    	    minPrice = null,
		    	    maxPrice = null;
		    	if(priceElem.length == 2) {
		    		minPrice = priceElem.eq(0).val(),
		    		maxPrice = priceElem.eq(1).val();
		    	}
		    	if( jQuery("#isGlobalSearch"+mod_id).attr("checked") ){
					isGlobalSearch=1;
				}else{
					isGlobalSearch=0;
				}
		    if( param['isShowPriceSift'] == "true" ){
		    	if(minPrice != null && maxPrice != null) {
		    		minPrice= minPrice.replace("￥","");
		    		if(minPrice=="" || minPrice=="￥" ) {
		    			minPrice=0;
		    		}
		    		maxPrice= maxPrice.replace("￥","");			
		    		if(maxPrice==""|| maxPrice=="￥") {
		    			maxPrice=0;
		    		}	
		    	}
			}else{
				var minPrice=0;
				var maxPrice=0;
			}
		    if(minPrice == null && maxPrice == null) {
		    	minPrice=0;
		    	maxPrice=0;
		    }
			var url = baseUrl + "-" + minPrice+"-" + maxPrice + subfixUrl;
			if( hotwords != null ){
				keyword = hotwords;
			}else{
				var d = target.find(param["newKeyWord"]).attr('d');
			        newKeywordVal = target.find(param["newKeyWord"]).val();
				if( newKeywordVal !=d && newKeywordVal!= "" ){
					keyword = newKeywordVal;
				}else{
					keyword="";
				}
			}
			keyword = encodeURIComponent(keyword);
			keyword = encodeURIComponent(keyword);
			url = url+"?keyword="+keyword+"&isGlobalSearch="+isGlobalSearch;
			//兼容sdk与线上环境
//			if( window.location.hostname.indexOf("jd.net") != -1 || window.location.hostname.indexOf("jd.com") != -1 || window.location.hostname.indexOf("360buy.com") != -1) {
				window.location.href = url;
//			}else{
//				var href = "http://" + window.location.hostname + ":" + window.location.port + "/visualediting/preview/17-" + getTemplateId() + ".html";
//			    window.location.href = href;
//			}
		};
		//执行各种事件
		_keywordEvent();
		_priceSearchEvent();
		_hotwordsClickEvent();
	  }
	});
})(jQuery);	/**
	 * 输入框为默认关键词时替换为""
	 * @param mod_id
	 * @return
	 */
	function keywordOnfocus(mod_id){
		
		var newKeyword_input=getDOMId("newKeyword",mod_id);
		var defKeyword=getDOMId("defKeyword",mod_id);
		var d = $(newKeyword_input).attr('d');
		var classAttr =  $(newKeyword_input).attr("class");
		if( $(defKeyword).val() == $(newKeyword_input).val() ) {
			$(newKeyword_input).val("");
		}
	}
	/**
	 * 没有价格失去焦点时增加符号￥
	 * @param mod_id
	 * @return
	 */
	function priceOnblur(mod_id){
		var mixPrice_input=getDOMId("minPrice",mod_id);
		var maxPrice_input=getDOMId("maxPrice",mod_id);
		var minPrice =  $.trim($(mixPrice_input).val());
		var maxPrice =  $.trim($(maxPrice_input).val());
		if( minPrice=="" ){
			$(mixPrice_input).val("￥");
		}
		if( maxPrice=="" ){
			$(maxPrice_input).val("￥");
		}
		
	}
	
	function keydown(mod_id,e){
		 var keycode=e.keyCode;
		 if( e.keyCode == 13 ){
			 doSubmit(null,mod_id);
		 }
	}
	
	function doSubmit( hotwords , mod_id ) {
		
		var showPrice_input=getDOMId("isShowPriceSift",mod_id);
		var baseUrl_input=getDOMId("baseUrl",mod_id);
		var subfixUrl_input=getDOMId("subfixUrl",mod_id);
		var mixPrice_input=getDOMId("minPrice",mod_id);
		var maxPrice_input=getDOMId("maxPrice",mod_id);
		var newKeyword_input=getDOMId("newKeyword",mod_id);
		var isGlobalSearch;//1全店搜索，0类目下搜索;
		var isGlobalSearch_check = getDOMId("isGlobalSearch",mod_id);
		if( jQuery( isGlobalSearch_check ).attr("checked") ){
			isGlobalSearch=1;
		}else{
			isGlobalSearch=0;
		}
       	
		if( $(showPrice_input).val()=="true" ){
			var minPrice = $(mixPrice_input).val();
    		minPrice= minPrice.replace("￥","");
    		if(minPrice=="" || minPrice=="￥" ) {
    			minPrice=0;
    		}
    		
    		var maxPrice = $(maxPrice_input).val();
    		maxPrice= maxPrice.replace("￥","");			
    		if(maxPrice==""|| maxPrice=="￥") {
    			maxPrice=0;
    		}
		
		}else{
			var minPrice=0;
			var maxPrice=0;
		}
		
		var baseUrl= $(baseUrl_input).val();
		var subfixUrl= $(subfixUrl_input).val();
		var url=baseUrl+minPrice+"-"+maxPrice+subfixUrl;
		
		var keyword=null;
		if( hotwords != null ){
			//$("#keyword").val(hotwords);
			keyword=hotwords;
		}else{
			var d = $(newKeyword_input).attr('d');
			var newKeyword = $(newKeyword_input).val();
			if( newKeyword !=d && newKeyword!= "" ){
				
				keyword = $(newKeyword_input).val();
			}else{
				keyword="";
			}
		}
		//UTF-8(UTF-8);
		keyword = encodeURIComponent(keyword);
		keyword = encodeURIComponent(keyword);
		url = url+"?keyword="+keyword+"&isGlobalSearch="+isGlobalSearch;
		//add catid
		var catid=$(newKeyword_input).attr('catid');
		if(catid!=null && catid!=''){
			url=url+'&catid='+catid;
		}
		window.location.href=url;
		
	}
	
	/**
	 * 兼容2013和SDK 方式获取DOM结点
	 * @return
	 */
	function getDOMId(dom_id,mod_id){
		if( $("#"+dom_id+mod_id).length < 1 ){
			return "#zx_"+dom_id+mod_id;
		}
		return "#"+dom_id+mod_id;
	}
	
	
	
	
	/* 
	* autoComplete 0.1 
	* Copyright 2013 zhangshibin http://www.jd.com/ 
	* Date: 2013-011-06
	*/ 
(function($) {
	
	
	$.fn.autoComplete = function(options) {
		 var opts = $.extend($.fn.autoComplete.defaults, options);
		 var _jInput=$(this);
		 var jAutoContainer=null;
		 var inputId=_jInput.attr('id');
		 var jAutoContainer=$("#autoContainer_"+inputId);
		 //parameter error
		 if(opts.url==null||opts.url==''){
			 return ;
		 }
		 if(jAutoContainer.length>0){ //already initialed
			 return ;
		 }
		 var containerContent='<div id="autoContainer_'+inputId+'" style="'+
		 opts.containerStyle+'" class="'+opts.containerClass+'"></div>';
		 jAutoContainer =$(containerContent).appendTo('body');
		 _jInput.data('autoContainer',jAutoContainer);
		 
		 var mouseOutFlag=false;
		 jAutoContainer.mouseleave(function(){
			 mouseOutFlag=true;
			 setTimeout(function(){
				 if(mouseOutFlag){
					 jAutoContainer.hide();
				 }
			 },2000);
		 });
		 _jInput.mouseleave(function(){
			 mouseOutFlag=true;
			 setTimeout(function(){
				 if(mouseOutFlag){
					 jAutoContainer.hide();
				 }
			 },2000);
		 });
		 jAutoContainer.mouseenter(function(){
			 mouseOutFlag=false;
		 });
		 _jInput.mouseenter(function(){
			 mouseOutFlag=false;
		 });
		 

		 _jInput.keyup(function(){
			 var val=$.trim(_jInput.val());
				if(val==''){
					jAutoContainer.hide();
					_jInput.attr('old_value','');
					return;
				}
				  var oldValue=_jInput.attr('old_value');
				  var keyName=opts.keyName;
				  var params=keyName+"="+val;
				  if(val!=oldValue){
					  	//ajax request
					  _jInput.attr('old_value',val);
					  
					  var getUrl=opts.url+'&'+params;
					  getUrl+='&callback=?';
					  //编码两次
					  getUrl=encodeURI(getUrl);
					  getUrl=encodeURI(getUrl);
					  //jsonP,request
			    		$.ajax({
			    			url : getUrl,
			    			type : 'get',
			    			dataType : 'jsonp',
			    			success : function(result){
			    				handleResult(result,opts,_jInput);
			    			}
			    		});
				  }
		 });
		 _jInput.dblclick(function(){
			 _jInput.attr('old_value','');
			 _jInput.keyup();
		 });
	};
	/*****************/
	function handleResult(data,opts,_jInput){
		var html=opts.handler(data);
		var jAutoContainer=_jInput.data('autoContainer');
		if(html==null || html==''){
			jAutoContainer.html('');
			_jInput.attr('catid','');
			jAutoContainer.hide();
			 return;
		}
		
		var htmlContent='';
		if($.isArray(html)){
			for(var i=0;i<html.length && i<10;i++){
				var dataElement=html[i];
				htmlContent+='<a href="javascript:;" class="'+opts.elementClass+'" keyword="'+dataElement.keyword+'">'+dataElement.keyword+'</a>';
				if(dataElement.cid!=null){
					htmlContent+='<a href="javascript:;" class="JAutoComCate '+opts.elementClass+'" catid="'+dataElement.cid+
					'" keyword="'+dataElement.keyword+'">在<em>'+dataElement.cname+'</em>分类中搜索</a>';
				}
				
			}
			htmlContent+='<a href="javascript:;" class="JAutoComClose '+opts.elementClass+
			'" style="text-align:right">关闭&times;&nbsp;&nbsp;</a>';
		}else{
			htmlContent=html;
		}
		jAutoContainer.html(htmlContent);
		
		//location the div
		var _pos=_jInput.offset();
		jAutoContainer.css({left:_pos.left,
			   top: _pos.top +_jInput.outerHeight(true),
			   width:_jInput.innerWidth()}).show();
		
		var mod_id=_jInput.attr('id');
		if(mod_id.indexOf('newKeyword')!=-1){
			mod_id=mod_id.substring(10);
		}
		jAutoContainer.find("."+opts.elementClass).click(function(){
			var jthis=$(this);
			
			if(!jthis.hasClass('JAutoComClose')){
				_jInput.val(jthis.attr('keyword'));
			}else{
				jAutoContainer.hide();
				return ;
			}
			//按分类查询
			if(jthis.hasClass('JAutoComCate')){
				_jInput.attr('catid',jthis.attr('catid'));
			}else{
				_jInput.attr('catid','');
			}

			doSubmit(jthis.attr('keyword'),mod_id); //自动跳转
			jAutoContainer.hide();

		});

	}

	  // 插件的defaults    
	  $.fn.autoComplete.defaults = {    
	    containerStyle: 'position:absolute;display:none;z-index:1000;background-color:#eeeeee;',
	    containerClass: 'userAutoContainer',
	    elementClass:'JAutoComElement',
	    keyName:'key',
	    type:'json',
	    handler:function(data){
		  return data;
	    }
	  };
	  
	  

	})($);
	


jQuery(document).ready(function(){
	//autoComplete input bind
	$(".JSearchInput").each(function(){
		var _this=$(this);
		var shopId=_this.attr('shopId');
		if(shopId==null||shopId==''){
			return;
		}
		
		$(this).autoComplete({
			url:'http://mall.jd.com/view/autoComplete/getAutoCompleteWords.html?shopId='+shopId,
			handler:function(data){
				 if($.isArray(data) && data.length>0){
						return data;
				 }
				 return '';
			}
		})
	});
	
	
	jQuery(".jMoreOptions").each(function(){
		   var _this=jQuery(this);
		   var modeId=_this.attr('modeId');
		   if(modeId==null||modeId==''){
			return;
		    }
		   var jMoreOpthionsDiv=jQuery("#JMoreOptionsDiv_"+modeId);
		   if(jMoreOpthionsDiv.get(0)==null){
			   jMoreOpthionsDiv=jQuery("#zx_JMoreOptionsDiv_"+modeId);
		   }
		   _this.click(function(){
			if(jMoreOpthionsDiv.is(":hidden")){
				_this.removeClass("jClose");
				_this.addClass("jOpen");
			}else{
				_this.removeClass("jOpen");
				_this.addClass("jClose");
			}
			if( $.browser.msie){
				jMoreOpthionsDiv.toggle();
			}else{
				jMoreOpthionsDiv.slideToggle('normal');
			}
		});
	});

	
 });
	/*
 * author:wanghaixin@jd.com
 * date:20130418
 * ver:v1.0.0
 */

/*
 * Goods-recommend module logics based pseudo-attributes framework
 */
(function($,w){
	w.jshop.module.GoodsRec = {};
	
	$.extend(w.jshop.module.GoodsRec,{
		imgPreview:function(args){
			
			// 定义传入的CSS调用变量
			var _this=this,
				param=$.extend({imgArea:'.jGoodsRecPreview', imgNodeArea:'ul', imgNode:'li', tabArea:'.jGoodsRecTab', tabNode:'.jGoodsRecTab a', defaultClass:'show', slideDirection:'left', timer:'3', subFunction:'transparentEffect'}, args),
				imgArea = $(_this).find(param.imgArea),
				imgNode = $(_this).find(param.imgNode),
				tabArea = $(_this).find(param.tabArea),
				tabNode = $(_this).find(param.tabNode),
				photoName = $(_this).find(param.photoName),
				defaultClass = param.defaultClass,
				timer = !param.timer*1000?3000:param.timer*1000,
				scroll,
				imgNodeArea = $(_this).find(param.imgNodeArea);
			
			//全局变量
			var index = 0,direction = 1,time = null,moveRange = 0,partTime = null,animate = null;
			if(!imgNode.length) return;
			
			/**
			 * 轮播图所有效果
			 */
			/*jshop.module.ridLazy(_this);*/
			var banner = {
				transparentEffect : function(){
					//初始化
					
					// 调用函数
					init();
					triggerThumbnail();
					animate = transparent;
					time = setTimeout(imgMove, timer);
				},
				moveEffect : function(){
					var isTop = (param.slideDirection == 'top')?true:false;
					scroll = (isTop)?"scrollTop":"scrollLeft";
					
					//初始化
					if(isTop){
						imgNodeArea.css({height:10000, width:$(_this).width()});
						imgNode.css({width:imgNode.width(),height:"auto","float":"none",display:"block"});
						moveRange = imgNode.height();
						imgArea[0][scroll] = index * moveRange;
					}else{
						imgNodeArea.css({width:10000});
						imgNode.css({width:imgNode.width(),height:"100%","float":"left",display:"block"});//将这个宽度写在css里，在ie6下面，获取到的父级宽度是被这个元素撑开的宽度
						moveRange = imgNode.width();
						imgArea[0][scroll] = index * moveRange;
					};
					
					// 调用函数
					init();
					triggerThumbnail();
					animate = oneImgMove;
					time = setTimeout(imgMove, timer);
				}
			};
			
			/**
			 * 根据传入的子方法名执行对应的子方法
			 */
			if(banner[param.subFunction])
				banner[param.subFunction].call(_this);
			
			/**
			 * 轮播图初始化
			 */
			function init(){
				$(_this).css({cursor:'pointer'});
				imgArea.css({width:imgNode.width(),height:imgNode.height()});
				imgNode.eq(0).addClass(defaultClass);
				tabNode.eq(0).addClass(defaultClass);
			}
			
			/**
			 * 给每个tab缩略图绑定事件
			 */ 
			function triggerThumbnail(){
				tabNode.each(function(i,elem){
					$(elem).mouseenter(function(){
						imgNode.eq(index).removeClass(defaultClass);
						tabNode.eq(index).removeClass(defaultClass);
						index = i;
						imgNode.eq(index).addClass(defaultClass);
						tabNode.eq(index).addClass(defaultClass);
						animate();
						return false;
					});
				});
			}
			
			/**
			 * 点击箭头或数字时，重置时间
			 */
			function _stop(){
				clearTimeout(time);
				time = null;
				clearTimeout(partTime);
				partTime = null;
				imgNodeArea.clearQueue();
				imgNode.eq(index).clearQueue();
			}
			
			/**
			 * 切换图片和缩略图
			 */ 
			function imgMove(){
				if (direction == 1){
					if (index < imgNode.length - 1){
						classOper([imgNode,tabNode],defaultClass,true);
					}else{
						direction = 0;
						classOper([imgNode,tabNode],defaultClass,false);
					}
				}else{
					if (index > 0){
						classOper([imgNode,tabNode],defaultClass,false);
					}else{
						direction = 1;
						classOper([imgNode,tabNode],defaultClass,true);
					}
				}
				photoName.text(imgNode.eq(index).find("img").attr("title"));
				animate();
			}
			
			/**
			 * 透明效果
			 */
			function transparent(){
				imgNode.animate({
					opacity: 0
				  }, 0, function() {
				  });
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
				imgNode.eq(index).animate({
					opacity: 1
				  }, 1000, function() {
					  _stop();
					  time = setTimeout(imgMove, timer);
				  });
			}
			
			/** 
			 * 移动效果：每一张图片分10次移动
			 */
			function oneImgMove(){
				var nowMoveRange = (index * moveRange) - imgArea[0][scroll],
				partImgRange = nowMoveRange > 0 ? Math.ceil(nowMoveRange / 10) : Math.floor(nowMoveRange / 10);
				imgArea[0][scroll] += partImgRange;
				if (partImgRange == 0){
					imgNode.eq(index).addClass(defaultClass);
					tabNode.eq(index).addClass(defaultClass);
					photoName.text(imgNode.eq(index).find("img").attr("title"));
					partImgRange = null;
					_stop();
					time = setTimeout(imgMove, timer);
				}
				else{
					partTime = setTimeout(oneImgMove,30);	
				}
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
			}

			/**
			 * 节点css类名操作
			 */ 
			function classOper(arr,className,flag){
				arr.each(function(ind,n){
					n.eq(index).removeClass(className);
				})
				flag?(index++):(index--);
				arr.each(function(ind,n){
					n.eq(index).addClass(className);
				});
			}
		}
	});
	
})(jQuery,window);/*
 * author:wanghaixin@jd.com
 * date:20130418
 * ver:v1.0.0
 */

/*
 * Share module logics based pseudo-attributes framework
 */
(function($,w){
	jshop.module.share = {};
	   $.extend(jshop.module.share, jshop.module);
	   
	   $.extend(jshop.module.share, {
		   // 分享模块主方法
			share : function(args){
			   if(args == undefined){
					if(validateData($(this).attr("module-param"))){
						var args = eval('('+$(this).attr("module-param")+')');
					}
				}
			   args.position = args.position == ''?1: parseInt(args.position);
			   args.toTop = args.toTop == ''?'middle' : parseInt(args.toTop);
			   args.toSide = args.toSide == ''? 0 :parseInt(args.toSide);
				var _oSets = jQuery.extend({
					container : '.shareArea',
					entrance : '.jLabel',
					content : '',
					position : 1,
					toTop : 'middle',
					toSide : 0,
					fun : 'defau',
					node : 'li',
					returnTop : '.iconTop',
					close : '.iconClose'
				},args || {}),
				
					_this = this,
					_oContainer = $(_this).find(_oSets.container),
					_oEntrance = $(_this).find(_oSets.entrance),
					_isIE6 = $.browser.msie&&$.browser.version.match(/6.0/),
					_nShowL,_nHideL = $(window).width(),_bFlag = false,_nTop,_nDuration = 1000,
					
					_nConWidth = _oContainer.outerWidth(true), _nLeap = 10 + parseInt(_oSets.toSide), _entranceWidth = _oEntrance.outerWidth(true),
					
					HREF = window.location.href;
					var TITLE = $('title').html();
				if(_oSets.content != null && _oSets.content !=""){
					TITLE = "";
				}
				_oSets.content = encodeURIComponent(_oSets.content);
				MAP = {
					sinaminiblog : 'http://v.t.sina.com.cn/share/share.php?appkey=583395093&title=' + TITLE+' '+ _oSets.content + '&url=' + HREF + '&source=bshare&retcode=0&pic=',
					qqmb : 'http://v.t.qq.com/share/share.php?title=' + TITLE + ' ' +  _oSets.content + '&site=' + HREF + '&pic=&url='+ HREF + '&appkey=dcba10cb2d574a48a16f24c9b6af610c',
					renren : 'http://widget.renren.com/dialog/share?resourceUrl=' + HREF + '&title=' + TITLE + '&images=&description=' + _oSets.content,
					qzone : 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + HREF + '&title=' + TITLE + '&pics=&summary=' + _oSets.content,
					kaixin001 : 'http://www.kaixin001.com/rest/records.php?url='+HREF +'&content=' + _oSets.content+'&pic=&aid=100013770&style=111',
					douban : 'http://www.douban.com/recommend/?url=' + HREF  + '&title=' + TITLE + '&v=1',
					neteasemb : 'http://t.163.com/article/user/checkLogin.do?source=360buy&info=' + TITLE + ' ' + _oSets.content + ' ' + HREF + '&images=',
					meilishuo : 'http://www.meilishuo.com/meilishuo_share?picurl=&siteurl=' + HREF + '&content=' + TITLE + ' ' + _oSets.content,
					mogujie : 'http://www.mogujie.com/mshare?url=' + HREF + '&content=' + TITLE + ' ' + _oSets.content + '&from=mogujie&pic=',
					qqxiaoyou : 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou&url=' + HREF + '&pics=&title=' + TITLE + '&summary=' + _oSets.content,
					facebook : 'http://www.facebook.com/share.php?src=360buy&u=' + HREF,
					twitter : 'http://twitter.com/intent/tweet?text=' + TITLE + ' ' + HREF,
					googleplus : 'https://plus.google.com/share?url=' + HREF + '&hl=zh-CN',
					pinterest : 'https://pinterest.com/login/?next=/pin/create/bookmarklet/?media=&url='+ HREF + '&alt=&title=' + TITLE + '&is_video=false'
					
				};
				
				var _funcs = {
					defau : function(){
						__shareInit();
					},
					entrance : function(){
						if(_isIE6){
							_oEntrance.hide();
							return;
						}
						__fDOMInit();
						__fEventInit();
						__shareInit();
					}
				};
					
				function __shareInit(){
					_oContainer.css({display:'block'});
					$(_this).find(_oSets.node).each(function(i,elem){
						$(elem).click(function(){
							var url = MAP[$(this).attr('id')],
								top = $(window).height() > 400?($(window).height() - 400)/2 : 50,
								left = $(window).width() > 600?($(window).width() - 600)/2 : 50;
							window.open(encodeURI(url),'', 'height=400, width=600,left='+left+',top=' + top);
						});
					});
					$(_this).find(_oSets.returnTop).click(function(){
						$(window).scrollTop(0);
					});
				}	
					
					
				function __fDOMInit(){
					_nShowL = (_oSets.position == "1")?($('body').width() - _nConWidth - _nLeap - _entranceWidth):(_nLeap + _entranceWidth);
					_nHideL = (_oSets.position == "1")?$('html').width():(0-_nConWidth);
					
					_nTop = _oSets.toTop == 'middle' ? parseInt(($(window).height() - _oEntrance.outerHeight())/2):parseInt(_oSets.toTop);
					var _toSide = parseInt(_oSets.toSide) +($.browser.msie?($.browser.version.match(/7.0/)?0:20) : 0);
					
					_oContainer.css({left:_nHideL,top:_nTop - parseInt((_oContainer.outerHeight() - _oEntrance.outerHeight())/2),display:'block'});
					_oEntrance.css({top:_nTop,left:(_oSets.position == '2'?(0+_toSide):($('html').width() - _entranceWidth - _toSide))}).show();
				}
				
				function __onResize(){
					var _toSide = parseInt(_oSets.toSide);
					var f = $(window).height() > _oContainer.outerHeight();
					if(_bFlag){
						_oContainer.css({
							left : (_oSets.position == "1")?($('body').width() - _nConWidth - _nLeap - _entranceWidth):(_nLeap + _entranceWidth)
						});
					}
					else{
						_oContainer.css({
							left : (_oSets.position == "1")?$('html').width():(0-_nConWidth)
						});
					}
					_oEntrance.css({left:(_oSets.position == '2'?(0+_toSide):($(window).width() - _entranceWidth - _toSide))});
					_nHideL = (_oSets.position == "1")?$('html').width():(0-_nConWidth);
					_nShowL = (_oSets.position == "1")?($('body').width() - _nConWidth - _nLeap - _entranceWidth):(_nLeap + _entranceWidth);
				}
				
				function __fEventInit(){
					_oEntrance.click(function(){
						_oContainer.animate({left:_nShowL},_nDuration);
						_bFlag = true;
					});
					_oContainer.find(_oSets.close).click(function(){
						_oContainer.animate({left:_nHideL},_nDuration);
						_bFlag = false;
					});
					
					$(window).resize(__onResize);
				}
				if(_funcs[_oSets.fun]) _funcs[_oSets.fun].call();	
			}
		});
})(jQuery,window);/**
	* @description: html片段轮播图模块方法库
*/
(function() {
   jshop.module.BannerHtml = {};
   $.extend(jshop.module.BannerHtml, jshop.module);
   
   $.extend(jshop.module.BannerHtml, {	
		/*
		 * @function 滑动 20130207
		 * @description 包含透明效果、向左和向上移动效果
		 * @author 
		 * @example <div class="j-module" module-function="slide" module-param="{imgArea:".jbannerImg", imgNode:".jbannerImg li", tabArea:".jbannerTab", tabNode:".jbannerTab span", arrowLeft:".jPreOut", arrowRight:".jNextOut", arrowLeftOver:"jPreOver", arrowRightOver:"jNextOver", defaultClass:"show"}">; 
		 也可以不传使用默认参数：<div class="j-module" module-function="baseSlide" module-param="{}">;
		 
	    * 参数说明
	    * imgArea:".jbannerImg"  所有大图最外层的div
	    * imgNode:".jbannerImg dl" 每一个大图外层的dl
	    * tabArea:".jbannerTab" 所有缩略小图最外层的div
	    * tabNode:".jbannerTab span" 每一个缩略小图的span
	    * photoName:".jDesc" 图片描述
	    * arrowLeft:".jPreOut" arrowRight:".jNextOut" 左箭头和右箭头
	    * arrowLeftOver:"jPreOver", arrowRightOver:"jNextOver" 左箭头和右箭头鼠标移动效果
	    * defaultClass:"show" 给当前显示的图片增加一个样式
	    * message:".jMessageRemind" pageMode:".j-edit-page" 当处于装修页面，同时图片尺寸不符合布局宽度时，显示提示消息
	    * slideDirection:"left" 滑动方向：默认水平向左，可传入"top"，垂直向上滑动
	    * timer:"3" 每一张图片滑动的时间（单位：秒）
		 */
		slide:function(args){
			if(args == undefined){
				if(validateData($(this).attr("module-param"))){
					var args = eval('('+$(this).attr("module-param")+')');
				}
			}
			
			// 定义传入的CSS调用变量
			var _this=this,
				param=$.extend({imgArea:'.jbannerImg', imgNodeArea:'.jImgNodeArea', imgNode:'.jbannerImg li', tabArea:'.jbannerTab', tabNode:'.jbannerTab span', arrowLeft:'.jPreOut', arrowRight:'.jNextOut', arrowLeftOver:'jPreOver', arrowRightOver:'jNextOver', defaultClass:'show', slideDirection:'left', timer:'3', subFunction:'transparentEffect', eventType:'click'}, args),
				imgArea = $(_this).find(param.imgArea),
				imgNode = $(_this).find(param.imgNode),
				tabArea = $(_this).find(param.tabArea),
				tabNode = $(_this).find(param.tabNode),
				photoName = $(_this).find(param.photoName),
				defaultClass = param.defaultClass,
				eventType = param.eventType,
				timer = !param.timer*1000?3000:param.timer*1000,
				scroll,
				ul = $(_this).find(param.imgNodeArea + '>ul'),
				imgNodeArea = $(_this).find(param.imgNodeArea),
				isFull = param.isFull;

			//全局变量
			var index = 0,direction = 1,time = null,moveRange = 0,partTime = null,animate = null;
			if(!imgNode.length) return;
			jshop.module.ridLazy($(this));
			
			/**
			 * 轮播图所有效果
			 */
			var banner = {
				transparentEffect : function(){
					//初始化
					$(_this).css({'background-color':imgNode.eq(index).attr('background')});
					
					// 调用函数
					init();
					triggerThumbnail();
					triggerDirection();
					animate = transparent;
					time = setTimeout(imgMove, timer);
				},
				moveEffect : function(){
					var isTop = (param.slideDirection == 'top')?true:false;
					scroll = (isTop)?"scrollTop":"scrollLeft";
					
					//初始化
					$(_this).css({'background-color':imgNode.eq(index).attr('background')});
					if(isTop){
						imgNodeArea.css({height:20000});
						imgNode.css({width:imgNode.attr("width"),height:imgNode.attr("height")});
						moveRange = imgNode.height();
						imgArea[0][scroll] = index * moveRange;
					}else{
						imgNodeArea.css({width:20000});
						imgNode.css({width:imgNode.attr("width"),height:imgNode.attr("height"),'float':"left"});//将这个宽度写在css里，在ie6下面，获取到的父级宽度是被这个元素撑开的宽度
						moveRange = imgNode.width();
						imgArea[0][scroll] = index * moveRange;
					};
					
					// 调用函数
					init();
					triggerThumbnail();
					triggerDirection();	
					animate = oneImgMove;
					time = setTimeout(imgMove, timer);
				}
			};
			
			/**
			 * 根据传入的子方法名执行对应的子方法
			 */
			if(banner[param.subFunction])
				banner[param.subFunction].call(_this);
			
			/**
			 * 轮播图初始化
			 */
			function init(){
				imgArea.css({width:imgNode.attr("width"),height:imgNode.attr("height")});
				imgNode.eq(0).addClass(defaultClass);
				tabNode.eq(0).addClass(defaultClass);
				autoMiddle();
				$(window).resize(function(){
					autoMiddle();
				});
			}
			
			/**
			 * 轮播图自适应居中于屏幕中间
			 */
			function autoMiddle(){
				var extra = imgArea.width()-$(_this).width();
				if(extra>0){
					imgArea.css({'margin-left':-extra/2});
				}else{
					imgArea.css('margin','0 auto');
				}
			}
			
			/**
			 * 给每个tab缩略图绑定事件
			 */ 
			function triggerThumbnail(){
				tabNode.each(function(i,elem){
					$(elem)[eventType](function(){			   
						imgNode.eq(index).removeClass(defaultClass);
						tabNode.eq(index).removeClass(defaultClass);
						index = i;
						imgNode.eq(index).addClass(defaultClass);
						tabNode.eq(index).addClass(defaultClass);
						animate();
						return false;
					});
				});
			}
			
			/**
			 * 点击箭头或数字时，重置时间
			 */
			function _stop(){
				clearTimeout(time);
				time = null;
				clearTimeout(partTime);
				partTime = null;
				ul.clearQueue();
				imgNode.eq(index).clearQueue();
			}
			
			/**
			 * 切换图片和缩略图
			 */ 
			function imgMove(){
				if (direction == 1){
					if (index < imgNode.length - 1){
						classOper([imgNode,tabNode],defaultClass,true);
					}else{
						direction = 0;
						classOper([imgNode,tabNode],defaultClass,false);
					}
				}else{
					if (index > 0){
						classOper([imgNode,tabNode],defaultClass,false);
					}else{
						direction = 1;
						classOper([imgNode,tabNode],defaultClass,true);
					}
				}
				animate();
			}
			
			/**
			 * 处理左右移动箭头
			 */
			function triggerDirection(){
				var arrowLeft = $(_this).find(param.arrowLeft),arrowRight = $(_this).find(param.arrowRight),
					arrowLeftOver = param.arrowLeftOver, arrowRightOver = param.arrowRightOver;
				
				arrowLeft.bind({
					click:function(){
						if(index != 0){// 判断当前是不是第一张
							classOper([imgNode,tabNode],defaultClass,false);
							animate();
						}
						return false;
					},
					mouseover:function(){$(this).addClass(arrowLeftOver);},
					mouseout:function(){$(this).removeClass(arrowLeftOver);}
				});
				arrowRight.bind({
					click:function(){
						if(index < imgNode.length - 1){// 判断当前是不是最后一张
							classOper([imgNode,tabNode],defaultClass,true);
							animate();
						}
						return false;
					},
					mouseover:function(){$(this).addClass(arrowRightOver);},
					mouseout:function(){$(this).removeClass(arrowRightOver);}
				});
			}
			
			/**
			 * 透明效果
			 */
			function transparent(){
				imgNode.animate({
				    opacity: 0
				  }, 0, function() {
				  });
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
				imgNode.eq(index).animate({
				    opacity: 1
				  }, 1000, function() {
					  _stop();
					  time = setTimeout(imgMove, timer);
				  });
				
			}
			
			/** 
			 * 移动效果：每一张图片分10次移动
			 */
			function oneImgMove(){
				var nowMoveRange = (index * moveRange) - imgArea[0][scroll],
				partImgRange = nowMoveRange > 0 ? Math.ceil(nowMoveRange / 10) : Math.floor(nowMoveRange / 10);
				imgArea[0][scroll] += partImgRange;
				if (partImgRange == 0){
					imgNode.eq(index).addClass(defaultClass);
					tabNode.eq(index).addClass(defaultClass);
					partImgRange = null;
					_stop();
					time = setTimeout(imgMove, timer);
				}
				else{
					partTime = setTimeout(oneImgMove,30);	
				}
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
			}

			/**
			 * 节点css类名操作
			 */ 
			function classOper(arr,className,flag){
				arr.each(function(ind,n){
					n.eq(index).removeClass(className);
				})
				flag?(index++):(index--);
				arr.each(function(ind,n){
					n.eq(index).addClass(className);
				});
			}
		}
	});
})(jQuery);

/***
 * 轮播图（兼容老数据）
 */
(function(a) {
	a.fn.jdSlide = function(k) {
		var p = a.extend({
			width: null,
			height: null,
			pics: [],
			index: 0,
			type: "num",
			current: "curr",
			delay1: 100,
			delay2: 5000
		},
		k || {});
		if(p.pics.length ==0) return;
		var i = this;
		var g, f, d, h = 0,
		e = true,
		b = true;
		var n = p.pics.length;
		var o = function() {
			var q = "<ul style='position:absolute;top:0;left:0;'><li><a href='" + p.pics[0].href + "' target='_blank'><img src='" + p.pics[0].src + "' width='" + p.width + "' height='" + p.height + "' /></a></li></ul>";
			i.css({
				position: "relative"
			}).html(q);
			a(function() {
				c();
			});
		};
		var j = function() {
			var s = [];
			s.push("<div>");
			var r;
			var q;
			for (var t = 0; t < n; t++) {
				r = (t == p.index) ? p.current: "";
				switch (p.type) {
				case "num":
					q = t + 1;
					break;
				case "string":
					q = p.pics[t].alt;
					break;
				case "image":
					q = "<img src='" + p.pics[t].breviary + "' />";
				default:
					break;
				}
				s.push("<span class='");
				s.push(r);
				s.push("'><a href='");
				s.push(p.pics[t].href);
				s.push("' target='_blank'>");
				s.push(q);
				s.push("</a></span>");
			}
			s.push("</div>");
			i.append(s.join(""));
			i.find("span").bind("mouseover",
			function() {
				b = false;
				clearTimeout(g);
				clearTimeout(d);
				var u = i.find("span").index(this);
				if (p.index == u) {
					return;
				} else {
					d = setInterval(function() {
						if (e) {
							l(u);
						}
					},
					p.delay1);
				}
			}).bind("mouseleave",
			function() {
				b = true;
				clearTimeout(g);
				clearTimeout(d);
				g = setTimeout(function() {
					l(p.index + 1, true);
				},
				p.delay2);
			});
		};
		var l = function(r, q) {
			if (r == n) {
				r = 0;
			}
			f = setTimeout(function() {
				i.find("span").eq(p.index).removeClass(p.current);
				i.find("span").eq(r).addClass(p.current);
				m(r, q);
			},
			20);
		};
		var m = function(u, q) {
			var s = parseInt(h);
			var v = Math.abs(s + p.index * p.height);
			var t = Math.abs(u - p.index) * p.height;
			var r = Math.ceil((t - v) / 4);
			if (v == t) {
				clearTimeout(f);
				if (q) {
					p.index++;
					if (p.index == n) {
						p.index = 0;
					}
				} else {
					p.index = u;
				}
				e = true;
				if (e && b) {
					clearTimeout(g);
					g = setTimeout(function() {
						l(p.index + 1, true);
					},
					p.delay2);
				}
			} else {
				if (p.index < u) {
					h = s - r;
					i.find("ul").css({
						top: h + "px"
					});
				} else {
					h = s + r;
					i.find("ul").css({
						top: h + "px"
					});
				}
				e = false;
				f = setTimeout(function() {
					m(u, q);
				},
				20);
			}
		};
		var c = function() {
			var q = [];
			for (var r = 1; r < n; r++) {
				q.push("<li><a href='");
				q.push(p.pics[r].href);
				q.push("' target='_blank'><img src='");
				q.push(p.pics[r].src);
				q.push("' width='");
				q.push(p.width);
				q.push("' height='");
				q.push(p.height);
				q.push("' /></a></li>");
			}
			i.find("ul").append(q.join(""));
			g = setTimeout(function() {
				l(p.index + 1, true);
			},
			p.delay2);
			if (p.type) {
				j();
			}
		};
		o();
	};
})(jQuery);