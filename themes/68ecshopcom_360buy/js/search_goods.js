$(function(){
    /* 筛选事件 */
    $('span[nctype="span_filter"]').click(function(){
    	_i = $(this).find('i');
    	location.assign($(this).find('i').attr('data-uri'));
        return false;
    });
    $("#search_by_price").click(function(){
        replaceParam('price', $(this).siblings("input:first").val() + '-' + $(this).siblings("input:last").val());
        return false;
    });



    //鼠标经过弹出图片信息
/*    $(".item").hover(
        function() {
            $(this).find(".goods-info").animate({"top": "180px"}, 400, "swing");
        },function() {
            $(this).find(".goods-info").stop(true,false).animate({"top": "230px"}, 400, "swing");
        }
    );*/
    // 加入购物车
   /* $('a[nctype="add_cart"]').click(function() {
        var _parent = $(this).parent(), thisTop = _parent.offset().top, thisLeft = _parent.offset().left;
        animatenTop(thisTop, thisLeft), !1;
        eval('var data_str = ' + $(this).attr('data-param'));
        addcart(data_str.goods_id,1,'');
    });*/
    // 立即购买
    $('a[nctype="buy_now"]').click(function(){
        eval('var data_str = ' + $(this).attr('data-param'));
        $("#goods_id").val(data_str.goods_id+'|1');
        $("#buynow_form").submit();
    });
    $('a[nctype="arrival_notice"]').click(function(){
        eval('var data_str = ' + $(this).attr('data-param'));
        ajaxget(data_str.url);
    });
    // 图片切换效果
    $('.goods-pic-scroll-show').find('a').mouseover(function(){
        $(this).parents('li:first').addClass('selected').siblings().removeClass('selected');
        var _src = $(this).find('img').attr('src');
        _src = _src.replace('_60.', '_240.');
        $(this).parents('.goods-content').find('.goods-pic').find('img').attr('src', _src);
    });
});
/*function animatenTop(thisTop, thisLeft) {
    var CopyDiv = '<div id="box" style="top:' + thisTop + "px;left:" + thisLeft + 'px" ></div>', topLength = $(".my-cart").offset().top, leftLength = $(".my-cart").offset().left;
    $("body").append(CopyDiv), $("body").children("#box").animate({
        "width": "0",
        "height": "0",
        "margin-top":"0",
        "top": topLength,
        "left": leftLength,
        "opacity": 0
    }, 1000, function() {
        $(this).remove();
    });
}*/

function setcookie(name,value){
    var Days = 30;   
    var exp  = new Date();   
    exp.setTime(exp.getTime() + Days*24*60*60*1000);   
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();   
}

/* 替换参数 */
function replaceParam(key, value, arg)
{
	if(!arguments[2]) arg = 'string';
    var params = PURL;
    var found  = false;
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        // 如果存在分页，跳转到第一页
        if (pKey == 'curpage')
        {
            params[i] = 'curpage=1';
        }
        if(arg == 'string'){
	        if (pKey == key)
	        {
	            params[i] = key + '=' + value;
	            found = true;
	        }
        }else{
        	for(var j = 0; j < key.length; j++){
        		if(pKey ==  key[j]){
        			params[i] = key[j] + '=' + value[j];
    	            found = true;
        		}
        	}
        }
    }
    if (!found)
    {
        if (arg == 'string'){
            value = transform_char(value);
            params.push(key + '=' + value);
        }else{
        	for(var j = 0; j < key.length; j++){
        		params.push(key[j] + '=' + transform_char(value[j]));
        	}
        }
    }
    location.assign(SITEURL + '/index.php?' + params.join('&'));
}

/* 删除参数 */
function dropParam(key, id, arg)
{
	if(!arguments[2]) arg = 'string';
    var params = location.search.substr(1).split('&');
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        if(arg == 'string'){

	        if (pKey == key)
	        {
	            params.splice(i, 1);
	        }
        }else if(arg == 'del'){
            pVal = arr[1].split(',')
            for (var j=0; j<pVal.length; j++){
            	if(pKey == key && pVal[j] == id){
            		pVal.splice(j, 1);
            		params.splice(i, 1, pKey+'='+pVal);
            	}
            }
        }else{
        	for(var j = 0; j < key.length; j++){
        		if(pKey == key[j]){
        			params.splice(i, 1);i--;
        		}
        	}
        }
    }
    location.assign(SITEURL + '/index.php?' + params.join('&'));
}
