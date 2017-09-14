$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */

	/* 改变thedefault宽松政策效应——将影响slideUp / slideDown方法: */
	$.easing.def = "easeOutBounce";

	/* 绑定一个单击事件处理程序的链接: */
	$('li.button a').click(function(e){
	
	$('li.button a span').removeClass("add");
		/* 找到相对应的下拉列表中当前的部分: */
		var dropDown = $(this).parent().next();
		if(dropDown.css("display")=="none")
		{
			var idsf = dropDown.attr('id');
			var faid = "#fa_"+idsf;
			$(faid).addClass("add");
		}
		else
		{
			var idsf = dropDown.attr('id');
			var faid = "#fa_"+idsf;
			$(faid).removeClass("add");
		}
		
		/* 关闭所有其他下降部分,除了选中那项 */
		$('.dropdown').not(dropDown).slideUp('slow');
		dropDown.slideToggle('slow');
		
		
		
	
		/* 防止违约事件(这将是浏览器导航链接的地址) */
		e.preventDefault();
	})
	
});