$(function(){	
	var t=false;
	var j=1;	
	$("#ctrl1 span").each(function(i){
		$(this).mouseover(function(){
			if(i<4)
			{
				j = i;
			}
			else
			{
				j = -1;
			}
			$(this).addClass("hov").siblings(".hov").removeClass("hov");
			$("#img1 img:visible").fadeOut(500,function(){
				$("#img1 img").eq(i).fadeIn(500,function(){
					$("#msg1 li:visible").hide();
					$("#msg1 li").eq(i).show();					
				})				
			});	
		});
	})	
	
})

// JavaScript Document// JavaScript Document