//ÏÔÊ¾²Ëµ¥
function show_menu() {
	var bd_top = $(document).scrollTop();
	if($('#menu').css('display')=='none') {
		$('#menu').removeClass('hid');
		$('#menu').addClass('show');
		if(/iphone/i.test(navigator.userAgent) || (Sys.uc >= 9 && bd_top<300)) {
			$('#hed_id').removeClass('hd_box_float');
			$('#play_box').removeClass('p48');
			$('.mnav').css({"position":"relative"});
		}
		setcookie('hidtips','1'); 
	} else {
		$('#menu').removeClass('show');
		$('#menu').addClass('hid');
		if(/iphone/i.test(navigator.userAgent) || (Sys.uc >= 9 && bd_top<300)) {
			$('#hed_id').addClass('hd_box_float');
			$('#play_box').addClass('p48');
			$('.mnav').css({"position":"absolute"});
		}
		setcookie('hidtips','1'); 
	}
 }
 
(function(){
   var $nav = $('.goods_nav');
   $(window).on("scroll", function() {	
   $('#menu').removeClass('show');	
	$('#menu').addClass('hid');
	});
 })();