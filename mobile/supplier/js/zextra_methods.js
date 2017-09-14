;(function($, undefined){
	$.getScript = function(src, async ,func) {
		var script = document.createElement('script');
		if(typeof(async) === 'undefined')
		{
			script.async = "async";
		}
		else if(async === false)
		{
			script.async = false;
			script.defer = 'defer';
		}
		script.src = src;
		if (func) {
		   script.onload = func;
		}
		document.getElementsByTagName("head")[0].appendChild( script );
	}
})(Zepto)