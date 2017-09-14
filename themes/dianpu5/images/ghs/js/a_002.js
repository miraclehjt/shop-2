
/*
 * author:wanghaixin@jd.com
 * date:20130516
 * ver:v1.0.0
 */

(function($,w){

	$(function(){
		/*
		 * no-margin logics
		 */
		function _no_margin_handle(){
			$('.J-layout').each(function(index,n){
				var m = $(n),_flag = true;
				m.children('div').each(function(index,n){
					if($(n).children('[instanceid]').length)
						_flag = false;
				});
				if(!_flag)
					m.parents('.J-layout-area').addClass('no-margin');
			});
		}
		/*
		 * 背景锁定功能
		 */
		function _background_fixed_handle(){
			if($('.layout-main').length){
				var _is_fixed = parseInt($('.layout-main').attr('isfixed')),
				_TOP = $('.layout-main').offset().top,
				_decorate_flag = typeof gConfig != 'undefined';
			}
			
			
			if(_is_fixed){
				$(_decorate_flag?'.layout-container':window).scroll(function(){
					var __top = $(this).scrollTop();

					if(__top >= _TOP){
						$('.layout-main').css('background-attachment','fixed');
					}
					else{
						$('.layout-main').css('background-attachment','scroll');
					}
				});
			}
			
		}
		_no_margin_handle();
		_background_fixed_handle();
	});
	w.window2013CSS = function(obj,css){
		var _css = css,
			_mutant_css = gBase.JSONClone(css),
			_side_bar = $('#slide_bar_area'),
			_extra_value = _side_bar.length&&!_side_bar.hasClass('off')?185:0;
		if(!$('#slide_bar_area').length){
			obj.css(_css);
			return;
		}
		if(_mutant_css.left){
			_mutant_css.left = _mutant_css.left.match(/%/g)?($(window).width() + _extra_value)*parseInt(_mutant_css.left)/100 + 'px':_mutant_css.left; 
		}
		if(_mutant_css.right){
			_mutant_css.right = _mutant_css.right.match(/%/g)?($(window).width() - _extra_value)*parseInt(_mutant_css.right)/100 + 'px':_mutant_css.right;
		}
		if(typeof gBase.fGetUrlParms()['veBean.open'] == 'undefined' || gBase.fGetUrlParms()['veBean.open'] === '1'){
			obj.css(_mutant_css);
		}
		else{
			obj.css(_css);
			
		}
		$(window).bind('sidebarchange',function(e,collapse){
			if(collapse){
				obj.css(_mutant_css);
			}
			else{
				obj.css(_css);
			}
		});
	};
	
	w.window2013scroll = function(handler){
		if($('#slide_bar_area').length){
			$('.J-layout-container').scroll(function(){
				handler.call(this);
			});
		}
		else{
			$(window).scroll(function(){
				handler.call(this);
			});
		}
	};
	
	w.window2013scrollTop = function(){
		return $('#slide_bar_area').length?$('.J-layout-container').scrollTop():$(window).scrollTop();
	};
})(jQuery,window);