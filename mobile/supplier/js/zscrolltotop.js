;(function($) {
    $.fn.scrollToTop = function(speed) {
        var config = {
            "speed" : 200
        };

        if (speed) {
            $.extend(config, {
                "speed" : speed
            });
        }

        return this.each(function() {

            var $this = $(this);

            $(window).on('scroll',function(e)
			{
				if ($(window).scrollTop() > 100)
				{
                    $this.show();
                } 
				else
				{
					$this.hide();
                }
			});

			$this.on('click', function(e) {
			  $.scrollTo({
				endY: 0, // position to scroll to
				duration: config.speed, // duration of animation. 0 for no animation
				callback: function() { // optional callback to be executed at the end of animation.
				  //alert('at the top');
				}
			  });
			});
        });
    };
})(Zepto);