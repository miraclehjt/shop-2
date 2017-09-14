// JavaScript Document

window.onload = function() {
	
	var myPhotoSwipe = $("#gallery a").photoSwipe({ 
		enableMouseWheel: false, 
		enableKeyboard: false, 
		allowUserZoom: false, 
		loop:false
	});

};

$(document).ready(function(){

	setTimeout(function() { window.scrollTo(0, 1) }, 100);
	
	var slider = new Swipe(document.getElementById('slider'));

	$('.next-but-swipe').click(function(){
		slider.next();
		return false;
	});
	
	$('.prev-but-swipe').click(function(){
		slider.prev();
		return false;
	});


	$('.toggle-plus').click(function(){
		$(this).toggleClass('toggle-plus-selected');
		$(this).parent().find('.toggle-content').toggle(100);
		return false;
	});
	
	$('.toggle-arrow').click(function(){
		$(this).toggleClass('toggle-arrow-selected');
		$(this).parent().find('.toggle-content').toggle(100);
		return false;
	});


	$(".notification-quit-red").click(function(){
	  $(".notification-box-red").hide("slow");
	  return false;
	});
	
	$(".notification-quit-green").click(function(){
	  $(".notification-box-green").hide("slow");
	  return false;
	});
	
	$(".notification-quit-yellow").click(function(){
	  $(".notification-box-yellow").hide("slow");
	  return false;
	});
	
	$(".notification-quit-blue").click(function(){
	  $(".notification-box-blue").hide("slow");
	  return false;
	});


});