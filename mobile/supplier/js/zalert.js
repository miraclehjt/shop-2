/**
 * == zalert!.js ==
 * A simple jQuery/Zepto notification library designed to be used in mobile apps
 *
 * author: Justin Domingue
 * date: september 5, 2013
 * version: 0.1.3
 * copyright - nice copyright over here
 */

/* Shows a toast on the page
 * Params:
 *  text: text to show
 *  color: color of the toast. one of red, green, blue, orange, yellow or custom
*/
;(function($) {
	var time;
	var $container; 
        
	function zalert(text, color, icon,url) {
		time = '1500';
		$container = $('#zalert');
		var icon_markup = '';
		var html = '';
		var _url = '';
		if (icon) {
			icon_markup = "<span class='" + icon + "'></span> ";
		}

		if(url)
		{
			if(typeof(url) === 'string')
			{
				_url = '<a class="zalert-link" href="'+url+'">请点击链接</a>';
			}
			else if(typeof(url) === 'object')
			{
				_url = '<a class="zalert-link" href="'+url.href+'">'+url.html+'</a>';
			}
		}

		// Generate the HTML
		html = $('<div class="zalert zalert-' + color + '">' + icon_markup + text + '&nbsp;' + _url + '</div>').fadeIn('fast');

		// Append the label to the container
		$container.append(html);

		// Remove the notification on click
		html.on('click', function() {
			zalertX($(this));
		});

		// After 'time' seconds, the animation fades out
		setTimeout(function() {
			zalertX(html);
		}, time);
	}

	function zalertX(element) {
		// Called without argument, the function removes all alerts
		// element must be a jQuery object

		if (typeof element !== "undefined") {
			element.fadeOut('fast', function() {
				element.remove();
			});
		} else {
			$('.alert').fadeOut('fast', function() {
				$(this).remove();
			});
		}
	}
	$.zalert = {
		//params:
		//content:消息内容
		//type:弹窗消息类型，0消息，1错误
		//url:弹窗上的链接
		add:function(content,type,url)
		{
			if(type === 0 || typeof(type) === 'undefined')
			{
				zalert(content,'blue','zalert_normal_icon',url);
			}
			else if(type === 1)
			{
				zalert(content,'red','zalert_error_icon',url);
			}
		},
		clear:function()
		{
			zalertX();
		},
		remove:function(element)
		{
			zalertX(element);
		}
	}
})(Zepto)