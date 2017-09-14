//分类导航
var attachCategoriesNav = function() {
    var brandst = true;
    var _floatListHin, _floatListHout, _floatListDDout, brandHoverShow = false;
    var elem_fl_dls = $("#float-list dl");
    var elem_mnavbox = $("#main-nav")[0];

    if ($('#float-list dl:visible').length <= 0){
	    if (window.XMLHttpRequest) {
		    $('#float-list').hover(function(){
                resetDTStyle();
			    $(this).attr('style','box-shadow:2px 2px 3px #999;*border-right:2px solid #999;*border-bottom:2px solid #999;').find('dl,.float-list-dnav').stop().removeAttr('style').slideDown(200);
		    },
		    function(){
			    $(this).find('dl,.float-list-dnav').stop().slideUp(200,function(){$('#float-list').removeAttr('style');});
		    });
	    } else {
		    $('#float-list').hover(function(){
                resetDTStyle();
			    $(this).attr('style','*border-right:2px solid #999;*border-bottom:2px solid #999;').find('dl,.float-list-dnav').show();
			    $('#float-list dd').hide().parent().removeAttr('background','');
		    },
		    function(){
			    $(this).find('dl,.float-list-dnav').hide();
			    $('#float-list').removeAttr('style');
		    });
	    }
    }
    else {        
		$('#float-list').hover(function(){
            if (elem_mnavbox.getAttribute("locked")) {
                for (var i = 0; i < elem_fl_dls.length; i++) {
                    elem_fl_dls[i].style.display = "block";
                    getElems("DT", elem_fl_dls[i])[0].className = "";
                    getElems("DD", elem_fl_dls[i])[0].style.display = "none";
                }
            }
		},
		function(){
            if (elem_mnavbox.getAttribute("locked")) {
                for (var i = 0; i < elem_fl_dls.length; i++)
                    elem_fl_dls[i].style.display = "none";
            }
		});
    }

    //浮层距离计算
    var floatListPosition = function(t){
	    var _default = [0,0,0,0,0,0,0]
		    ,_index = t.parent().index() - 1
		    ,_top = t.offset().top + _default[_index]
		    ,_height = t.next('dd').outerHeight(true)
		    ,_sTop = $(window).scrollTop()
		    ,_wHeight = $(window).height()
		    ,boxtop;
	    if(_top > _sTop && _top + _height < _sTop + _wHeight){boxtop = _default[_index];}
	    else if(_top < _sTop){boxtop = Math.min(_default[_index] + (_sTop - _top) + 10,0);}
	    else if(_top + _height > _sTop + _wHeight){boxtop = Math.max((_index) * -91 + 20,Math.max(_default[_index] - (_top + _height - _sTop - _wHeight) - 10,-(_height - 91)));}
	    return boxtop;
    }

    //brand animate
    function GetRandomNum(Min,Max){   
	    var Range = Max - Min;   
	    var Rand = Math.random();   
	    return(Min + Math.round(Rand * Range));   
    }

    function brandShow(){
	    setTimeout(function(){brandst= true;},700);
	    if (!brandst) return false;
	    brandst = false;
	    $('#hot-brand-wall a[xy]').each(function(){
		    var xy = $(this).attr('xy').split(''),
		    x = xy[1] * 192 + ((xy[0] - 1) % 2) * 96 - 160,
		    y = xy[0] * 55 - 37;
	    !$(this).find('b').length && $(this).append('<b></b><i></i>');
	    $(this).css({'top':y * GetRandomNum(3,5) * (GetRandomNum(0,1) || -1),'left':x * GetRandomNum(3,5) * (GetRandomNum(0,1) || -1),'opacity':0}).show().animate({'top':y,'left':x,'opacity':1},500,function(){brandHoverShow = true});
	    });
    }

    function brandHover(){
	    $('#hot-brand-wall a[xy]').mouseenter(function(){
		    clearTimeout(_floatListHin);
		    clearTimeout(_floatListHout);
		    if(!brandHoverShow) return false;
		    $('#hot-brand-show').stop().html('<em>' + $(this).attr('tit') +'</em>').attr('href',$(this).attr('href')).show().css({'top':$(this).css('top'),'left':$(this).css('left').replace('px','')*1 - 31,'opacity':(!-[1,]?1:0)}).animate({'opacity':1},300);
		    return false;
	    });
	    $('#hot-brand-show').mouseleave(function(){$(this).hide()});
    }

    //floatList ico
    $('#float-list dl strong').each(function(i){
	    $(this).css('background-position','-464px -'+ (18 * i + 62) +'px');
    });

    //主导航 begin
    $('#float-list dl dt').hover(
		function(){
			var _self = this;
			
            resetDTStyle();
            $(_self)[0].className = "hover";

            clearTimeout(_floatListHin);
			clearTimeout(_floatListHout);
			clearTimeout(_floatListDDout);

			if($(_self).next().is(':visible'))
                return false;

			_floatListHin = setTimeout(function(){
				$('#float-list dl').css('background','#fff');
				$('#float-list dl dd').hide();
				brandHoverShow = false;
				if($(_self).next('dd').find('textarea').length){
					$(_self).next('dd').html($(_self).next('dd').find('textarea').text());
					try{DD_belatedPNG.fix('#hot-brand-wall,#float-list .bimg img');					
					}catch(e){}
					if($(_self).next('dd').hasClass('hot-brand-wall')){
						brandHover();
					}
				}
				if($(_self).next('dd').hasClass('hot-brand-wall')){
					brandShow();
				}
				$(_self).parent().css('background-color','#f0f0f0').find('dd').css('top',floatListPosition($(_self))).show();
			}, 1);
		},
		function(e){
			var _self = this;
            resetDTStyle(e);
			_floatListHout = setTimeout(function(){
				$(_self).parent().css('background-color','#fff').find('dd').hide();
				$('#hot-brand-show').hide();
				brandHoverShow = false;
			}, 1);
		}
    );
    //主导航 end

    //子导航 begin
    $('#float-list dl dd').hover(function(e){
        var _self = this;
        $(_self).prev("dt")[0].className = "hover";

	    clearTimeout(_floatListHin);
	    clearTimeout(_floatListHout);
	    clearTimeout(_floatListDDout);
    },    
    function(e){
	    var _self = this;
	    if ($('#hot-brand-wall').is(':visible') && $(e.target)[0].nodeName != 'DD')
        return false;

	    _floatListDDout = setTimeout(function(){
		    $(_self).hide().parent().removeAttr('style');
		    $('#hot-brand-show').hide();
            $(_self).prev("dt")[0].className = "";
            if (elem_mnavbox.getAttribute("locked")) {
                for (var i = 0; i < elem_fl_dls.length; i++)
                    elem_fl_dls[i].style.display = "none";
            }
	    }, 1);
    });
    //子导航 end

    $('#float-list dl dd a').delegate('','click',function(){
	    $(this).parents('dd').hide().parent().removeAttr('style');
    });

    $('#search-submit').parent().next().find('a[style]').each(function(i){
	    if(i >= 2){
		    $(this).attr('style','')
	    }
    })

    var resetDTStyle = function(e) {
        if (e) {
            if ($(e.target)[0].nodeName != "DT")
                return;
        }
        $('#float-list dl dt').removeClass("hover");
    };
    function getElems(elemName, obj) { return (obj || document).getElementsByTagName(elemName); };
};

attachCategoriesNav();