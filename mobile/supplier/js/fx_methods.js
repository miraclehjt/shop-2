//     Zepto.js
//     (c) 2010-2015 Thomas Fuchs
//     Zepto.js may be freely distributed under the MIT license.

;(function($, undefined){
  var document = window.document, docElem = document.documentElement,
    origShow = $.fn.show, origHide = $.fn.hide, origToggle = $.fn.toggle

  function anim(el, speed, opacity, scale, callback) {
    if (typeof speed == 'function' && !callback) callback = speed, speed = undefined
    var props = { opacity: opacity }
    if (scale) {
      props.scale = scale
      el.css($.fx.cssPrefix + 'transform-origin', '0 0')
    }
    return el.animate(props, speed, null, callback)
  }

  function hide(el, speed, scale, callback) {
    return anim(el, speed, 0, scale, function(){
      origHide.call($(this))
      callback && callback.call(this)
    })
  }

  $.fn.show = function(speed, callback) {
    origShow.call(this)
    if (speed === undefined) speed = 0
    else this.css('opacity', 0)
    return anim(this, speed, 1, '1,1', callback)
  }

  $.fn.hide = function(speed, callback) {
    if (speed === undefined) return origHide.call(this)
    else return hide(this, speed, '0,0', callback)
  }

  $.fn.toggle = function(speed, callback) {
    if (speed === undefined || typeof speed == 'boolean')
      return origToggle.call(this, speed)
    else return this.each(function(){
      var el = $(this)
      el[el.css('display') == 'none' ? 'show' : 'hide'](speed, callback)
    })
  }

  $.fn.fadeTo = function(speed, opacity, callback) {
    return anim(this, speed, opacity, null, callback)
  }

  $.fn.fadeIn = function(speed, callback) {
    var target = this.css('opacity')
    if (target > 0) this.css('opacity', 0)
    else target = 1
    return origShow.call(this).fadeTo(speed, target, callback)
  }

  $.fn.fadeOut = function(speed, callback) {
    return hide(this, speed, null, callback)
  }

  $.fn.fadeToggle = function(speed, callback) {
    return this.each(function(){
      var el = $(this)
      el[
        (el.css('opacity') == 0 || el.css('display') == 'none') ? 'fadeIn' : 'fadeOut'
      ](speed, callback)
    })
  }

$.fn.slideIn = function (speed,callback) {
	var target = this;
	if(target.hasClass('slideOn'))
	{
		return;
	}
	target.css(
	{
		display:'block',
	});
	
	var height = target.css('height');
	var marginTop = target.css('margin-top');
	var marginBottom = target.css('margin-bottom');
	var paddingTop = target.css('padding-top');
	var paddingBottom = target.css('padding-bottom');
	target.css({
		opacity:1,
		overflow: 'hidden',
		height: 0,
		marginTop: 0,
		marginBottom: 0,
		paddingTop: 0,
		paddingBottom: 0
	});
	target.addClass('slideOn');
	target.animate(
	{
		height: height,
		marginTop: marginTop,
		marginBottom: marginBottom,
		paddingTop: paddingTop,
		paddingBottom: paddingBottom
	},
	{ 
		duration: speed,
		queue: false,
		complete:function()
		{
			target.removeClass('slideOn');
			if($.isFunction(callback))callback();
		}
	});
};

$.fn.slideOut = function (speed,callback) 
{
	if (this.height() > 0 && this.css('opacity') > 0 && this.css('display') != 'none')
	{
		var target = this;
		if(target.hasClass('slideOn'))
		{
			return;
		}
		var position = target.css('position');
		var height = target.css('height');
		var marginTop = target.css('margin-top');
		var marginBottom = target.css('margin-bottom');
		var paddingTop = target.css('padding-top');
		var paddingBottom = target.css('padding-bottom');

		target.css({
			visibility: 'visible',
			overflow: 'hidden',
			height: height,
			marginTop: marginTop,
			marginBottom: marginBottom,
			paddingTop: paddingTop,
			paddingBottom: paddingBottom
		});
		target.addClass('slideOn');
		target.animate(
			{
				height: 0,
				marginTop: 0,
				marginBottom: 0,
				paddingTop: 0,
				paddingBottom: 0
			},
			{ 
				duration: speed,
				queue: false,
				complete: function()
				{
					target.css(
					{
						visibility: 'visible',
						overflow: 'hidden',
						display:'none',
						opacity:0,
						height: height,
						marginTop: marginTop,
						marginBottom: marginBottom,
						paddingTop: paddingTop,
						paddingBottom: paddingBottom
					});
					target.removeClass('slideOn');
					if($.isFunction(callback))callback();
				}
			}
		);
	}
};

$.fn.slideToggle = function (speed,callback) {
	if (this.height() == 0 || this.css('opacity') == 0 || this.css('display') == 'none') {
		this.slideIn(speed);
	}
	else {
		this.slideOut(speed);
	}
};

$.fn.slideLeftOut = function(duration,callback)
{
	var target = this;
	var position = target.position;
	var width = target.width();
	target.css({
		position:'relative',
		left:0,
		top:0});
	target.animate(
	{
		left:0-Math.abs(width)
	},
	{
		duration:duration,
		queue:false,
		complete:function()
		{
			target.css({display:'none',position:position});
			if($.isFunction(callback))
			{
				callback();
			}
		}
	});
};
$.fn.slideLeftIn = function(duration,callback)
{
	var target = this;
	var position = target.position;
	target.css(
	{
		display:'block',
	})
	var width = target.width();
	target.css(
	{
		position:'relative',
		left:width,
		top:0
	})
	target.animate(
	{
		left:0	
	},
	{
		duration:duration,
		queue:false,
		complete:function()
		{
			target.css({position:position});
			if($.isFunction(callback))
			{
				callback();
			}
		}
	}	
	)
}
$.fn.slideRightOut = function(duration,callback)
{
	var target = this;
	var position = target.position;
	var width = target.width();
	target.css({
		position:'relative',
		left:0,
		top:0});
	target.animate(
	{
		left:width
	},
	{
		duration:duration,
		queue:false,
		complete:function()
		{
			target.css({display:'none',position:position});
			if($.isFunction(callback))
			{
				callback();
			}
		}
	});
};
$.fn.slideRightIn = function(duration,callback)
{
	var target = this;
	var position = target.position;
	target.css(
	{
		display:'block',
	})
	var width = target.width();
	target.css(
	{
		position:'relative',
		left:0-Math.abs(width),
		top:0
	})
	target.animate(
	{
		left:0	
	},
	{
		duration:duration,
		queue:false,
		complete:function()
		{
			target.css({position:position});
			if($.isFunction(callback))
			{
				callback();
			}
		}
	}	
	)
}
$.fn.slideLeftToggle = function(duration,callback)
{
	if(this.css('display') == 'none')
	{
		this.slideLeftIn(duration,callback);
	}
	else
	{
		this.slideLeftOut(duration,callback);
	}
}
})(Zepto)