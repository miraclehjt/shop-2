/*publish time:2012-12-06 14:53 yk*/
//compare();
(function(){
	if (typeof jdwsment!="object"){
		return;
	}
	var url="#/PromotionFlag.aspx?pid="+jdwsment.skuids+"&jsoncallback=?";
	$.getJSON(url,function (json){
		if (!json){return;}
		json=json.data;
		var pInfo,prdbuy;
		for (var i=0;i<json.length;i++){
			pInfo="";
			prdbuy = $("#p"+json[i].Pid+" .pt5").length>0;
			for (var j=0;j<json[i].PF.length;j++){
				switch (json[i].PF[j]){
					case 1:
						pInfo+="<a class=\"pt1\" title=\"本商品正在降价销售中\">直降</a>";
						break;
					case 2:
						pInfo+="<a class=\"pt2\" title=\"购买本商品送赠品\">赠品</a>";
						break;
					case 3:
						pInfo+="<a class=\"pt3\" title=\"购买本商品返优惠券\">返券</a>";
						break;
					case 4:
						pInfo+="<a class=\"pt4\" title=\"购买本商品送积分\">送积分</a>";
						break;
					default:
						break;
				}
				if(prdbuy&&pInfo){$(pInfo).insertBefore("#p"+json[i].Pid+" .pt5");break;}
			}
			if(!prdbuy)$("#p"+json[i].Pid).html(pInfo);
		}
	});
})();
var  GetJdwsmentsCallback = function(json) {
	if (json.AdWordList){
		 for (var i=0; i<json.AdWordList.length; i++) {
			var object=$("#plist li[sku='"+json.AdWordList[i].wid +"']"),adTitle=json.AdWordList[i].waretitle;
			if (object.length){
				object.find(".p-img").find("img").attr("title",adTitle);
				object.find(".p-name").find("a").attr("title",adTitle);
				object.find(".adwords").html(adTitle);
			}
		 }
	}
};
(function(){
	if (typeof jdwsment!="object"){
		return;
	}
	var AdServiceUrl = "#/ProductsAdWordListHandler.ashx";
	$.getJSONP(AdServiceUrl + "?callback=GetJdwsmentsCallback&action=GetJdwsment&wids="+jdwsment.skuids+"&key="+jdwsment.key,GetJdwsmentsCallback);
})();
(function($) {
    // the jQuery prototype
    $.fn.imgScroll = function(opts) {
        // loop though elements and return the jQuery instance
        return this.each(function() {
            var options = $.extend({
                evtType: 'click',
                visible: 1,
                showControl: true,
                showNavItem: false,
                navItemEvtType: 'click',
                navItemCurrent: 'current',
                showStatus: false,
                direction: 'x',
                next: '.next',
                prev: '.prev',
                disableClass: 'disabled',
                speed: 300,
                loop: false,
                step: 1
            }, opts);
            var that = $(this),
                ul = that.find('ul'),
                li = ul.find('li'),
                len = li.length,
                visible = options.visible,
                step = options.step,
                navItemLen = parseInt((len - visible)/step),
                curr = 0,
                currPos = that.css('position') == 'absolute' ? 'absolute' : 'relative',
                liIsFloat = li.css('float') !== 'none',
                navWrap = $('<div class="scroll-nav-wrap"></div>'),
                animDir = options.direction == 'x' ? 'left' : 'top',
                styleDir = options.direction == 'x' ? 'width' : 'height',
                prev = typeof options.prev == 'string' ? $(options.prev): options.prev,
                next = typeof options.next == 'string' ? $(options.next): options.next;

            function initStyle() {

                if ( !liIsFloat ) {
                    li.css( 'float', 'left');
                }

                ul.css({
                    position: 'absolute',
                    left: 0,
                    top: 0
                });

                that.css({
                    position: currPos,
                    width: options.direction == 'x' ? visible*li.width() : li.width(),
                    height: options.direction == 'x' ? li.height() : visible*li.height(),
                    overflow: 'hidden'
                });

                prev.addClass(options.disableClass);
                prev.addClass('disableIE6');

                if ( options.loop ) {

                } else {

                    if ( (len - visible)%step !== 0 ) {
                        var add = step - (len - visible)%step;
                        ul.append( li.slice(0, add).clone());

                        len = ul.find('li').length;
                        navItemLen = parseInt((len - visible)/step);
                    }
                }

                ul.css(styleDir,len*li.width());

                if ( !options.showControl && len <= visible ) {
                    prev.hide();
                    next.hide();
                }

                if ( len <= visible ) {
                    $(options.next + ',' + options.next).addClass(options.disableClass);
                } else {
                    prev.addClass(options.disableClass);
                    next.removeClass(options.disableClass);
                }

                if ( options.showNavItem ) {

                    for ( var i = 0; i <= navItemLen; i++ ) {
                        var curr = i == 0 ? options.navItemCurrent : '';

                        navWrap.append( '<em class="' + curr + '">' + (i+1) + '</em>' );
                    }

                    that.after ( navWrap );

                    navWrap.find('em').bind( options.navItemEvtType, function() {
                        var currNumber = parseInt(this.innerHTML);
                        switchTo((currNumber-1)*step);
                    });

                }

                if ( options.showStatus ) {
                    that.after ( '<span class="scroll-status">' + 1 + '/' + (navItemLen+1) + '</span>' );
                }
            }

            function switchTo (which) {
                if (ul.is(':animated')) {
                    return false;
                }

                if ( which < 0 ) {
                    prev.addClass(options.disableClass);
                    prev.addClass('disableIE6');
                    return false;
                }

                if ( which + visible > len ) {
                    next.addClass(options.disableClass);
                    return false;
                }

                curr = which;
                ul.animate( options.direction == 'x' ? {left:-((which)*li.width())} : {top:-((curr)*li.height())}, {
                    queue: false,
                    duration: options.speed,
                    complete: function() {

                        if ( which > 0 ) {
                            prev.removeClass(options.disableClass);
                            prev.removeClass('disableIE6');
                        } else {
                            prev.addClass(options.disableClass);
                            prev.addClass('disableIE6');
                        }

                        if ( which + visible < len ) {
                            next.removeClass(options.disableClass);
                        } else {
                            next.addClass(options.disableClass);
                        }

                        setCurrItem(which);
                    }
                });
            }

            function setCurrItem(curr) {
                navWrap.find('em').removeClass(options.navItemCurrent).eq(curr/step).addClass(options.navItemCurrent);

                if ( options.showStatus ) {
                    $('.scroll-status').html( ((curr/step)+1) + '/' + (navItemLen+1) );
                }
            }

            initStyle();

            if ( len > visible ) {

                next.click(function() {
                    switchTo(curr+step);
                });

                prev.click(function() {
                    switchTo(curr-step);
                });
            }
        });
    };
}(jQuery));
var imgSize = 'n2';
if ( $('#plist').hasClass('plist-160') ) {
	imgSize = 'n2';
}
if ( $('#plist').hasClass('plist-220') ) {
	if ( $('#plist').hasClass('plist-160') ) {
		imgSize = 'n2';
	} else {
		imgSize = 'n7';
	}	
}
if ( $('#plist').hasClass('plist-n7') ) {
	imgSize = 'n7';
}
if ( $('#plist').hasClass('plist-n8') ) {
	imgSize = 'n8';
}
$('.p-scroll').each(function() {
    var scroll = $(this).find('.p-scroll-wrap'),
        btnPrev = $(this).find('.p-scroll-prev'),
        btnNext = $(this).find('.p-scroll-next'),
        len = $(this).find('li').length;

    if ( len > 5 ) {
        btnPrev.css('display', 'inline');
        btnNext.css('display', 'inline');

        scroll.imgScroll({
            visible: 5,
            showControl: false,
            next: btnNext,
            prev: btnPrev
        });
    }
    var colors = scroll.find('img');
    colors.each(function() {
        $(this).mouseover(function() {
            var src = $(this).attr("src"),
                skuid = $(this).attr('data-skuid');
            scroll.find('a').removeClass('curr');
            $(this).parent('a').addClass('curr');
            var targetImg = $(this).parents('li').find('.p-img img').eq(0),
                targetImgLink = $(this).parents('li').find('.p-img a').eq(0),
                targetNameLink = $(this).parents('li').find('.p-name a').eq(0),
                targetFollowLink = $(this).parents('li').find('.product-follow a').eq(0);
            targetImg.attr(	'src', src.replace('\/n5\/', '\/'+imgSize+'\/') );
            targetImgLink.attr( 'href', targetImgLink.attr('href').replace(/\/\d{6,}/, '/'+skuid) );
            targetNameLink.attr( 'href', targetNameLink.attr('href').replace(/\/\d{6,}/, '/'+skuid) );
            targetFollowLink.attr( 'id', targetFollowLink.attr('id').replace(/coll\d{6,}/, 'coll'+skuid) );
        });
    });
});
$('#plist.plist-n7 .list-h>li').hover(function() {
    $(this).addClass('hover').find('.product-follow,.shop-name').show();
    $(this).find('.item-wrap').addClass('item-hover');
}, function() {
    $(this).removeClass('hover').find('.item-wrap').removeClass('item-hover');
    $(this).find('.product-follow,.shop-name').hide();
});