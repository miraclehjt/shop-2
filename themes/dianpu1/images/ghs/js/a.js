/*
	author:wanghaixin@jd.com
	date:20130320
	ver:v1.0.0
	
	description:
	
*/


/*
 *  extending of original object
 */



/*
each is similar to Array object's foreach API in JS 1.6. 
@param : handler which acts on the elements in the array
return : no
*/
Array.prototype.each = function(fun){
	if(!fun.constructor == Function) return;
		for(var i = 0, len = this.length;i <len; i++) fun.call(this,i,this[i]);
}; 

Array.prototype.isIn = function(arg){
	for(var i = this.length; i > 0; i--){
		if(this[i-1] == arg)
			return true;
	}
	return false;
};

/*
 * 或者在数组中的位置
 */
Array.prototype.getIndex = function(arg){
	for(var i = 0, len = this.length; i < len; i++){
		if(this[i] == arg)
			return i;
	}
	return -1;
};

/*
 * 数组过滤，过滤在另一数组中存在的数据
 */
Array.prototype.aUnique = function(arr){
	if(arr.constructor != Array)
		throw new Error('Array.aUnique:arguments error!');
	var _result = [];
	for(var i = 0, len = arr.length; i < len; i++){
		if(!this.isIn(arr[i]))
			_result.push(arr[i]);
	}
	return _result;
};

/*
 * 去除数组中某个元素
 */
Array.prototype.del= function(ele){
	  var index = this.getIndex(ele);
      if(index != -1){
            this.splice(index,1);
      }
      return this;	
};

/*
 * rewrite some methods provided by sys
 */

(function($,w){
	/*
	 * rewrite console method in order to avoid IE
	 */
	if(!w.console){
		w.console = {};
		w.console.log = function(str){
		};		
	}
	
	/*
	 * rewrite alert method with dialog widget
	 */
	if(typeof UI != 'undefined'&&UI.dialog){
		w.alert = function(str){
			UI.dialog.open({
				sTitle : '鸿宇店铺提示',
				sContent : gConfig.assembles.dialog_content(str,1),
				nBtn : 1,
				fSure : function(){
					UI.dialog.close();
				}
			});
		};
	}
	w.setCaret = function(textObj){
		if (textObj.createTextRange) {
	        textObj.caretPos = document.selection.createRange().duplicate();
	    }
	};
	
	w.insertText = function(obj,str){
		if(document.all){
			if(obj.createTextRange&&obj.caretPos){
				 var caretPos = obj.caretPos;
            	caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == '   ' ? str + '   ' : str;
	        } else {
	            obj.value = str;
	        }
		}
		else if(obj.selectionStart || obj.selectionStart == '0'){
			var startPos = obj.selectionStart,
				endPos = obj.selectionEnd,
				cursorPos = startPos,
				restoreTop = obj.scrollTop,
				tmpStr = obj.value;
			 obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
			 if(restoreTop > 0){
				 obj.scrollTop = restoreTop;
			 }
			 obj.focus();
	        cursorPos += str.length;
	        obj.selectionStart = obj.selectionEnd = cursorPos;
	    } else {
	        obj.value += str;
	        obj.focus();
	    }
	};
})(jQuery,window);


(function($,w){

	w.gBase = w.gBase || {};
	
	$.extend(w.gBase,{
		nMaxZIndex : null,
		isIE6 : (function(){
			if(window.ActiveXObject){
				if(document.documentElement && typeof document.documentElement.style.maxHeight != 'undefined'){
					return false;
				}
				else{
					return true;
				}
			}
			else{
				return false;
			}
		})(),
		fGetUrlParms : function()    
		{
		    var args=new Object(),   
		    	qry=location.search.substring(1),//获取查询串   
		    	pairs=qry.split("&");//在逗号处断开   
		    for(var i=0;i<pairs.length;i++)   
		     {   
		        var pos=pairs[i].indexOf('=');//查找name=val
		            if(pos==-1)   continue;//如果没有找到就跳过   
		            var argname=pairs[i].substring(0,pos),//提取name   
		            	val=pairs[i].substring(pos+1);//提取val
		            args[argname]=unescape(val); //存为属性(解码)
		     }
		    return args;
		},
		/*
		This basic logic can get the max 'z-index' property in the range of BODY
	or somehow specific DOM element.
		@doc: search range, BODY in default
	*/
		fGetMaxZIndex : function(doc){
			if(gBase.nMaxZIndex){
				gBase.nMaxZIndex ++;
				return gBase.nMaxZIndex;
			}
			else{
				return 1001;
			}
			
			function _get(doc){
				var root = doc?doc:'body',
						maxZIndex = 0,
						children = $(root).children();
				for(var i = 0, len = children.length; i < len; i++){
					var zIndex = children.eq(i).css('z-index');
					if(zIndex == 'auto'){
						zIndex = arguments.callee(children[i]);
					}
					gBase.nMaxZIndex = Math.max(gBase.nMaxZIndex,zIndex);
				}
				return gBase.nMaxZIndex;
			}
			gBase.nMaxZIndex =  _get() + 1;
			return gBase.nMaxZIndex;
		},
		
		fMask : function(prefix,color,opacity){
			color = color == null ? '#000' : color;
			opacity = opacity == null ? 20 : opacity;
			var ch = Math.max($('body').height(),$(window).height()),
				zindex = this.fGetMaxZIndex();
			if($.browser.msie && ($.browser.version.match(/\d/) == 9)){
				var ifm = $('iframe id="' + prefix + '_ie6_mask" className="_mask_2012" style="background:#000;position:absolute;width:100%;height:'+ch+'px;z-index:'+zindex+';"></iframe>').appendTo('body');
				$.browser.msie?$(ifm).css('filter','alpha(opacity=' + opacity + ')'):$(ifm).css('opacity',opacity/100);
			}
			$('<div id="'+prefix+'_mask" className="_mask_2012" style="background:'+color+';position:absolute;top:0px;display:none;width:100%;height:'+ch+'px;z-index:'+zindex+';"></div>').appendTo('body').fadeTo(200,opacity/100);
		},
		
		fMaskHide : function(prefix){
			$('#' + prefix + '_ie6_mask,#'+prefix+'_mask').remove();
		},
		addFavorite: function(title, url) {
			var _url = url;
		    var _title = title;
			try{
				if (document.all) {
					window.external.AddFavorite(_url, _title);
				} else if (window.sidebar) {
					window.sidebar.addPanel(_title, _url, "");
				} else {
					alert("对不起，您的浏览器不支持此操作!\n请您使用菜单栏或Ctrl+D收藏本站。");
				}
			}
			catch(e){
				alert('对不起，您的浏览器不支持此操作!\n请您使用菜单栏或Ctrl+D收藏本站。');
			}
		},
		
		JSONClone : function(obj){
			var _result = {};
			for(var i in obj){
				_result[i] = obj[i];
			}
			return _result;
		}
	});
})(jQuery,window);

$.fn.extend({
	imgOnload : function(){}
});

$(function(){
	gBase.nMaxZIndex = gBase.fGetMaxZIndex();
});/*
 author:wanghaixin@jd.com
 date:20130320
 ver:v1.0.0

 description:

 */

/****************************************************Message Box*****************************************/
/*
 * 在UI.dialog基础上做二次开发
 * 依赖于UI.dialog
 */
message_box = (function(){
    var _box = null,_timer,_duration = 2000,_speed = 300,_messages = [];
    /*
     * 初始化 message box
     */
    function _init(cnt){
        if(!_box){
            var dialog = UI.dialog.open({
                type : 1,
                sContent : cnt,
                nBtn : 2,
                sStyle : 'userDef',
                sAnimate : {left:0,top:1}
            });
            _box = dialog.oPopup;
            _box.css('zIndex',2147483640);
        }

    }

    /*
     * 添加消息至消息队列，如果消息队列为空并且timer为null。开始显示message
     */
    function _add(cnt){
        var __flag = !_messages.length&!_timer;
        _messages.push(cnt);
        if(!!__flag){
            _show();
        }
    }

    /*
     * 显示message box
     */
    function _show(){
        var __callee = arguments.callee;
        if(_messages.length){
            var _cnt = _messages.shift();
            _box.html(_cnt);

            _box.show().animate({top:'-4px'},_speed,function(){
                _timer = setTimeout(function(){
                    _box.animate({top : -_box.outerHeight() + 'px'},_speed,function(){
                        _clear();
                        __callee();
                    });
                },_duration);
            });
        }
    }

    /*
     * 清除timer
     */
    function _clear(){
        clearTimeout(_timer);
        _timer = null;
        _box.clearQueue();
    }


    return function(str,type){
        var _str = '<div class="dialog-area">' + gConfig.assembles.dialog_content(str,type) + "</div>";
        _init('');
        _add(_str);
    };
})();


/****************************************************Image Lazyload*****************************************/

(function($,w){
    var _lazy_class = 'J_imgLazyload',
        _orginal_src = 'original',
        _imgs = [];

    function _get_imgs(){
        _imgs = $('body .' + _lazy_class);
    }
    function _load(){
        var __top = $(window).scrollTop() + $(window).height(),
            __left = [];
        for(var i = 0, len = _imgs.length; i < len; i++){
            var __img = $(_imgs[i]);
            try{
                if(__img.offset().top < __top){
                    __img.removeClass(_lazy_class);
                    __img.attr('src',__img.attr(_orginal_src));
                    __img.removeAttr(_orginal_src);
                }
                else{
                    __left.push(__img);
                }
            }
            catch(e){

            }
        }
        _imgs = __left;
        if(!_imgs.length){
            $(window).unbind('scroll,resize',_load);
        }
    }

    $(function(){
        _get_imgs();
        _load();
        $(window).scroll(_load).resize(_load);
    });

})(jQuery,window);

/******************************************obtain price**********************************/
(function(w){

    var _nodes = [],
        _prefix_url = 'http://p.3.cn/prices/mgets?skuids=',
        _suffix_url = '&type=2&callback=callBackPriceService',
        _batch_count = 0,
        _tem_str = '',
        _max_count = 20;

    function _get_nodes(){
        _nodes = _price_unique($('span[jshop="price"]').toArray());
    }


    function _getPrice(){
        var __skus = _tem_str.substring(_tem_str,_tem_str.length-1);
        $.getScript(_prefix_url + __skus + _suffix_url);
        _batch_count = 0;
        _tem_str = '';
    }

    function _load(){
        var __top = $(window).scrollTop() + $(window).height(),
            __lefts = [];
        for(var i = 0, len = _nodes.length; i < len; i++){
            var __node = $(_nodes[i]);
            if(__node.offset().top < __top){
                var __skuid = __node.attr('jdprice') || __node.attr('jsprice') || __node.attr('jskuprice');
                _tem_str += 'J_' + __skuid + ',';
                _batch_count ++;
                if(_batch_count == _max_count){

                    _getPrice();
                }
            }else{
                __lefts.push(_nodes[i]);
            }
        }
        if(_batch_count){
            _getPrice();
        }
        _nodes = __lefts;
        if(!_nodes.length){
            $($('#appId').length?'.J-layout-container':window).unbind('scroll',_load);
        }
    }

    function _event_register(){
        $($('#appId').length?'.J-layout-container':window).scroll(_load);
    }

    function _init(){
        _get_nodes();
        _load();
        _event_register();
    }

    function _price_unique(arr){
        if(!arr instanceof Array) throw new Error('_price_unique:arguments error');
        var __tem1 = {},__tem2 = [],__tem3 = [];
        for(var i = 0, len = arr.length; i < len; i++){

            var __obj = $(arr[i]),
                __sku = __obj.attr('jdprice')||__obj.attr('jsprice')||__obj.attr('jskuprice');
            if(__tem1[__sku] == undefined){
                __tem2.push(arr[i]);
                __tem1[__sku] = __obj.offset().top;
                __tem3.push(__sku);
            }
            else if(__tem1[__sku]>__obj.offset().top){
                __tem2[__tem3.getIndex(__sku)] = arr[i];
                __tem1[__sku] = __obj.offset().top;
            }
        }
        return __tem2;
    }

    w.JD_local_price = function(obj){
        var __nodes = obj.find('span[jshop="price"]').toArray();
        for(var i = 0, len = __nodes.length; i < len; i++){
            var __node = $(__nodes[i]),
                __skuid = __node.attr('jdprice') || __node.attr('jsprice') || __node.attr('jskuprice');
            _tem_str += 'J_' + __skuid + ',';
            _batch_count ++;
            if(_batch_count == _max_count){
                _getPrice();
            }
        }
        if(_batch_count){
            _getPrice();
        }
    };

    w.callBackPriceService = function(data){
        var _sku = 0;
        for(var i = 0 , len = data.length; i < len; i++){
            skuid = data[i].id.substr(2);
            data[i].id = skuid;
            getNumPriceService(data[i]);
        }
    };

    $(function(){
        _init();
    });
})(window);

/**************************************price data fill******************************************/
(function($,w){
    w.JD_price = {
        /*
         * 获取节省价
         */
        _get_save : function(num1,num2){
            if(num1 == 0 || num2 == 0 || (num1 - num2 <= 0)) return 0;

            var __rs = num1 - num2;
            return __rs.toString().match(/\d+(\.\d{1,2})?/)[0];
        },
        /*
         * 获取折扣率
         */
        _get_discount : function(num1,num2){
            if(nmu1 == 0 || num2 == 0) return 10;
            return (num2/num1*10).toFixed(1);
        },
        /*
         * 设置鸿宇价
         */
        _set_jd_price : function(data,tag){
            var _price = data.p>=0?data.p:tag;
            $('span[jdprice=' + data.id +']').each(function(index,n){
                $(n).html(_price);
            });
        },
        /*
         * 设置促销价
         */
        _set_sale_price : function(data,tag){
            var _price = data.m >=0?data.m:tag;
            $('span[jsprice=' + data.id +']').each(function(index,n){
                $(n).html(_price);
            });
        },
        /*
         * 设置sku价
         */
        _set_sku_price : function(data,tag){
            var _price = data.m >= 0?data.m:tag;
            $('span[jskuprice=' + data.id +']').each(function(index,n){
                $(n).html(_price);
            });
        },
        /*
         * 设置节省价
         */
        _set_save_price : function(data){
            var __jdpirce = data.p >=0?data.p:0,
                __skuprice = data.m >= 0 ? data.m:0;

            $('span[saprice=' + data.id + ']').each(function(index,n){
                $(n).html(JD_price._get_save(__skuprice, __jdpirce));
            });
        },
        _set_save_sale_price : function(data){
            var __jdpirce = data.p >= 0?data.p:0,
                __sales_price = data.m >= 0 ? data.m:0;

            $('span[ssprice=' + data.id + ']').each(function(index,n){
                $(n).html(JD_price._get_save(__sales_price, __jdpirce));
            });
        },
        /*
         * 设置促销折扣率
         */
        _set_discount_sale_price : function(data){
            var __jdprice = data.p >= 0 ? data.p:0,
                __sales_price = data.m >= 0? data.m:0;
            $("span[dsaleprice=" + data.id + "]").each(function(index, n) {
                $(n).html(JD_price._get_discount(__sales_price,__jdprice));
            });
        },
        /*
         * 设置sku折扣率
         */
        _set_discount_sku_price : function(data){
            var __jdprice = data.p >=0 ? data.p:0,
                __sku_price = data.m >= 0 ? data.m:0;
            $("span[dskuprice=" + data.id + "]").each(function(index, n) {
                $(n).html(JD_price._get_discount(__sku_price,__jdprice));
            });
        }
    };
    /*
     * 填充价格
     */
    w.getNumPriceService = function(data){
        if(!data) return;
        var _no_price_tag = '暂无定价';
        JD_price._set_jd_price(data,_no_price_tag);
        JD_price._set_sale_price(data,_no_price_tag);
        JD_price._set_sku_price(data,_no_price_tag);
        JD_price._set_save_price(data);
        JD_price._set_save_sale_price(data);
        JD_price._set_discount_sale_price(data);
        JD_price._set_discount_sku_price(data);
    };
})(jQuery,window);

/*
 登录统一处理逻辑
 */
function thick_login(callback,scope){
    if(typeof callback != 'function')
        throw new Error('Self-defined login argments should be a function!');
    $.extend(jdModelCallCenter,{
        jshop_login:function(obj){
            $.login({
                modal:true,
                complete:function(c){
                    if(c&&c.IsAuthenticated){
                        callback.call(scope || this, c);
                    }
                    else{
                        jdModelCallCenter.settings.fn = callback;
                    }
                }
            });
        }
    });

    $.extend(jdModelCallCenter.settings,{
        object:this,
        fn:function(){
            jdModelCallCenter.jshop_login(this);
        }
    });
    jdModelCallCenter.settings.fn();
}
/*
 关注统一处理逻辑，class名为btn-attention
 */
$(function(){
    $('.layout-main').delegate('btn-attention','click',function(){
        var _this = $(this),
            _sku = parseInt(_this.attr('id').replace('coll',''));
        $.extend(jdModeCallCenter.settings,{
            clstag1 : 'login|keycount|5|3',
            clstag2 : 'login|keycount|5|4',
            id : _sku,
            fn : function(){
                jdModeCallCenter.doAttention(this.id);
            }
        })
    });
});

(function(){
    var cssId = '.J-cart';
    // 为加入购物车按钮绑定事件
    $(function(){
        $('.layout-main').delegate(cssId,'click',function(){
            var sku = $(this).attr('itemid');
            try{
                $.ajax({
                    url : 'http://cart.jd.com/cart/dynamic/gate.action?pid='+sku+'&pcount=1&ptype=1&callback=?',
                    type : 'get',
                    dataType : 'jsonp',
                    success : function(){

                    }
                });
            } catch(e) {

            }

            var dialog  = '';
            dialog += '<div class="m tip-success" id="add-to-cart">';
            dialog += '<div class="mt fl icon"></div>';
            dialog += '<div class="mc lh">';
            dialog += '<div class="c-title"><strong>添加成功</strong></div>';
            dialog += '<div class="c-btn">';
            dialog += '<a class="c-checkout" href="http://cart.jd.com/cart/cart.html" target="_blank">去购物车结算</a>';
            dialog += '<a class="c-return" href="#none" onclick="jdThickBoxclose()">继续购物</a>';
            dialog += '</div><a href="#" class="thickclose" id="">×</a></div></div>';
            dialog += '<style>';
            dialog += '#add_to_cart_div{display:none}';
            dialog += '#add-to-cart,#cart-reco{width:452px;margin-left:10px;overflow:hidden}';
            dialog += '#add-to-cart{margin-bottom:20px}';
            dialog += '#add-to-cart .icon{width:50px;height:50px;margin-right:10px;background-image:url(i/item-icon.png);';
            dialog += 'background-repeat:no-repeat;*display:inline}';
            dialog += '#add-to-cart .c-title strong{font:400 18px "microsoft yahei"}';
            dialog += '#add-to-cart.tip-success .c-title{color:#7abd54}';
            dialog += '#add-to-cart .c-count{color:#999;line-height:22px}';
            dialog += '#add-to-cart .c-btn{padding-top:5px}#add-to-cart ';
            dialog += '.c-btn a{height:36px;background-image:url(';
            dialog += 'http://misc.360buyimg.com/purchase/skin/i/20130425D.png);';
            dialog += 'display:inline-block;overflow:hidden;line-height:100px;*zoom:1}';
            dialog += '#add-to-cart .c-btn .c-checkout{width:189px;margin-right:8px;background-position:0 0}';
            dialog += '#add-to-cart .c-btn .c-return{width:94px;background-position:-90px -37px}';
            dialog += '#cart-reco{border-top:1px solid #ddd;padding-top:20px;margin-bottom:0}';
            dialog += '#cart-reco .mc{height:170px}';
            dialog += '#cart-reco .lh li{width:100px;padding:6px 6px 0}';
            dialog += '#cart-reco .lh li .p-name{height:3em;line-height:1.5em;overflow:hidden}';
            dialog += '</style>';

            $.jdThickBox({
                source : dialog,
                width : 492,
                height : 90,
                title : '加入购物车'
            });
        });

    });
})();
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
})(jQuery,window);/*
 * author:wanghaixin@jd.com
 * date:2013-04-11
 * ver:v1.0.0
 */

/*
 * 伪属性模块加载框架
 */
(function($,w){
	w.jshop = {};
	w.jshop.module = {};
	
	$.extend(w.jshop.module,{
		/*
		 * 去除图片懒加载
		 */
		 ridLazy : function(obj) {
			$(obj).find('img.J_imgLazyload').each(function(){
				$(this).attr('src',$(this).attr('original'));
				$(this).removeAttr('original');
				$(this).removeClass('J_imgLazyload');
			});	
		},
		/*
		 * 旧方法，和changeClass一样。
		 */
		changeStyle:function(args){
			var param = $.extend({node:'li', defaultClass:'jCurrent', defaultShow:0}, args),
				elem = $(this).find(param.node),
				defaultClass = param.defaultClass,
				defaultShow = param.defaultShow;
			
			elem.eq(defaultShow).addClass(defaultClass);
			
			elem.each(function(index,n){
				$(n).mouseover(function(e){
					$(this).addClass(defaultClass).siblings().removeClass(defaultClass);
				});
			});
		},
		/*
		 * @function：改变样式：默认显示一个，鼠标移动到节点上时增加当前样式，同时去除其兄弟节点的当前样式
		 * @description：主要应用于190布局宽度下，因宽度有限，默认只显示商品标题，当鼠标移动到标题上时显示更多的商品信息。
		 * @param：如{node:'li', defaultClass:'jCurrent', defaultShow:0}。参数node为单个节点名；参数defaultClass可任意命名，只要css里面有这个名字。
		 * @author：20130114 by bjwanchuan
		 */
		changeClass:function(args){
			var param = $.extend({node:'li', defaultClass:'jCurrent', defaultShow:0}, args),
				elem = $(this).find(param.node),
				defaultClass = param.defaultClass,
				defaultShow = param.defaultShow;
			
			elem.eq(defaultShow).addClass(defaultClass);
			
			elem.each(function(index,n){
				$(n).mouseover(function(e){
					$(this).addClass(defaultClass).siblings().removeClass(defaultClass);
				});
			});
		},
		/*
		 * @function：切换样式：鼠标移动到节点上时增加一个样式，移出时去除增加的样式
		 * @description：主要应用于商品列表类模块，如商品推荐、分页显示商品等模块，默认显示商品图片等，鼠标移动上去时显示更多商品信息。
		 * @param：如{node:'li', defaultClass:'current', defaultShow:0}。参数node为单个节点名；参数defaultClass可任意命名，只要css里面有这个名字。
		 * @author：20130114 by bjwanchuan
		 */
		tabClass:function(args){
			var param = $.extend({node:'li', defaultClass:'current'}, args),
				elem = $(this).find(param.node).length ? $(this).find(param.node) : $ (this),
				defaultClass = param.defaultClass,
				defaultShow = param.defaultShow;
				
			if(defaultShow){
				elem.eq(defaultShow).addClass(defaultClass);
			}
			
			elem.bind({
				mouseenter:function(){
					$(this).addClass(defaultClass).siblings().removeClass(defaultClass);
				},
				mouseleave:function(){
					$(this).removeClass(defaultClass);
				}
			});
		},
		/*
		 * @function：切换：鼠标移动到不同的tab，切换相对应的内容
		 * @description：主要应用在商品分类推荐模块中，点击不同的标题，切换相对应的内容。
		 * @param：如{tabNode:'.jSortTab span', tabContent:'.jSortContent ul', arrow:'.jSortTabArrow', defaultClass:'current, setUpWidth:0}。setUpWidth值：0，1；其中0表示平均分配宽度，1表示默认宽度；
		 * @author：20130114 by bjwanchuan
		 */
		tab:function(args){
			var param = $.extend({tabNode:'.jSortTab span', arrow:'.jSortTabArrow', defaultClass:'current', tabContent:'.jSortContent ul'}, args),
				_this = this,
				tabNode = $(_this).find(param.tabNode),
				tabContent = $(_this).find(param.tabContent),
				arrow = $(_this).find(param.arrow);
				
			//初始化结构
			tabNode.eq(0).addClass(param.defaultClass);
			tabContent.eq(0).addClass(param.defaultClass);
			tabNode.each(function(i,n){
				$(n).attr('data-num',i);
			});
			
			var width = 0;
			//自适应宽度
			if(param.setUpWidth) {
				if(tabNode.width() > 0) {
					width = tabNode.width();
				}else{
					width = (tabNode.parent().parent().width()-0.03)/tabNode.length;	
				}
			}else{
				width = (tabNode.parent().parent().width()-0.03)/tabNode.length;
			}
			tabNode.css({width: width});
			arrow.css({width: width});
			
			//绑定鼠标移动事件
			tabNode.bind({
				mouseenter: function(){
					$(this).addClass(param.defaultClass).siblings().removeClass(param.defaultClass);
					tabContent.eq($(this).attr('data-num')).addClass(param.defaultClass).siblings().removeClass(param.defaultClass);
					arrow.animate({left:($(this).attr('data-num'))*width},300,function(){});
				}
			});
		},
		/*
		 * @function：切换显示：通过触发一个元素，切换其他元素的显示。可选择闭环切换、前进后退及随机切换显示。
		 * @description：可应用于任意模块，只要有使用场景。
		 * @param：如{eventNode:'.jClick', parentNode:'.jSortContent', childNode:'ul', defaultClass:'current', eventType:'click', num:0, tabTime:500, subFunction:'circle'}
		 * eventNode触发切换的节点；parent切换节点的父节点；child切换节点；defaultClass显示样式；eventType触发的事件类型；
		 * num初始显示第几个；tabTime每一屏切换的时间；subFunction显示方式：闭环circle、前进倒退direction、随机random；
		 * @author：20140117 by bjwanchuan
		 */
		tabShow : function(args){
			var param = $.extend({eventNode:'.jClick', parentNode:'.jSortContent', childNode:'ul', defaultClass:'current', eventType:'click', num:0, tabTime:500, subFunction:'circle'},args),
				_this = $(this),
				eventNode = _this.find(param.eventNode),//触发切换的节点
				parent = _this.find(param.parentNode),//切换节点的父节点
				child = _this.find(param.childNode),//切换节点
				defaultClass = param.defaultClass,//显示样式
				eventType = param.eventType,//触发的事件类型
				num = (param.num === Number && param.num <= len) ? param.num : 0,//初始显示第几个
				tabTime = param.tabTime,//每一屏切换的时间
				subFunction = param.subFunction,//显示方式：闭环circle、前进倒退direction、随机random
				len = child.length,
				isLeft = true;
				
			//初始化显示
			child.eq(num).addClass(defaultClass);
			
			//事件触发
			eventNode[eventType](function(){
				if(param.subFunction){
					showStyle[param.subFunction].call(_this);
				}
				callBack();
			});
			
			var showStyle = {
				circle : function(){
					num = (num + 1)%len;
				},
				direction : function(){
					if(isLeft){
						num++;
						if(num == len - 1){
							isLeft = false;
						}
					}else{
						num--;
						if(num  == 0){
							isLeft = true;
						}
					}	
				},
				random : function(){
					num = parseInt(Math.random() * len);
				}
			}
			
			function callBack(){
				child.eq(num).addClass(defaultClass).siblings().removeClass(defaultClass);
				child.animate({opacity:0},0,function(){});
				child.eq(num).animate({opacity:1},param.tabTime,function(){});	
			}
		},
		/*
		 * @function：自适应布局：根据布局的宽度判断能放下的一行数量，并将平均宽度转化为百分比形式。转化好的class类将自动写入节点。
		 * @description：主要应用于不同的宽度布局，如190、390、590、790、990等布局，同一套模板显示的列表个数会根据布局宽度自动计算，并撑满布局。这个方法和autoWidth类似，各有各的使用效果。
		 * @param：如{node:'li', spacingType:'margin', size:1}。node为需要计算宽度的节点；spacingType为节点的间距类型，其值为：margin和padding；size为间距的宽度，其值为0.5和1，其中0.5代表左右间距为0.5%，1代表左右间距为1%。
		 * @author：20130114 by bjwanchuan
		 */
		autoLayout : function(args){
			var _para = $.extend({node: 'li', spacingType: 'margin', size: 1},args || {}),
				_this = $(this),
				_elem = _this.find(_para.node),
				_qty = parseInt(_elem.parent().parent().width()/_elem.outerWidth(true)),
				_ie = $.browser.msie&&parseInt($.browser.version) <= 10?'i':'',
				_spacing = _para.spacingType.match(/^m/)?'m':'p',
				_size = _para.size == 0.5?'OneHalf':'One',
				_arr = ['qOne','qTwo','qThree','qFour','qFive','qSix','qSeven','qEight','qNine','qTen','qEleven','qTwelve'];
			
			_elem.addClass(_ie + _arr[_qty-1] + _size).addClass(_spacing + _size);
		},
		/*
		 * @function：自适应宽度：根据布局的宽度判断能放下的一行数量，并将多余的宽度平均分配给每一个列表项。支持css对象传入。
		 * @description：主要应用于不同的宽度布局，如190、390、590、790、990等布局，同一套模板显示的列表个数会根据布局宽度自动计算，并撑满布局。
		 * @param：如{node:'li', extra:{margin:'0 5px', padding:'5px 0'}}。node为需要计算宽度的节点；extra为给需要计算宽度的节点增加一些css样式，这样可适应不同的效果需求。
		 * @author：20130114 by bjwanchuan
		 */
		autoWidth:function(args){
			var _para = $.extend({node:'li', extra:{}}, args || {}),
				_this = this,
				elems = $(_this).find(_para.node), 
				elem = elems.eq(0);
			
			elems.css(_para.extra);
			
			var outerWidth = parseInt(elem.data('outerWidth') || elem.outerWidth(true)),
				width = parseInt(elem.data('width') || elem.css('width')),
				qty = parseInt(elem.parent().parent().width()/outerWidth);
			
			elem.data({'outerWidth':outerWidth, 'width':width});
			
			var extraWidth = outerWidth - width;
			var newWidth = (elem.parent().parent().width()-extraWidth*qty-0.03)/qty;
			elems.css({width:newWidth});
		},
		/*
		 * @function：平均宽度：根据父节点宽度，平均分配子节点宽度。
		 * @description：主要应用于导航、商品分类推荐等模块中。避免因数量较少而容器右边出现空白的情况。
		 * @param：如{equallyNode:'.jSortTab span', equallyParentNode:null}。equallyNode需要平均父级宽度的节点；equallyParentNode为父级节点，如果此参数没传则默认为当前引用此方法的节点。
		 * @author：20130114 by bjwanchuan
		 */
		equallyWidth:function(args){
			var param = $.extend({equallyNode:'.jSortTab span', equallyParentNode:null}, args),
				_this = $(this),
				nodeParent = (_this.find(param.equallyParentNode).length > 0) ? _this.find(param.equallyParentNode) : _this,
				elems = _this.find(param.equallyNode),
				elem = elems.eq(0);
			
			var outerWidth = parseInt(elem.data('outerWidth') || elem.outerWidth(true)),
				width = parseInt(elem.data('width') || elem.css('width')),
				qty = elems.length;
			
			elem.data({'outerWidth':outerWidth, 'width':width});
			
			var extraWidth = outerWidth - width;
			var newWidth = (nodeParent.width()-extraWidth*qty-0.03)/qty;
			elems.css({width:newWidth});
		},
		/*
		 * @function：100%高度：用在相对定位里面有绝对定位时，背景透明图层以父节点为基准将高度撑满。
		 * @description：主要应用于不同尺寸图片需要遮罩的效果中，由于高度100%存在浏览器兼容，这个方法会自动获取传入的基准容器高度，并赋给遮罩层。
		 * @param：如{fullHeightNode:'li', fullNode:'.jShade'}。fullHeightNode需要参照高度的基准节点；fullNode需要撑满高度的遮罩节点。
		 * @author：20130114 by bjwanchuan
		 */
		fullHeight:function(args){
			var param = $.extend({fullHeightNode:'li', fullNode:'.jShade'}, args),
				elem = $(this).find(param.fullHeightNode),
				fullNode;
			
			elem.bind({
				mouseenter:function(){
					fullNode =$(this).find(param.fullNode);
					fullNode.css({height:$(this).height()});
					
				}
			});
		},
		/*
		 * @function：瀑布流：将图片或商品列表错位布局，错位高度可设置。
		 * @description：主要应用于图片或商品列表类模块，如商品推荐、图片show等模块。
		 * @param：如{area:'.goodsArea', node:"li", topSpac:10}。area需要重设高度的父级节点；node需要使用瀑布流的节点；topSpac顶部错位的距离。
		 * @author：20130114 by bjwanchuan
		 */
		waterfallFlow:function(args){
			var param = jQuery.extend({area:'.goodsArea', node:"li", topSpac:10}, args),
		   		_this = $(this),
				area = _this.find(param.area),
				elem = _this.find(param.node),
				outerWidth = parseInt(elem.data('outerWidth') || elem.outerWidth(true)),
				qty = parseInt(elem.parent().width()/outerWidth),
				topPos,
				array = [];
				elem.data({'outerWidth':outerWidth});
				
		   elem.each(function(index, e){
			   //获取行数
				var row = parseInt(index/qty),
					//获取列数：通过每一个的位置除去每一行的数量，剩下的余数就是每一列
					col = index%qty,
					//获取每一个的左边距：离最左边的距离
					leftPos = col*jQuery(e).outerWidth(true);
				
				//如果是第一行
			   if(row == 0){
				   topPos = parseInt((col%2)*param.topSpac);
			   }
			   else{
				   var topNode = jQuery(elem.get((row-1)*qty+col));
				   topPos = topNode.outerHeight(true)+parseInt(topNode.css("top"));
			   }
			   jQuery(e).css({left:leftPos,top:topPos});
				
				//将每一个的top和自身的高度之和保存到数组里
				array.push(parseInt(jQuery(e).css("top"))+jQuery(e).outerHeight(true));
		   });
			
			//数组排序，获取最大的高度
			function compare(value1, value2){
				if(value1<value2){
					return -1;
				}else if(value1>value2){
					return 1;
				}else{
					return 0;
				}
			}
			array.sort(compare);
			
			//重设父级的高度，以达到背景自适应
			area.css("height",array[array.length-1]);
	   },
		/* 
		 * @function 图片轮播：1、根据用户设置的宽度和高度来确定轮播图的大小。2、可自定义向左、向上轮播和渐变轮播参数。3、可设置图片轮播时间。
		 * @description 主要应用于图片轮播模块。
		 * @param：
		 * @author 20130114 by bjwanchuan
		 */
		slidePhoto:function(args){
			
			// 定义传入的CSS调用变量
			var _this=this,
				param=$.extend({imgArea:'.jbannerImg', imgNodeArea:'.jImgNodeArea', imgNode:'.jbannerImg dl', tabArea:'.jbannerTab', tabNode:'.jbannerTab span', photoName:'.jDesc', arrowLeft:'.jPreOut', arrowRight:'.jNextOut', arrowLeftOver:'jPreOver', arrowRightOver:'jNextOver', defaultClass:'show', slideDirection:'left', timer:'3', subFunction:'transparentEffect', eventType:'click',showArrow:1}, args),
				imgArea = $(_this).find(param.imgArea),
				imgNode = $(_this).find(param.imgNode),
				tabArea = $(_this).find(param.tabArea),
				tabNode = $(_this).find(param.tabNode),
				photoName = $(_this).find(param.photoName),
				defaultClass = param.defaultClass,
				eventType = param.eventType,
				timer = !param.timer*1000?3000:param.timer*1000,
				scroll,
				imgNodeArea = $(_this).find(param.imgNodeArea),
				isFull = param.isFull;
			
			//全局变量
			var index = 0,direction = 1,time = null,moveRange = 0,partTime = null,animate = null;
			if(!imgNode.length) return;
			
			/**
			 * 轮播图所有效果
			 */
			var banner = {
				transparentEffect : function(){
					//初始化
					$(_this).css({'background-color':imgNode.eq(index).attr('background')});
					
					// 调用函数
					init();
					triggerThumbnail();
					triggerDirection();
					if(param.showArrow!=1){triggerArrow();}
					animate = transparent;
					time = setTimeout(imgMove, timer);
				},
				moveEffect : function(){
					var isTop = (param.slideDirection == 'top')?true:false;
					scroll = (isTop)?"scrollTop":"scrollLeft";
					
					//初始化
					$(_this).css({'background-color':imgNode.eq(index).attr('background')});
					if(isTop){
						imgNodeArea.css({height:20000, width:$(_this).width()});
						imgNode.css({width:imgNodeArea.width(),height:"auto","float":"none"});
						moveRange = imgNode.height();
						imgArea[0][scroll] = index * moveRange;
					}else{
						imgNodeArea.css({width:20000});
						imgNode.css({width:imgNode.find("img").width(),height:"100%","float":"left"});//将这个宽度写在css里，在ie6下面，获取到的父级宽度是被这个元素撑开的宽度
						moveRange = imgNode.width();
						imgArea[0][scroll] = index * moveRange;
					};
					
					// 调用函数
					init();
					triggerThumbnail();
					triggerDirection();	
					if(param.showArrow!=1){triggerArrow();}
					animate = oneImgMove;
					time = setTimeout(imgMove, timer);
				}
			};
			
			/**
			 * 根据传入的子方法名执行对应的子方法
			 */
			if(banner[param.subFunction])
				banner[param.subFunction].call(_this);
			
			/**
			 * 轮播图初始化
			 */
			function init(){
				$(_this).css({cursor:'pointer'});
				imgArea.css({width:imgNode.find("img").width(),height:imgNode.find("img").height()});
				imgNode.eq(0).addClass(defaultClass);
				tabNode.eq(0).addClass(defaultClass);
				photoName.text(imgNode.eq(0).find("img").attr("title"));

				$(_this).click(function(){
					window.open(imgNode.eq(index).attr('ref'));
				});
				
				autoMiddle();
				$(window).resize(function(){
					autoMiddle();
				});
			}
			
			/**
			 * 轮播图自适应居中于屏幕中间
			 */
			function autoMiddle(){
				var extra = imgArea.width()-$(_this).width();
				if(extra>0){
					imgArea.css({'margin-left':-extra/2});
				}else{
					imgArea.css('margin','0 auto');
				}
			}
			
			/**
			 * 给每个tab缩略图绑定事件
			 */ 
			function triggerThumbnail(){
				tabNode.each(function(i,elem){
					$(elem)[eventType](function(){
						imgNode.eq(index).removeClass(defaultClass);
						tabNode.eq(index).removeClass(defaultClass);
						index = i;
						imgNode.eq(index).addClass(defaultClass);
						tabNode.eq(index).addClass(defaultClass);
						photoName.text(imgNode.eq(index).find("img").attr("title"));
						animate();
						return false;
					});
				});
			}
			
			/**
			 * 点击箭头或数字时，重置时间
			 */
			function _stop(){
				clearTimeout(time);
				time = null;
				clearTimeout(partTime);
				partTime = null;
				imgNodeArea.clearQueue();
				imgNode.eq(index).clearQueue();
			}
			
			/**
			 * 切换图片和缩略图
			 */ 
			function imgMove(){
				if (direction == 1){
					if (index < imgNode.length - 1){
						classOper([imgNode,tabNode],defaultClass,true);
					}else{
						direction = 0;
						classOper([imgNode,tabNode],defaultClass,false);
					}
				}else{
					if (index > 0){
						classOper([imgNode,tabNode],defaultClass,false);
					}else{
						direction = 1;
						classOper([imgNode,tabNode],defaultClass,true);
					}
				}
				photoName.text(imgNode.eq(index).find("img").attr("title"));
				animate();
			}
			
			/**
			 * 鼠标移动显示左右移动箭头
			 */
			function triggerArrow(){
				var arrowLeft = $(_this).find(param.arrowLeft),arrowRight = $(_this).find(param.arrowRight);
				$(_this).bind({
					mouseover:function(){
						arrowLeft.show();
						arrowRight.show();
					},
					mouseout:function(){
						arrowLeft.hide();
						arrowRight.hide();
					}
				 });
			}
			
			/**
			 * 处理左右移动箭头
			 */
			function triggerDirection(){
				var arrowLeft = $(_this).find(param.arrowLeft),arrowRight = $(_this).find(param.arrowRight),
					arrowLeftOver = param.arrowLeftOver, arrowRightOver = param.arrowRightOver;
				
				arrowLeft.bind({
					click:function(){
						if(index != 0){// 判断当前是不是第一张
							classOper([imgNode,tabNode],defaultClass,false);
							animate();
						}
						return false;
					},
					mouseover:function(){$(this).addClass(arrowLeftOver);},
					mouseout:function(){$(this).removeClass(arrowLeftOver);}
				});
				arrowRight.bind({
					click:function(){
						if(index < imgNode.length - 1){// 判断当前是不是最后一张
							classOper([imgNode,tabNode],defaultClass,true);
							animate();
						}
						return false;
					},
					mouseover:function(){$(this).addClass(arrowRightOver);},
					mouseout:function(){$(this).removeClass(arrowRightOver);}
				});
			}
			
			/**
			 * 透明效果
			 */
			function transparent(){
				imgNode.animate({
					opacity: 0
				  }, 0, function() {
				  });
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
				imgNode.eq(index).animate({
					opacity: 1
				  }, 1000, function() {
					  _stop();
					  time = setTimeout(imgMove, timer);
				  });
			}
			
			/** 
			 * 移动效果：每一张图片分10次移动
			 */
			function oneImgMove(){
				var nowMoveRange = (index * moveRange) - imgArea[0][scroll],
				partImgRange = nowMoveRange > 0 ? Math.ceil(nowMoveRange / 10) : Math.floor(nowMoveRange / 10);
				imgArea[0][scroll] += partImgRange;
				if (partImgRange == 0){
					imgNode.eq(index).addClass(defaultClass);
					tabNode.eq(index).addClass(defaultClass);
					photoName.text(imgNode.eq(index).find("img").attr("title"));
					partImgRange = null;
					_stop();
					time = setTimeout(imgMove, timer);
				}
				else{
					partTime = setTimeout(oneImgMove,30);	
				}
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
			}

			/**
			 * 节点css类名操作
			 */ 
			function classOper(arr,className,flag){
				arr.each(function(ind,n){
					n.eq(index).removeClass(className);
				})
				flag?(index++):(index--);
				arr.each(function(ind,n){
					n.eq(index).addClass(className);
				});
			}
		},
		/* 
		 * @function 片段轮播：1、根据用户设置的宽度和高度来确定轮播图的大小。2、可自定义向左、向上轮播和渐变轮播参数。3、可设置轮播时间。
		 * @description 主要应用于html片段轮播，即雷宁轮播模块。此模块和图片轮播功能类似，差异之处在于图片轮播的数据是用户自己上传的图片，html片段轮播每一屏都是一个自定义编辑器，里面的内容全部由用户自定义。
		 * @param：
		 * @author 20130114 by bjwanchuan
		 */
		slideHtml:function(args){
			
			// 定义传入的CSS调用变量
			var _this=this,
				param=$.extend({imgArea:'.jbannerImg', imgNodeArea:'.jImgNodeArea', imgNode:'.jbannerImg li', tabArea:'.jbannerTab', tabNode:'.jbannerTab span', arrowLeft:'.jPreOut', arrowRight:'.jNextOut', arrowLeftOver:'jPreOver', arrowRightOver:'jNextOver', defaultClass:'show', slideDirection:'left', timer:'3', subFunction:'transparentEffect', eventType:'click',showArrow:1}, args),
				imgArea = $(_this).find(param.imgArea),
				imgNode = $(_this).find(param.imgNode),
				tabArea = $(_this).find(param.tabArea),
				tabNode = $(_this).find(param.tabNode),
				photoName = $(_this).find(param.photoName),
				defaultClass = param.defaultClass,
				eventType = param.eventType,
				timer = !param.timer*1000?3000:param.timer*1000,
				scroll,
				ul = $(_this).find(param.imgNodeArea + '>ul'),
				imgNodeArea = $(_this).find(param.imgNodeArea),
				isFull = param.isFull;

			//全局变量
			var index = 0,direction = 1,time = null,moveRange = 0,partTime = null,animate = null;
			if(!imgNode.length) return;
			
			/**
			 * 轮播图所有效果
			 */
			var banner = {
				transparentEffect : function(){
					//初始化
					$(_this).css({'background-color':imgNode.eq(index).attr('background')});
					
					// 调用函数
					init();
					triggerThumbnail();
					triggerDirection();
					if(param.showArrow!=1){triggerArrow();}
					animate = transparent;
					time = setTimeout(imgMove, timer);
				},
				moveEffect : function(){
					var isTop = (param.slideDirection == 'top')?true:false;
					scroll = (isTop)?"scrollTop":"scrollLeft";
					
					//初始化
					$(_this).css({'background-color':imgNode.eq(index).attr('background')});
					if(isTop){
						imgNodeArea.css({height:20000});
						imgNode.css({width:imgNode.attr("width"),height:imgNode.attr("height")});
						moveRange = imgNode.height();
						imgArea[0][scroll] = index * moveRange;
					}else{
						imgNodeArea.css({width:20000});
						imgNode.css({width:imgNode.attr("width"),height:imgNode.attr("height"),'float':"left"});//将这个宽度写在css里，在ie6下面，获取到的父级宽度是被这个元素撑开的宽度
						moveRange = imgNode.width();
						imgArea[0][scroll] = index * moveRange;
					};
					
					// 调用函数
					init();
					triggerThumbnail();
					triggerDirection();	
					if(param.showArrow!=1){triggerArrow();}
					animate = oneImgMove;
					time = setTimeout(imgMove, timer);
				}
			};
			
			/**
			 * 根据传入的子方法名执行对应的子方法
			 */
			if(banner[param.subFunction])
				banner[param.subFunction].call(_this);
			
			/**
			 * 轮播图初始化
			 */
			function init(){
				imgArea.css({width:imgNode.attr("width"),height:imgNode.attr("height")});
				imgNode.eq(0).addClass(defaultClass);
				tabNode.eq(0).addClass(defaultClass);
				autoMiddle();
				$(window).resize(function(){
					autoMiddle();
				});
			}
			
			/**
			 * 轮播图自适应居中于屏幕中间
			 */
			function autoMiddle(){
				var extra = imgArea.width()-$(_this).width();
				if(extra>0){
					imgArea.css({'margin-left':-extra/2});
				}else{
					imgArea.css('margin','0 auto');
				}
			}
			
			/**
			 * 给每个tab缩略图绑定事件
			 */ 
			function triggerThumbnail(){
				tabNode.each(function(i,elem){
					$(elem)[eventType](function(){			   
						imgNode.eq(index).removeClass(defaultClass);
						tabNode.eq(index).removeClass(defaultClass);
						index = i;
						imgNode.eq(index).addClass(defaultClass);
						tabNode.eq(index).addClass(defaultClass);
						animate();
						return false;
					});
				});
			}
			
			/**
			 * 点击箭头或数字时，重置时间
			 */
			function _stop(){
				clearTimeout(time);
				time = null;
				clearTimeout(partTime);
				partTime = null;
				ul.clearQueue();
				imgNode.eq(index).clearQueue();
			}
			
			/**
			 * 切换图片和缩略图
			 */ 
			function imgMove(){
				if (direction == 1){
					if (index < imgNode.length - 1){
						classOper([imgNode,tabNode],defaultClass,true);
					}else{
						direction = 0;
						classOper([imgNode,tabNode],defaultClass,false);
					}
				}else{
					if (index > 0){
						classOper([imgNode,tabNode],defaultClass,false);
					}else{
						direction = 1;
						classOper([imgNode,tabNode],defaultClass,true);
					}
				}
				animate();
			}
			
			/**
			 * 鼠标移动显示左右移动箭头
			 */
			function triggerArrow(){
				var arrowLeft = $(_this).find(param.arrowLeft),arrowRight = $(_this).find(param.arrowRight);
				$(_this).bind({
					mouseover:function(){
						arrowLeft.show();
						arrowRight.show();
					},
					mouseout:function(){
						arrowLeft.hide();
						arrowRight.hide();
					}
				 });
			}
			
			/**
			 * 处理左右移动箭头
			 */
			function triggerDirection(){
				var arrowLeft = $(_this).find(param.arrowLeft),arrowRight = $(_this).find(param.arrowRight),
					arrowLeftOver = param.arrowLeftOver, arrowRightOver = param.arrowRightOver;
				
				arrowLeft.bind({
					click:function(){
						if(index != 0){// 判断当前是不是第一张
							classOper([imgNode,tabNode],defaultClass,false);
							animate();
						}
						return false;
					},
					mouseover:function(){$(this).addClass(arrowLeftOver);},
					mouseout:function(){$(this).removeClass(arrowLeftOver);}
				});
				arrowRight.bind({
					click:function(){
						if(index < imgNode.length - 1){// 判断当前是不是最后一张
							classOper([imgNode,tabNode],defaultClass,true);
							animate();
						}
						return false;
					},
					mouseover:function(){$(this).addClass(arrowRightOver);},
					mouseout:function(){$(this).removeClass(arrowRightOver);}
				});
			}
			
			/**
			 * 透明效果
			 */
			function transparent(){
				imgNode.animate({
					opacity: 0
				  }, 0, function() {
				  });
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
				imgNode.eq(index).animate({
					opacity: 1
				  }, 1000, function() {
					  _stop();
					  time = setTimeout(imgMove, timer);
				  });
				
			}
			
			/** 
			 * 移动效果：每一张图片分10次移动
			 */
			function oneImgMove(){
				var nowMoveRange = (index * moveRange) - imgArea[0][scroll],
				partImgRange = nowMoveRange > 0 ? Math.ceil(nowMoveRange / 10) : Math.floor(nowMoveRange / 10);
				imgArea[0][scroll] += partImgRange;
				if (partImgRange == 0){
					imgNode.eq(index).addClass(defaultClass);
					tabNode.eq(index).addClass(defaultClass);
					partImgRange = null;
					_stop();
					time = setTimeout(imgMove, timer);
				}
				else{
					partTime = setTimeout(oneImgMove,30);	
				}
				$(_this).css({'background-color':imgNode.eq(index).attr('background')});
			}

			/**
			 * 节点css类名操作
			 */ 
			function classOper(arr,className,flag){
				arr.each(function(ind,n){
					n.eq(index).removeClass(className);
				})
				flag?(index++):(index--);
				arr.each(function(ind,n){
					n.eq(index).addClass(className);
				});
			}
		},
		/*
		 * @function：改变图片：事件触发小图查看大图。
		 * @description：主要应用于商品推荐、主从商品等模块，能取到同一张不同尺寸大小的图片，这样就可以实现事件触发小图查看大图的效果。
		 * @param：
		 * @author：20130114 by bjwanchuan
		 */
		changePhoto : function(args){
			var param = $.extend({changePhotoNode:'.jPic img' , smallPhoto:'.jScrollWrap li', title:'.jDesc a', defaultClass:'jCurrent', eventType:'click'} , args || {}),
				_this = $(this),
				largePhoto = _this.find(param.changePhotoNode),
				smallPhoto = _this.find(param.smallPhoto),
				title = _this.find(param.title);
			
			//初始化
			largePhoto.attr('src' , smallPhoto.eq(0).attr('data-src'));
			largePhoto.parent().attr('href' , smallPhoto.eq(0).attr('data-href'));
			title.attr('href' , smallPhoto.eq(0).attr('data-href'));
			
			smallPhoto.eq(0).addClass(param.defaultClass);
			
			//触发小图
			smallPhoto[param.eventType](function(){
				var _target = this;
				
				largePhoto.attr('src' , $(_target).attr('data-src'));
				largePhoto.parent().attr('href' , $(_target).attr('data-href'));
				title.attr('href' , $(_target).attr('data-href'));
				
				//切换大图的时候 同时切换关注商品的input 结点ID
				var goodsFollow = $(_target).parents("li.jSubObject");
				if( typeof goodsFollow != "undefined" && typeof $(_target).attr('sid') != "undefined" ){
					var btnColl = jQuery(goodsFollow).find(".btn-coll");
					if( typeof btnColl.attr('id') != "undefined" ){
						btnColl.attr('id',"coll"+ $(_target).attr('sid') );
					}	
				}
				
				$(_target).addClass(param.defaultClass).siblings().removeClass(param.defaultClass);
			});
		},
		/*
		 * @function：移动图片：点击左右箭头移动图片。
		 * @description：主要应用于主从商品等模块，当容器宽度有限，图片却很多时，点击左右箭头就可移动图片。
		 * @param：
		 * @author：20130114 by bjwanchuan
		 */
		movePhoto : function(args){
			var param = $.extend({movePhotoNode:'.jScrollWrap li' , arrowPrev:'.jScrollPrev', arrowNext:'.jScrollNext', defaultClass:'disabled'} , args || {}),
				_this = $(this),
				node = _this.find(param.movePhotoNode),
				prev = _this.find(param.arrowPrev),
				next = _this.find(param.arrowNext),
				visibleNode = parseInt(node.parent().parent().width()/node.width()),
				index = 0,
				length = node.length;
			
			//初始化结构
			if(length > visibleNode){
				prev.addClass(param.defaultClass).show();
				next.show();
				node.parent().css('width',node.width()*length);
			}
			
			//向右移动
			next.click(function(){
				var _this = this;
				
				if(length - visibleNode){
					prev.removeClass(param.defaultClass);
				}
				
				if(index < length - visibleNode){
					index++;
					node.parent().animate({
						left:-node.eq(0).outerWidth(true)*index
					},function(){
						if(index + visibleNode == length){
							$(_this).addClass(param.defaultClass);
						}
					});
				}
			});
			
			//向左移动
			prev.click(function(){	
				var _this = this;
				if(index  + visibleNode <= length){
					next.removeClass(param.defaultClass);
				}

				if(index > 0){
					index--;
					node.parent().animate({
						left:-node.eq(0).outerWidth(true)*index
					},function(){
						if(!index){
							$(_this).addClass(param.defaultClass);
						}
					});
				}
			});	
		},
		/*
		 * @function：操作节点：通过不同的条件，调用不同的方法，查找对象里面的某一个或一些节点，并对这些节点做操作，默认为增加一个样式。
		 * @description：可应用于任意模块，只要有使用场景。
		 * @param：如{operateNode:'li', operateParentNode:null, defaultClass:'jCurrent', length:0, subFunction:null, number:[], callBack:null}
		 * operateNode为需要查找的节点；operateParentNode为查找节点的父级节点；defaultClass为默认样式名；length为每一行的节点个数；subFunction为此方法里面的子方法；
		 * number为数组对象，当使用getNode方法时，表示数组里面指定的节点，当使用getColumn方法时，表示指定的列节点。当使用getRow方法时，表示指定的行节点；
		 * callBack为函数体，参数接收一个节点对象，可在函数体里对接收的这个对象做操作。
		 * @author：20130114 by bjwanchuan
		 */
		operateNode: function(args){
			var param = $.extend({operateNode:'li', operateParentNode:null, defaultClass:'jCurrent', length:0, subFunction:null, number:[], callBack:null},args||{}),
			_this = $(this),
			node = _this.find(param.operateNode),
			nodeParent = (_this.find(param.operateParentNode).length > 0) ? _this.find(param.operateParentNode) : _this.parent().parent().parent(),
			defaultClass = param.defaultClass,
			number = param.number,
			length = (param.length != 0) ? param.length : parseInt(nodeParent.outerWidth(true)/node.outerWidth(true)),
			callBack = typeof(param.callBack) === 'function' ? param.callBack : function(a){a.addClass(defaultClass);};
		
			if(node.length === 0) return;
			
			//ie9下获取nodeParent.outerWidth(true)有差异。为避免此问题，1、可传入明确知道宽度的节点；2、程序会取this的父级的父级的父级定义了宽度的层。
			//此段尚未使用，当元素隐藏后获取不到元素的偏移值
			var rowLen = 0;
			var nowTop = $(node[0]).offset().top;
			node.each(function(index, dom){
				if(index > 0){
					rowLen++;
					var _top = $(dom).offset().top;
					if(nowTop !== _top){
						return false;
					}else{
						nowTop = _top;
					}
				}
			});
			
			var operate = {
				//获取任意节点
				getNode : function(){
					return node.map(function(i,e){
						for(var j = 0; j < number.length; j++){
							if(i + 1 === number[j]){
								return e;
							}
						}
					});
				},
				//获取所有奇数列节点
				getAllOdd : function (){
					return node.map(function(i, e){
						if(i % 2 === 0){
							return e;
						}
					})
				},
				//获取所有偶数列节点
				getAllEven : function(){
					return node.map(function(i,e){
						if(i % 2 === 1){
							return e;
						}
					});
				},
				//获取任意多列节点
				getColumn : function(){
					return node.map(function(i,e){
						for(var j = 0; j < number.length; j++){
							if(i % length === number[j] - 1){
								return e;
							}
						}
					});
				},
				//获取任意多行节点
				getRow : function(){
					return node.map(function(i,e){
						for(var j = 0; j < number.length; j++){
							if(i >= length * (number[j] - 1) && i < length * number[j]){
								return e;
							}
						}
					});
				},
				//获取每一行的奇数节点
				getRowOdd : function(){
					return node.map(function(i,e){
						if(i % length % 2 === 0){
							return e;
						}
					});
				},
				//获取每一行的偶数节点
				getRowEven : function(){
					return node.map(function(i,e){
						if(i % length % 2 === 1){
							return e;
						}
					});
				},
				//获取第一个节点
				getFirst : function(){
					return node.eq(0);
				},
				//获取最后一个节点
				getLast : function(){
					return node.eq(node.length - 1);
				},
				//获取每一行的第一个节点
				getRowFirst : function(){
					return node.map(function(i,e){
						if(i % length === 0){
							return e;
						}
					});
				},
				//获取每一行的最后一个节点
				getRowLast : function(){
					return node.map(function(i,e){
						if(i % length === length - 1){
							return e;
						}
					});
				},
				//获取每一行的第一个节点和最后一个节点
				getRowFirstAndLast : function(){
					return node.map(function(i,e){
						if(i % length === 0 || i % length === length - 1){
							return e;
						}
					});
				}
			}
			
			if(operate[param.subFunction]){
				callBack(operate[param.subFunction]());
			}
		},
		/*
		 * @function： 移动节点
		 * @description：点击左右箭头移动节点，可移动单个节点，也可移动一屏节点，可左右移动，也可左右循环移动
		 * @param：moveNode需要移动的节点；arrowPrev左箭头；arrowNext右箭头；disabled箭头不可用样式；showNum一屏显示数量，可传入正确的一屏数量，没传则程序计算；
					cssValue改变的css属性名；isLoop是否循环，默认为真；isScreen是否是移动一屏，默认为真；timer每一次移动的时间，默认为1，值取0-4之间。
		 * @note：如果是移动一屏，则需要的节点总数量必须为每一屏可显示的整数倍；如果是循环切换，disabled参数可不用。
		 * @author： cdwanchuan@jd.com 2014-03
		*/
		moveNode : function(args){
			var param = $.extend({moveNode:'.scroll-area li' , arrowPrev:'.arrow-left', arrowNext:'.arrow-right', disabled:'disabled', showNum:'', cssValue:'margin-left', isLoop:true, isScreen:true, timer:1} , args || {}),
				_this = $(this),
				node = _this.find(param.moveNode),
				prev = _this.find(param.arrowPrev),
				next = _this.find(param.arrowNext),
				showNum = (param.showNum> 0)? parseInt(param.showNum) : Math.ceil(node.parent().parent().width()/node.outerWidth(true)),
				index = 0,
				length = param.isScreen ? Math.ceil(node.length/showNum) : node.length,
				eventFlag = true,
				moveWidth = param.isScreen ? showNum*node.eq(0).outerWidth(true) : node.eq(0).outerWidth(true),
				visibleNum = param.isScreen ? 1 : showNum,
				timer = !(param.timer > -1 && param.timer < 5) ? 1000 : param.timer*1000;
			
			if(length > visibleNum){
				prev.show().addClass(param.disabled);
				next.show();
				node.parent().css('width',moveWidth*length*10);
				
				if(param.isLoop){initLoop();}
			}
			
			function initLoop(){
				for(var i=0; i<showNum; i++){
					node.eq(i).clone().appendTo(node.parent());
					node.eq(node.length-1-i).clone().prependTo(node.parent());
				}
				node.parent().css(param.cssValue,-moveWidth*visibleNum + parseInt(node.parent().css(param.cssValue)));	
			}
			
			var cssJson = {};
			node.parent().data('cssInitValue', parseInt(node.parent().css(param.cssValue)));
			
			next.click(function(){
				if(!param.isLoop){
					if(index == 0) eventFlag = true;
				}
				
				if(eventFlag){
					eventFlag = false;
					index++;
					cssJson[param.cssValue] = -moveWidth*index + node.parent().data('cssInitValue');
					
					node.parent().animate(cssJson, timer, function(){
						eventFlag = true;
						if(!param.isLoop){
							if(index > 0){
								prev.removeClass(param.disabled);
							}
							if(index+visibleNum == length){
								next.addClass(param.disabled);
								eventFlag = false;
							}
						}else{
							if(index == length){
								index = 0;
								node.parent().css(param.cssValue,node.parent().data('cssInitValue'));	
							}
						}
					});
				}
			});
			
			prev.click(function(){
				if(!param.isLoop){
					eventFlag = (index > 0) ? true :false;
				}
				
				if(eventFlag){
					eventFlag = false;
					index--;
					cssJson[param.cssValue] = -moveWidth*index + node.parent().data('cssInitValue');
					
					node.parent().animate(cssJson, timer, function(){
						eventFlag = true;
						if(!param.isLoop){
							if(index < length - 1){
								next.removeClass(param.disabled);
							}
							if(index == 0){
								prev.addClass(param.disabled);
								eventFlag = false;
							}
						}else{
							if(index < 0){
								index = length-1;
								node.parent().css(param.cssValue,node.parent().data('cssInitValue')+(-moveWidth*index));	
							}
						}
					});
				}
			});	
		},
		/*
		 * @function：多行省略号 ：计算文字的数量，超过一定的数量后，剩余的用其他传入的字符替换。
		 * @description：主要应用于商品展示类模块中，如商品推荐、分页显示商品、店内搜索结果、主从商品等等模块，当商品标题太长而布局容器有限时使用。
		 * @param：如{title:'.jDesc a', count:15, text:'...'}。title需要替换的文字节点；count文字的数量；text用于替换的字符；
		 * @author：20130114 by bjwanchuan
		 */
		addEllipsis:function(args){
		   var param = $.extend({title:'.jDesc a', count:15, text:'...'}, args),
		   		_this = $(this),
				elem = _this.find(param.title);
		   
			elem.each(function(index, ele){
				var textNode=ele.firstChild;
				if(textNode && textNode.nodeType==3 && textNode.length>=param.count){
					textNode.replaceData(param.count, textNode.length, param.text);
				}					   
			});
	   },
		shopSearch : function(args){
			jshop.module.search.shopSearch.call(this,args);
		},
		follow : (function(){
			    // 默认参数设置
			var _default = {
				// 关注店铺Api
				shopApi: "http://follow.soa.jd.com/vender/follow",
				// 关注活动Api
				actApi: "http://follow.soa.jd.com/activity/follow",
				// 已收藏店铺数量Api
				shopCountApi: "http://follow.soa.jd.com/vender/queryForCount",
				// 已收藏活动数量Api
				actCountApi: "http://follow.soa.jd.com/activity/queryForCount",
				// 关注商品Api
				goodsApi: "",
				// 默认关注类型（店铺）
				type: "shopId"
			};

			function newTagOnfocus() {
				var val = jQuery("#newTag").val();
				val = val.trim();
				if (val == jQuery("#newTag").attr("placeholder")) {
					jQuery("#newTag").val("");
				}
			}

			function checkLength(node) {
				if (node.value.length > 10) {
					node.value = node.value.substring(0, 10);
				}
			}


			function Follow(cfg,scope) {
				this.config = jQuery.extend({}, cfg);

				var config = jQuery.extend({}, this.config);
				this.container = $(config.node,scope);

				this.get = function(p) {
					return config[p];
				};
				this.set = function(p, v) {
					config[p] = v;
				};

				this.init();
			}

			Follow.FollowVMContent = '<div id="whole">'
									+ '<div id="followSuccessDiv">'
									+ '<div class="tips" id="success"> <h2>关注成功！</h2>'
									+ '<p><em id="followNum"></em>'
									+ '<a target="_blank" href="http://t.jd.com/vender/followVenderList.action">查看我的关注&gt;&gt;</a>'
									+ '</p></div>'
									+ '<div id="attention-tags"><div class="mt">'
									+ "<h4>选择标签<em>（最多可选3个）</em></h4>"
									+ '<div class="extra"></div></div>'
									+ '<div class="mc"><div id="followTags"></div>'
									+ '<div class="att-tag-btn">'
									+ '<a href="javascript:void(0);" class="att-btn-ok">确定</a>'
									+ '<a class="att-btn-cancal" href="javascript:jdThickBoxclose()">取消</a>'
									+ '<span id="follow_error_msg"  class="att-tips fl"></span></div></div>'
									+ '</div></div>'
									+ '<div id="followTopicSuccessDiv">'
									+ '<div id="att-mod-success">'
									+ '<div class="att-img fl"><img src="http://misc.360buyimg.com/201007/skin/df/i/icon_correct.jpg" alt=""></div>'
									+ '<div class="att-content"><h2>关注成功</h2>'
									+ '<p><em id="followTopicNum" ></em>'
									+ '<a target="_blank" href="http://t.jd.com/activity/followActivityList.action">查看我的关注 &gt;&gt;</a>'
									+ '</p></div>'
									+ '<div class="att-tag-btn">'
									+ '<a class="att-btn-cancal" href="javascript:jdThickBoxclose()" onclick="jdThickBoxclose()">关闭</a>'
									+ '</div></div></div>'
									+ '<div id="followFailDiv" >'
									+ '<div id="att-mod-again">'
									+ '<div class="att-img fl">'
									+ '<img src="http://misc.360buyimg.com/201007/skin/df/i/icon_sigh.jpg" alt="">'
									+ '</div><div class="att-content"><h2>关注失败</h2>'
									+ '<p><a id=\'followFailSeeFollowUrl\' target="_blank" href="http://t.jd.com/vender/followVenderList.action">查看我的关注 &gt;&gt;</a></p>'
									+ '</div><div class="att-tag-btn"><a class="att-btn-cancal" href="javascript:jdThickBoxclose()">关闭</a></div>'
									+ '</div></div><div id="followMaxDiv">'
									+ '<div id="att-mod-again">'
									+ '<div class="att-img fl">'
									+ '<img src="http://misc.360buyimg.com/201007/skin/df/i/icon_sigh.jpg" alt="">'
									+ '</div><div class="att-content">'
									+ '<h2>关注数量达到最大限制</h2>'
									+ '<p><a id=\'followMaxSeeFollowUrl\' target="_blank" href="http://t.jd.com/vender/followVenderList.action">查看我的关注 &gt;&gt;</a></p>'
									+ '</div><div class="att-tag-btn">'
									+ '<a class="att-btn-cancal" href="javascript:jdThickBoxclose()">关闭</a></div>'
									+ '</div></div><div id="followedDiv">'
									+ '<div id="att-mod-again"><div class="att-img fl">'
									+ '<img src="http://misc.360buyimg.com/201007/skin/df/i/icon_sigh.jpg" alt="">'
									+ '</div><div class="att-content">'
									+ '<h2 id="followedTitle"></h2>'
									+ '<p><em id="followedNum"></em>'
									+ '<a id=\'followedSeeFollowUrl\' target="_blank" href="">查看我的关注 &gt;&gt;</a>'
									+ '</p></div><div class="att-tag-btn">'
									+ '<a class="att-btn-cancal" href="javascript:jdThickBoxclose()">关闭</a></div></div>'
									+ '</div></div>';

			Follow.prototype = {
				init: function() {
					var _this = this;

					_this.bindEvent();

				},
				bindEvent: function() {
					var _this = this;

					_this.container.click(function(){
						thick_login(function(){
							_this.addFollow();
						});
					   
					});
					// 为确定按钮添加事件代理，删除dom中的onclick事件绑定
					jQuery("body").delegate(".att-btn-ok", "click", function(){
						_this.doSubmit();
					});
				},
				addFollow: function() {
					var _this = this, api;
					if (_this.get("type") == "shopId") {
						api = _this.get("shopApi");
						api += "?venderId=" + _this.get("id");
					} else {
						api = _this.get("actApi");
						api += "?activityId=" + _this.get("id");
						api += "&srcType=0";
					}

					// documentFragment
					Follow.followVM = jQuery(Follow.FollowVMContent);
					// 根据不同关注类型，发送关注请求
					jQuery.ajax({
						async: false,
						url: api,
						dataType: "jsonp",
						success: function(data) {
							_this.followSuccess(data);
						},
						error: function(data, xhr) {
							_this.followShopFail();
						}
					});
				},
				followSuccess: function(data) {
					this.checkResult(data, this.followSuccessCallBack, this.followed, this.followShopMax);
				},
				checkResult: function(data, callback, followed, max) {
					// 根据不同的关注状态，弹出不同的提示浮层
					switch(data.code) {
						case "F10000":
							callback && callback.call(this);
							break;
						case "F0409":
							followed && followed.call(this);
							break;
						case "F0410":
							max && max.call(this);
							break;
						default:
							this.followShopFail.call(this);
					}
				},
				// 关注成功
				followSuccessCallBack: function() {
					var _this = this, api, type = _this.get("type");
					if (type == "shopId") {
						api = _this.get("shopCountApi");
					} else {
						api = _this.get("actCountApi");
					}
					_this.getFollowNum(api, function(data) {
						if (data.code == "F10000") {
							var outStr;
							if (type == "shopId") {
								outStr = "您已关注" + data.data + "个店铺";
								Follow.followVM.find("#followNum").html(outStr);
							} else {
								outStr = "您已关注" + data.data + "个活动";
								Follow.followVM.find("#followTopicNum").html(outStr);
							}
						}
						if (type == "shopId") {
							_this.getFollowTags();
						} else {
							_this.ShowFollowTopicSuc();
						}
					});
				},
				// 获取关注数
				getFollowNum: function(url, cb) {
					var _this = this;
					jQuery.ajax({
						async: false,
						url: url,
						dataType: "jsonp",
						success: function(data) {
							cb && cb(data);
						},
						error: function(data, shr) {
							_this.followShopFail();
						}
					});
				},
				// 获取关注标签
				getFollowTags: function() {
					var _this = this;
					jQuery.ajax({
						async: false,
						url: "http://follow.soa.jd.com/vender/queryTagForListByCount?count=5",
						dataType: "jsonp",
						success: function(data) {
							_this.fillInTags(data);
							_this.ShowFollowSuc();
						},
						error: function(data, D) {
							_this.followShopFail();
						}
					});
				},
				// 写入添加关注标签的dom结构
				fillInTags: function(data) {
					var _this = this,
						obj = data,
						len = obj.data.length,
						dom = "";
					dom += "<ul id='oldTags' class='att-tag-list'>";
					var str;
					for (var i = 0; i < len; i++) {
						// var H = "att-tag" + i;
						str = obj.data[i];
						str = decodeURIComponent(str);
						dom += "<li><a href='javascript:void(0)' class='J_ChooseTagOne'>" + str + "</a></li>";
					}
					dom += "</ul>";
					dom += "<ul id='newTags' class='att-tag-list att-tag-list-save'>";
					dom += "<li id='att-tag-new' class='att-tag-new'><input id='newTag' type='text' placeholder='自定义' maxlength='10'><span id='J_SaveTagOneBtn'>添加</span></li>";
					dom += "</ul>";
					dom += "";
					Follow.followVM.find("#followTags").html(dom);
				},
				ShowFollowSuc: function() {
					var _this = this, title = "提示", node = jQuery("#dialogDiv");
					node.html('<a id="dialogA" href="#"></a>');
					$.jdThickBox({
						width: 510,
						height: 260,
						title: title,
						_box: "btn_coll_shop_pop",
						source: Follow.followVM.find("#followSuccessDiv").html()
					}, function() {
						var spop = jQuery("#btn_coll_shop_pop"),
							spop_mc = jQuery("#attention-tags").find(".mc");
						spop.find(".thickcon").css("height", "auto");
						spop.css("height", "auto");
						jQuery("#newTag").val(jQuery("#newTag").attr("placeholder"));

						// 绑定标签输入框focus、keyup事件，用于验证标签合法性，一处dom中的onxxx事件属性
						jQuery("#newTag").unbind("focus").focus(function(){
							newTagOnfocus();
						});
						jQuery("#newTag").unbind("keyup").keyup(function(){
							checkLength(this);
						});
						// 标签选中/取消功能绑定
						jQuery(".J_ChooseTagOne").unbind("click").click(function(){
							_this.chooseTag.call(_this, this);
						});
						// 添加标签按钮事件绑定
						jQuery("#J_SaveTagOneBtn").unbind("click").click(function(){
							_this.saveNewTag.call(_this);
						});
					});
				},
				// 显示活动关注成功提示浮层
				ShowFollowTopicSuc: function() {
					var title = "提示", node = jQuery("#dialogDiv");
					node.html('<a id="dialogA" href="#"></a>');
					$.jdThickBox({
						width: 300,
						height: 80,
						title: title,
						_box: "btn_coll_shop_pop",
						source: Follow.followVM.find("#followTopicSuccessDiv").html()
					});
				},
				// 关注店铺失败
				followShopFail: function() {
					var node = jQuery("#dialogDiv");
					node.html('<a id="dialogA" href="#"></a>');
					if (this.get("type") == "shopId") {
						Follow.followVM.find("#followFailSeeFollowUrl").attr("href", "http://t.jd.com/vender/followVenderList.action");
					} else {
						Follow.followVM.find("#followFailSeeFollowUrl").attr("href", "http://t.jd.com/activity/followActivityList.action");
					}
					$.jdThickBox({
						width: 300,
						height: 80,
						title: "提示",
						source: Follow.followVM.find("#followFailDiv").html()
					});
					return;
				},
				// 关注上限提示
				followShopMax: function() {
					var node = jQuery("#dialogDiv");
					node.html('<a id="dialogA" href="#"></a>');
					if (this.get("type") == "shopId") {
						Follow.followVM.find("#followMaxSeeFollowUrl").attr("href", "http://t.jd.com/vender/followVenderList.action");
					} else {
						Follow.followVM.find("#followMaxSeeFollowUrl").attr("href", "http://t.jd.com/activity/followActivityList.action");
					}
					$.jdThickBox({
						width: 300,
						height: 80,
						title: "提示",
						source: Follow.followVM.find("#followMaxDiv").html()
					});
					return;
				},
				// 重复关注同一店铺提示
				followed: function() {
					var _this = this, tip = "", url, type = this.get("type");
					if (type == "shopId") {
						tip = "已关注过该店铺";
						url = "http://follow.soa.jd.com/vender/queryForCount";
						Follow.followVM.find("#followedSeeFollowUrl").attr("href", "http://t.jd.com/vender/followVenderList.action");
					} else {
						tip = "已关注过该活动";
						url = "http://follow.soa.jd.com/activity/queryForCount";
						Follow.followVM.find("#followedSeeFollowUrl").attr("href", "http://t.jd.com/activity/followActivityList.action");
					}
					Follow.followVM.find("#followedTitle").html(tip);
					this.getFollowNum(url, function(data) {
						if (data.code == "F10000") {
							var outStr;
							if (type == "shopId") {
								outStr = "您已关注" + data.data + "个店铺";
							} else {
								outStr = "您已关注" + data.data + "个活动";
							}
							Follow.followVM.find("#followedNum").html(outStr);
						}
						var dialog = jQuery("#dialogDiv");
						dialog.html('<a id="dialogA" href="#"></a>');
						$.jdThickBox({
							width: 300,
							height: 80,
							title: "提示",
							source: Follow.followVM.find("#followedDiv").html()
						});
					});
				},
				// 标签提交保存操作
				doSubmit: function() {
					var _this = this, str = "", counter = 0;
					jQuery("#oldTags").find("a").each(function(index, item) {
						if ("true" == jQuery(this).attr("isCheck")) {
							counter++;
							if (str == "") {
								str = jQuery(this).html();
							} else {
								str = str + "," + jQuery(this).html();
							}
						}
					});
					jQuery("#newTags").find("a").each(function(index, item) {
						if ("true" == jQuery(this).attr("isCheck")) {
							counter++;
							if (str == "") {
								str = jQuery(this).html();
							} else {
								str = str + "," + jQuery(this).html();
							}
						}
					});
					if (str == "") {
						_this.showErrorMsg("请至少提供1个标签");
						return;
					}
					if (counter > 3) {
						_this.showErrorMsg("最多可选择3个标签");
						return;
					}
					str = encodeURIComponent(str);
					var url = "http://follow.soa.jd.com/vender/editTag";
					jQuery.ajax({
						async: false,
						url: url,
						dataType: "jsonp",
						data: {
							venderId: _this.get("id"),
							tagNames: str
						},
						success: function(data) {
							if (data.code == "F10000") {
								jQuery("#follow_error_msg").removeClass();
								jQuery("#follow_error_msg").addClass("hl_green fl");
								jQuery("#follow_error_msg").html("设置成功");
								jQuery("#follow_error_msg").show();
								setTimeout(function() {
									jdThickBoxclose();
								}, 5000);
							} else {
								if (data.code == "F0410") {
									_this.showErrorMsg("设置的标签数超过最大限制");
								} else {
									_this.showErrorMsg("设置失败");
								}
							}
						},
						error: function(data, xhr) {
							_this.showErrorMsg("设置失败");
						}
					});
				},
				showErrorMsg: function(err) {
					jQuery("#follow_error_msg").removeClass();
					jQuery("#follow_error_msg").addClass("att-tips fl");
					jQuery("#follow_error_msg").html(err);
					jQuery("#follow_error_msg").show();
					setTimeout(function() {
						jQuery("#follow_error_msg").hide();
					}, 3000);
				},
				saveNewTag: function() {
					var _this = this, val = jQuery("#newTag").val();
					val = val.trim();
					if (val.trim().length > 10) {
						this.showErrorMsg("长度不能超过10个字符");
						return;
					}
					var valid = this.validateNewTag(val);
					if (!valid) {
						this.showErrorMsg("标签数字、字母、汉字组成");
						return;
					}
					if (val == "" || val == jQuery("#newTag").attr("placeholder")) {
						this.showErrorMsg("请输入自定义名称！");
						jQuery("#newTag").val(jQuery("#newTag").attr("placeholder"));
						return;
					}
					jQuery("<li isNewAdd='true' ><a class='current' href='javascript:void(0)' isCheck='true' >" + val + "</a></li>").insertBefore(jQuery("#att-tag-new"));
					var content = jQuery("li[isNewAdd]"), tags = jQuery("li[isNewAdd] > .current");
					if (content.length >= 3) {
						jQuery("#att-tag-new").attr("style", "display:none");
					}
					tags.unbind("click").click(function(){
						_this.chooseTag(this);
					});
					jQuery("#newTag").val(jQuery("#newTag").attr("placeholder"));
				},
				chooseTag: function(tag) {
					var tNode = jQuery(tag), flag = tNode.attr("isCheck");
					if ("undefined" == typeof flag || flag == "false") {
						tNode.attr("isCheck", "true");
						tNode.addClass("current");
					} else {
						tNode.attr("isCheck", "false");
						tNode.removeClass("current");
					}
				},
				validateNewTag: function(tag) {
					var rTag = /[\u4e00-\u9fa5]|[0-9]|[a-z]|[A-Z]/g;
					var rArr = tag.match(rTag);
					var len = 0;
					if (rArr != null) {
						len = rArr.length;
					}
					if (len != tag.length) {
						return false;
					}
					return true;
				},
				getFollowedCount: function(id) {
					jQuery.ajax({
						async: false,
						url: "http://follow.soa.jd.com/vender/queryForCountByVid",
						dataType: "jsonp",
						data: {
							venderId: id
						},
						success: function(data) {
							var count = data.data;
							if (count > 500) {
								if (count > 10000) {
									count = parseInt(count / 10000);
									count = count + "万";
								}
								jQuery("#followedCount").html(count);
							}
						},
						error: function(data, shr) {}
					});
				}
			};
			
			return function(arg){
				var cfg = $.extend({},_default,arg);
				new Follow(cfg,$(this));
			}
		})()
	});
	
	
	function _execute(module){
		var _function = $(module).attr('module-function'),
			_module_name = $(module).parents('[module-name]').attr('module-name'), _param;
		if(typeof _function == 'undefined') return;
		try{
			_param = eval('(' + $(module).attr('module-param') + ')');
		}catch(e){
			_param = {};
		}
		var _functions = _function.split(',');
		_functions.each(function(index,n){
			if(jshop.module[_module_name]&&jshop.module[_module_name][n]){
				if(_param.subObj){
					$(module).find(_param.subObj).each(function(ind,q){
						jshop.module[_module_name][n].call(q,_param);
					});
				}
				else{
					jshop.module[_module_name][n].call(module,_param);
				}
			}
			else if(jshop.module[n]){
				if(_param.subObj){
					$(module).find(_param.subObj).each(function(ind,q){
						jshop.module[n].call(q,_param);
					});
				}
				else{
					jshop.module[n].call(module,_param);
				}
			}
		});
	}
	$(function(){			
		$('div.j-module').each(function(index,n){
			if(!$(n).attr('panda')){
				_execute(n);
			}
		});
	});
	
	/*
	 * 局部刷新逻辑
	 */
	w.moduleRefresh = function(){
		var _this = $(this);
		_this.each(function(index,n){
			_execute(n);
		});
	};
})(jQuery,window);

/***********************************************module lazyload***************************/
(function($,w){
	w.gModules = [];
	
	if(!Array.prototype.aUnique){
		Array.prototype.aUnique = function(arr){
			if(arr.constructor != Array)
				throw new Error('Array:aUnique, arguments error');
			var _temA = [];
			if(this.length == 0 ||(!arr.length))
				return arr;
			else{
				for(var i = 0, len = arr.length;i < len; i++){
					if(!this.isIn(arr[i])){
						_temA.push(arr[i]);
					}
				}
				return _temA;
			}
		};
	}
	
	/*
	 * 获取已经加载的模块
	 */
	function _get_modules(){
		if($('script[moduleinit="module"]').length){
			var _src = $('script[moduleinit="module"]').attr('src'),
				_js = _src.substring(_src.indexOf('?')+4,_src.indexOf('&'));
			w.gModules = _js.split(',');
		}
	}
	
	/*
	 * 新模块获取没有加载的js文件
	 */
	w.get_scripts = function(str){
		if(str == '' || str == undefined){
			return [];
		}
		var _module_scrips = str.split(',');
		return w.gModules.aUnique(_module_scrips);	
	};
	$(function(){
		_get_modules();
	});
})(jQuery,window);