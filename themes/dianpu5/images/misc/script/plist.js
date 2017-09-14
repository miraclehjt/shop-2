(function($) {
	$.extend({
		_jsonp : { 
			scripts: {},
			//charset: 'utf-8',
			counter: 1,
			head: document.getElementsByTagName("head")[0],
			name: function( callback ) {
				var name = '_jsonp_' +  (new Date).getTime()
					+ '_' + this.counter;
				this.counter++;
				var cb = function( json ) {
					eval( 'delete ' + name );
					callback( json );
					$._jsonp.head.removeChild( $._jsonp.scripts[ name ] );
					delete $._jsonp.scripts[ name ];
				};
				eval( name + ' = cb' );
				return name;
			},
			load: function( url, name ) {
				var script = document.createElement( 'script' );
				script.type    = 'text/javascript';
				script.charset = this.charset;
				script.src     = url;
				this.head.appendChild( script );
				this.scripts[ name ] = script;
			}
		},

		getJSONP : function ( url, callback ){
			var name = $._jsonp.name( callback );
			var url = url.replace( /{callback}/, name );
			$._jsonp.load( url, name );
			return this;
		}
	});
})(jQuery);

$(
	function()
	{
		refreshCommentCount();
	});

function getCommentCount(result)
{
	if (result.CommentCount != null)
	{
		$("#pl{0}".format(result.CommentCount.ReferenceId)).text(result.CommentCount.Count);
	}
}

function refreshCommentCount()
{
    $("span[id^=pl]").each(
	    function()
	    {
		    var referenceId = $(this).attr("id").replace("pl", "");
		    if (referenceId != "")
		    {
			    $.getJSONP(
				    "#".format(referenceId),
				    getCommentCount);
		    }
	    });
}