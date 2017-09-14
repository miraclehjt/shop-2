$(document).ready(function() {
    CartGoods()

});
function CartGoods() {
    $.ajax({
        type: "get",
        url: "/index.php?app=shop.cart&act=header_cart_goods_new_20140915",
        async: false,
        success: function(data, textStatus) {
            var strs = new Array();
            strs = data.split("||");
            var goodsNum = strs[0];
            var strCart = strs[1];
            var login = strs[2];
            if (strs[3] == 1) {
                $('#sidetools_login').attr('href', '/index.php?app=member.member_center');
                $('#sidetools_login').attr('target', '_blank')

            }
            $("#cartBox").html(strCart);
            $("#cart_goods_num").html(goodsNum);
            $("#shopping-amount").html(goodsNum);
            setTimeout(function() {
                $(".caet-List li").hover(function() {
                    $(this).addClass("curr4")

                },
                function() {
                    $(this).removeClass("curr4")

                })

            },
            100);
            setScroll('settleup-content')

        },
        error: function() {}

    })

}
function newshowCart() {
    $("#cartBox").children("dl").addClass("hover")

}
function showCartGoods() {
    $("#cart_goods_div").show();
    $(".v8top_new1_top1").css("border-bottom", "none")

}
function hideCartGoods() {
    $("#cart_goods_div").hide();
    $(".v8top_new1_top1").css("border-bottom", "1px solid #DDD")

}
function deleteCartGoods(specID, type) {
    $.ajax({
        type: "get",
        url: "/index.php?app=shop.cart&act=removeGoods&specID=" + specID + "&type=" + type,
        success: function(data, textStatus) {
            if (data == 't') {
                var strs = new Array();
                strs = data.split("||");
                var goodsNum = strs[0];
                var strCart = strs[1];
                $("#cartBox").html(strCart);
                $("#cart_goods_num").html(goodsNum);
                $("#shopping-amount").html(goodsNum);
                CartGoods();
                newshowCart()

            } else {
                alert('删除商品失败！')

            }

        },
        error: function() {}

    })

}
function tabShift(i) {
    if (i == 5) {
        $("#5yuan").attr('class', 'gwc_tbpg1');
        $("#10yuan").attr('class', 'gwc_tbpg2');
        $("#15yuan").attr('class', 'gwc_tbpg2');
        $("#72yuan").attr('class', 'gwc_tbpg2');
        $("#5div").show();
        $("#10div").hide();
        $("#15div").hide();
        $("#72div").hide()

    }
    if (i == 10) {
        $("#5yuan").attr('class', 'gwc_tbpg2');
        $("#10yuan").attr('class', 'gwc_tbpg1');
        $("#15yuan").attr('class', 'gwc_tbpg2');
        $("#72yuan").attr('class', 'gwc_tbpg2');
        $("#5div").hide();
        $("#10div").show();
        $("#15div").hide();
        $("#72div").hide()

    }
    if (i == 15) {
        $("#5yuan").attr('class', 'gwc_tbpg2');
        $("#10yuan").attr('class', 'gwc_tbpg2');
        $("#15yuan").attr('class', 'gwc_tbpg1');
        $("#72yuan").attr('class', 'gwc_tbpg2');
        $("#5div").hide();
        $("#10div").hide();
        $("#15div").show();
        $("#72div").hide()

    }
    if (i == 72) {
        $("#5yuan").attr('class', 'gwc_tbpg2');
        $("#10yuan").attr('class', 'gwc_tbpg2');
        $("#15yuan").attr('class', 'gwc_tbpg2');
        $("#72yuan").attr('class', 'gwc_tbpg1');
        $("#5div").hide();
        $("#10div").hide();
        $("#15div").hide();
        $("#72div").show()

    }

}
function closeNoticeDiv() {
    $("#cart_successed_div").hide();
    return true

}
function closeNoticeDiv_group() {
    $("#cart_successed_div_group").hide();
    return true

}
function roundFun(numberRound, roundDigit) {
    if (numberRound >= 0) {
        var tempNumber = parseInt((numberRound * Math.pow(10, roundDigit) + 0.50)) / Math.pow(10, roundDigit);
        return tempNumber

    } else {
        numberRound1 = -numberRound;
        var tempNumber = parseInt((numberRound1 * Math.pow(10, roundDigit) + 0.50)) / Math.pow(10, roundDigit);
        return - tempNumber

    }

}
function toDecimal(x) {
    var f = parseFloat(x);
    if (isNaN(f)) {
        return false

    }
    var f = Math.round(x * 100) / 100;
    var s = f.toString();
    var rs = s.indexOf('.');
    if (rs < 0) {
        rs = s.length;
        s += '.'

    }
    while (s.length <= rs + 2) {
        s += '0'

    }
    return s

}
function clearcart() {
    if (confirm("您确定要清空购物车的所有商品吗？")) {
        var r = xajax.call('clearcart', {
            mode: 'synchronous'

        })

    }
    xajax.call('shopping_cart', {
        mode: 'synchronous'

    });
    return

}
function clearyuncart() {
    if (confirm("您确定要清空购物车的所有商品吗？")) {
        var r = xajax.call('clearyuncart', {
            mode: 'synchronous'

        })

    }
    return

}
function updateCartGoodsAmount(item_id, flg) {
    var amount_input_id = 'cart_amount_input_' + flg + '_' + item_id;
    var amount_input = document.getElementById(amount_input_id);
    var new_amount = amount_input.value;
    if (Utils.isEmpty(new_amount)) {
        amount_input.focus();
        return false

    }
    if (!Utils.isInt(new_amount)) {
        amount_input.focus();
        return false

    }
    if (new_amount < 0) {
        amount_input.focus();
        return false

    }
    if (new_amount == 0) {}
    if (flg == 88) {
        var goods_num = new_amount;
        var goods_price = $("#bill_goods_price").val();
        $("#bill_goodsNum").val(new_amount);
        cancelPoints();
        k = xajax.call('updateAmount_service', {
            mode: 'synchronous',
            parameters: [item_id, new_amount, goods_price]

        })

    } else {
        k = xajax.call('updateAmount', {
            mode: 'synchronous',
            parameters: [item_id, new_amount, flg]

        });
        if (k == 1) {
            xajax.call('showCartDiv', {
                mode: 'synchronous'

            })

        } else if (k == -1) {
            xajax.call('showCartDiv', {
                mode: 'synchronous'

            })

        }

    }
    CartGoods();
    newshowCart();
    return

}
function updateYunCartGoodsAmount(item_id, flg, store_id) {
    var amount_input_id = 'cart_amount_input_' + flg + '_' + item_id;
    var amount_input = document.getElementById(amount_input_id);
    var new_amount = amount_input.value;
    if (Utils.isEmpty(new_amount)) {
        amount_input.focus();
        return false

    }
    if (!Utils.isInt(new_amount)) {
        amount_input.focus();
        return false

    }
    if (new_amount < 0) {
        amount_input.focus();
        return false

    }
    if (new_amount == 0) {}
    k = xajax.call('updateAmount', {
        mode: 'synchronous',
        parameters: [item_id, new_amount, flg]

    });
    showCartDivYun(store_id);
    return

}
var setAmount = {
    min: 1,
    max: 3000,
    reg: function(x) {
        return new RegExp("^[1-9]\\d*$").test(x)

    },
    amount: function(obj, mode) {
        var x = $(obj).val();
        if (this.reg(x)) {
            if (mode) {
                x++

            } else {
                x--

            }

        } else {
            $(obj).val(1);
            $(obj).focus()

        }
        return x

    },
    reduce: function(obj, item_id, flg) {
        var x = this.amount(obj, false);
        if (x >= this.min) {
            $(obj).val(x);
            updateCartGoodsAmount(item_id, flg)

        }

    },
    add: function(obj, item_id, flg) {
        var x = this.amount(obj, true);
        if (x <= this.max) {
            $(obj).val(x);
            updateCartGoodsAmount(item_id, flg)

        } else {
            $(obj).val(this.max);
            $(obj).focus()

        }

    },
    modify: function(obj, item_id, flg) {
        var x = $(obj).val();
        if (x < this.min || x > this.max || !this.reg(x)) {
            alert("请输入正确的数量！");
            $(obj).val(1);
            $(obj).focus();
            updateCartGoodsAmount(item_id, flg);
            return false

        } else {
            updateCartGoodsAmount(item_id, flg)

        }

    }

};
var setAmountYun = {
    min: 1,
    max: 3000,
    reg: function(x) {
        return new RegExp("^[1-9]\\d*$").test(x)

    },
    amount: function(obj, mode) {
        var x = $(obj).val();
        if (this.reg(x)) {
            if (mode) {
                x++

            } else {
                x--

            }

        } else {
            $(obj).val(1);
            $(obj).focus()

        }
        return x

    },
    reduce: function(obj, item_id, flg, store_id) {
        var x = this.amount(obj, false);
        if (x >= this.min) {
            $(obj).val(x);
            updateYunCartGoodsAmount(item_id, flg, store_id)

        }

    },
    add: function(obj, item_id, flg, store_id) {
        var x = this.amount(obj, true);
        if (x <= this.max) {
            $(obj).val(x);
            updateYunCartGoodsAmount(item_id, flg, store_id)

        } else {
            $(obj).val(this.max);
            $(obj).focus()

        }

    },
    modify: function(obj, item_id, flg, store_id) {
        var x = $(obj).val();
        if (x < this.min || x > this.max || !this.reg(x)) {
            alert("请输入正确的数量！");
            $(obj).val(1);
            $(obj).focus();
            return false

        } else {
            updateYunCartGoodsAmount(item_id, flg, store_id)

        }

    }

};
function selectAll(o) {
    if (o.checked) {
        $("input[name='cart_goods']").each(function() {
            if (!$(this).attr("checked")) {
                var checked = $(this).attr("checked");
                var str = $(this).val();
                var str_arr = str.split("=>");
                var flg = str_arr[0];
                var postID = str_arr[1];
                var selected = 1;
                select_goods(postID, selected, flg)

            }

        });
        $("input[name='selectall']").attr("checked", true);
        $("input[name='select_store_all']").attr("checked", true)

    } else {
        $("input[name='cart_goods']").each(function() {
            if ($(this).attr("checked")) {
                var checked = $(this).attr("checked");
                var str = $(this).val();
                var str_arr = str.split("=>");
                var flg = str_arr[0];
                var postID = str_arr[1];
                var selected = 0;
                if (flg != 7) {
                    select_goods(postID, selected, flg)

                }

            }

        });
        $("input[name='selectall']").attr("checked", false);
        $("input[name='select_store_all']").attr("checked", false)

    }
    showCartDiv()

}
function clearBatchCart() {
    var str = '';
    var i = 0;
    $('input[name="cart_goods"]:checked').each(function() {
        str += $(this).val() + ',';
        i++

    });
    if (i == 0) {
        alert('请选择要删除的商品！')

    } else {
        if (!confirm('确认从购物车中删除该商品？')) return false;
        xajax.call('batchRemoveCartGoods', {
            mode: 'synchronous',
            parameters: [str]

        });
        xajax.call('showCartDiv', {
            mode: 'synchronous'

        });
        $("input[name='selectall']").attr("checked", false)

    }

}
function removeSelectedCartGoods() {
    var i = 0;
    $("input[name='cart_goods']").each(function() {
        if ($(this).attr("checked")) {
            i = i + 1

        }

    });
    if (i == 0) {
        alert('请选择您要删除的商品！');
        exit

    }
    if (!confirm('确认从购物车中删除选中的商品？')) return false;
    $("input[name='cart_goods']").each(function() {
        if ($(this).attr("checked")) {
            var checked = $(this).attr("checked");
            var str = $(this).val();
            var str_arr = str.split("=>");
            var flg = str_arr[0];
            var postID = str_arr[1];
            if (flg != 7) {
                xajax.call('removeFromCart', {
                    mode: 'synchronous',
                    parameters: [postID, flg]

                })

            }

        }

    });
    xajax.call('showCartDiv', {
        mode: 'synchronous'

    })

}
function selectStoreAll(obj) {
    if (!$(obj).attr("checked")) {
        $(obj).parents("table[name='store_goods_list']").find("input[name='cart_goods']").each(function() {
            if ($(this).attr("checked")) {
                var checked = $(this).attr("checked");
                var str = $(this).val();
                var str_arr = str.split("=>");
                var flg = str_arr[0];
                var postID = str_arr[1];
                var selected = 0;
                if (flg != 7) {
                    select_goods(postID, selected, flg)

                }

            }

        });
        $("input[name='selectall']").attr("checked", false)

    } else {
        $(obj).parents("table[name='store_goods_list']").find("input[name='cart_goods']").each(function() {
            if (!$(this).attr("checked")) {
                var checked = $(this).attr("checked");
                var str = $(this).val();
                var str_arr = str.split("=>");
                var flg = str_arr[0];
                var postID = str_arr[1];
                var selected = 1;
                select_goods(postID, selected, flg)

            }

        })

    }
    showCartDiv()

}
function change_selected(obj) {
    var checked = $(obj).attr("checked");
    var str = $(obj).val();
    var str_arr = str.split("=>");
    var flg = str_arr[0];
    var postID = str_arr[1];
    if (flg == 7) {
        return

    }
    if (checked == "checked") {
        var selected = 1

    } else {
        var selected = 0

    }
    if (select_goods(postID, selected, flg)) {
        showCartDiv()

    }

}
function select_goods(postID, selected, flg) {
    var r = xajax.call('cart_goods_selected', {
        mode: 'synchronous',
        parameters: [postID, selected, flg]

    });
    if (r != 1) {
        alert('操作失败！');
        return false

    }
    return true

}
function reset_cart_show() {
    var point = 0;
    var money = 0;
    var num = 0;
    $("input[name='cart_goods']").each(function() {
        if ($(this).attr("checked") == "checked") {
            var g_point = parseFloat($(obj).attr("point"));
            var g_price = parseFloat($(obj).attr("price"));
            point = point + g_point;
            money = money + g_price;
            num++

        }

    })

};
$(function() {
    $("#m_keywords").keyup(function(event) {
        var keywords = this.value;
        var url = SITE_URL + '/index.php?app=search.search&act=getSimilar';
        if (event.keyCode == 13) {
            if (keywords != '') {
                window.location = TAOCZ_URL + '/index.php?app=search.search&keywords=' + keywords

            }

        } else if (event.keyCode == 40) {
            nextAhover()

        } else if (event.keyCode == 38) {
            prevAhover()

        } else {
            $.getJSON(url, {
                keywords: keywords

            },
            function(data) {
                if (data.done) {
                    var retval = data.retval;
                    var len = retval.length;
                    var html = '';
                    for (var i = 0; i < len; i++) {
                        html += "<li><a href='" + TAOCZ_URL + "/index.php?app=search.search&keywords=" + retval[i] + "'>" + retval[i] + "</a></li>"

                    }
                    if (html == '') {
                        $("#simlarDown").hide().find('ul').html(html)

                    } else {
                        $("#simlarDown").show().find('ul').html(html)

                    }

                } else {
                    $("#simlarDown").hide().find('ul').html(html)

                }

            })

        }

    }).blur(function() {
        setTimeout(function() {
            $("#simlarDown").hide()

        },
        260);
        setTimeout(function() {
            $('#hotSearchKeywords').hide()

        },
        200);
        if ($(this).val() == "") {
            $(this).val("输入要搜索的内容");
            $(this).css("color", "#cccccc")

        }

    }).focus(function() {
        $("#m_keywords").css("color", "black");
        var html = $("#simlarDown").find('ul').html();
        if (html) {
            setTimeout(function() {
                if ($.trim($('#m_keywords').val()) != '') {
                    $("#simlarDown").show()

                }

            },
            100)

        }
        if ($(this).val() == "输入要搜索的内容") {
            $(this).val("");
            $(this).css("color", "#000")

        }

    }).bind('input propertychange', 
    function() {
        setHotSearchKeywords();
        setHotKeywords()

    }).click(function() {
        setTimeout(function() {
            setHotSearchKeywords();
            setHotKeywords()

        },
        100);
        if ($(this).val() == "输入要搜索的内容") {
            $(this).val("");
            $(this).css("color", "#000")

        }

    });
    setHotKeywords();
    $("#m_keywords").focus();
    setTimeout(function() {
        $("#m_keywords").val('输入要搜索的内容').css("color", "#cccccc")

    },
    100)

});
function nextAhover() {
    var isHas = $("#simlarDown .selected");
    if (isHas.length == 0) {
        var next = $("#simlarDown li:first")

    } else {
        var next = isHas.parent('li').next('li')

    }
    next.siblings().find('a').removeClass('selected');
    next.find('a').addClass('selected');
    var text = next.text();
    $("#m_keywords").val(text)

}
function prevAhover(keywords) {
    var isHas = $("#simlarDown .selected");
    if (isHas.length == 0) {
        var prev = $("#simlarDown li:last")

    } else {
        var prev = isHas.parent('li').prev('li')

    }
    prev.siblings().find('a').removeClass('selected');
    prev.find('a').addClass('selected');
    var text = prev.text();
    $("#m_keywords").val(text)

}
function setFocus() {
    var obj = event.srcElement ? event.srcElement: event.target;
    var txt = obj.createTextRange();
    txt.moveStart('character', obj.value.length);
    txt.collapse(true);
    txt.select()

}
function setHotSearchKeywords() {
    var mKeywords = $.trim($('#m_keywords').val());
    if (mKeywords == '') {
        $('#hotSearchKeywords').show();
        $('#simlarDown').hide()

    } else {
        $('#hotSearchKeywords').hide();
        $('#simlarDown').show()

    }

}
function setHotKeywords() {
    var hot_keywords = decodeURI(getCookie('hot_keywords'));
    var hotKeywords = hot_keywords.split('|');
    var html = '<dt><a href="javascript:void(0);" id="clearHotKeywords">清除</a>历史记录</dt>';
    for (var i = 0; i < hotKeywords.length; i++) {
        if (hotKeywords[i] != 'false') {
            html += '<dd><a href="' + TAOCZ_URL + '/search.html?keywords=' + hotKeywords[i] + '">' + hotKeywords[i] + '</a></dd>'

        }

    }
    $('#hot_left').html(html);
    setTimeout(function() {
        $('#clearHotKeywords').click(function() {
            clearHotKeywords()

        })

    },
    100)

}
function clearHotKeywords() {
    $.get(TAOCZ_URL + '/index.php?app=search.search&act=clear_hot_kewwords');
    $('#hot_left dd').remove()

};
$(document).ready(function() {
    window["_BFD"] = window["_BFD"] || {};
    _BFD.client_id = "Ctaochangzhou";
    _BFD.script = document.createElement("script");
    _BFD.script.type = "text/javascript";
    _BFD.script.async = true;
    _BFD.script.charset = "utf-8";
    _BFD.script.src = (('https:' == document.location.protocol ? 'https://ssl-static1': 'http://static1') + '.baifendian.com/service/taochangzhou/taochangzhou.js');
    document.getElementsByTagName("head")[0].appendChild(_BFD.script);
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-26085788-1']);
    _gaq.push(['_trackPageview']);
    var oBody = document.getElementsByTagName('HEAD').item(0);
    oBody.appendChild(cteate_scr_wdj('http://s21.cnzz.com/stat.php?id=3478115&amp;web_id=3478115', 'utf-8'))

});
function cteate_scr_wdj() {
    var src = arguments[0];
    var charset = arguments[1];
    var obj = document.createElement("script");
    obj.type = "text/javascript";
    obj.src = src;
    obj.charset = charset;
    return obj

};
$(document).ready(function() {
    $(".header_menu").live("mouseenter", 
    function() {
        $(this).addClass("hover")

    });
    $(".header_menu").live("mouseleave", 
    function() {
        $(this).removeClass("hover")

    });
    $(".cart2").live("mouseenter", 
    function() {
        $(".J_NavCart").css("display", "")

    });
    $(".cart").live("mouseenter", 
    function() {
        $(".J_NavCart").css("display", "")

    });
    $(".cart2").live("mouseleave", 
    function() {
        $(".J_NavCart").css("display", "none")

    });
    $(".cart").live("mouseleave", 
    function() {
        $(".J_NavCart").css("display", "none")

    });
    $(".android").live("mouseenter", 
    function() {
        $(".andr_con").css({
            "display": "",
            "z-index": "9999"

        })

    });
    $(".android").live("mouseleave", 
    function() {
        $(".andr_con").css("display", "none")

    });
    $(".app").live("mouseenter", 
    function() {
        $(".apple_con").css({
            "display": "",
            "z-index": "9999"

        })

    });
    $(".app").live("mouseleave", 
    function() {
        $(".apple_con").css("display", "none")

    });
    $(".weixin").live("mouseenter", 
    function() {
        $(".weix_con").css({
            "display": "",
            "z-index": "9999"

        })

    });
    $(".weixin").live("mouseleave", 
    function() {
        $(".weix_con").css("display", "none")

    });
    $(".s_type").click(function() {
        $(".s_type").removeClass("cur");
        $(this).addClass("cur");
        v = $(this).attr("v");
        $("[name=c]").val(v);
        pos = v - 1;
        $(".search-form").css("display", "none");
        $(".search-form:eq(" + pos + ")").css("display", "")

    });
    $(".ipt-menu-selected").mouseenter(function() {
        $(".s-menu-list").css("display", "")

    });
    $(".ipt-menu-selected").mouseleave(function() {
        $(".s-menu-list").css("display", "none")

    });
    $(".s-menu-list a").click(function() {
        v = $(this).attr("v");
        t = $(this).html();
        $(".s_title").html(t);
        $("[name=t]").val(v);
        $(".s-menu-list").css("display", "none")

    });
    $(".tuan_search_btn").click(function() {
        var action = "http://www.taocz.com/index.php?app=shop.tui&";
        var action2 = "";
        var keyword = $("#keyword").val();
        var cate = $("#t").val();
        if (keyword == "" || keyword == "输入要搜索的内容") {
            alert("请输入关键词");
            $("#keyword").focus();
            return false

        }
        switch (cate) {
            case "2":
            action2 = "/store.php?ctl=tuan&";
            break;
            case "3":
            action2 = "/store.php?ctl=takeaway&";
            break;
            case "4":
            action2 = "/store.php?";
            break;
            default:
            action2 = "/store.php?ctl=store&";
            break

        }
        window.location.href = action + "keywords=" + keyword

    });
    $(".search_fenlei").mouseenter(function() {
        $(this).find("ul").fadeIn()

    }).mouseleave(function() {
        $(this).find("ul").fadeOut()

    });
    $(".sclass").click(function() {
        $(".sleibie").html($(this).html());
        var val = $(this).attr("val");
        if (val == 1) {
            if ($(".suggest-content").length == 0) {
                $(this).parents(".s-menu1").after("<div class=\"suggest-content\" id='simlarDown'><ul></ul></div>")

            }
            $("#sapp").remove();
            $(this).parents("form").attr("action", "/search.html")

        } else {
            if ($("#sapp").length == 0) {
                $(this).parent("li").after("<input type=\"hidden\" id=\"sapp\" name=\"app\" value=\"shop.tui\">")

            }
            $(".suggest-content").remove();
            $(this).parents("form").attr("action", "http://www.taocz.com")

        }
        $(this).parent("li").parent("ul").fadeOut()

    });
    $("#header_cart").mouseenter(function() {
        $(this).children("dl").addClass("hover")

    }).mouseleave(function() {
        $(this).children("dl").removeClass("hover")

    });
    $(".header_search").mouseenter(function() {
        var obj = $(this);
        obj.find(".shelper").show();
        obj.find(".shelper").children("a").click(function() {
            $(".shelper").hide();
            obj.find("a:first").html($(this).html());
            var val = $(this).attr("val");
            if (val == 1) {
                $("#c").val(1);
                if ($("#m_keywords").val() == "" || $("#m_keywords").val() == "电影票") {
                    $("#m_keywords").val("饮料")

                }
                if ($(".header_search").parent().find(".suggest-content").length == 0) {
                    $(".header_search").parent().find(".s-menu1").after("<div class=\"suggest-content\" id='simlarDown'><ul></ul></div>")

                }

            } else {
                $("#c").val(2);
                if ($("#m_keywords").val() == "" || $("#m_keywords").val() == "饮料") {
                    $("#m_keywords").val("电影票")

                }
                $(".header_search").parent().find(".suggest-content").remove()

            }

        })

    }).mouseleave(function() {
        $(this).find(".shelper").hide()

    });
    $("#header_search_sub").click(function() {
        var keywords = $("#m_keywords").val();
        if (keywords == "" || keywords == "输入要搜索的内容") {
            alert("请输入您要搜索的内容");
            $("#m_keywords").focus();
            return false

        }
        if ($("#c").val() == 1) {
            window.location.href = TAOCZ_URL + "/search.html?keywords=" + keywords

        } else {
            window.location.href = "http://www.taocz.com/?app=shop.tui&keywords=" + keywords

        }

    })

});
$("#qq").live('click', 
function() {
    window.open(TAOCZ_URL + "/index.php?app=member.member&act=redirect_to_login", "_self", "QQ登录", "width=450,height=150,menubar=0,scrollbars=1,resizable=1,status=1,titlebar=0,toolbar=0,location=1")

});
$(document).ready(function() {
    $("#zxkf").mouseover(function() {
        $("#zxkf").css("background", "#676767")

    });
    $("#zxkf").mouseout(function() {
        $("#zxkf").css("background", "#ced3e2")

    });
    var class_name = $(".miniNav a").attr('class');
    $(".miniNav").toggle(function() {
        if ($.browser.msie && ($.browser.version == "6.0") && !$.support.style) {} else {
            document.getElementById("sideTools").style.top = "301px"

        }
        $(".stMore").css("display", "block");
        $(".stMore").attr("value", "q");
        $(".miniNav a").addClass("on")

    },
    function() {
        $(".stMore").css("display", "none");
        $(".stMore").attr("value", "")

    })

});
function addToFavorite() {
    var d = "http://www.taocz.com/";
    var c = "淘常州 - 网上常州城 - 便民生活、智慧常州！";
    if (document.all) {
        window.external.AddFavorite(d, c)

    } else {
        if (window.sidebar) {
            window.sidebar.addPanel(c, d, "")

        } else {
            alert("对不起，您的浏览器不支持此操作！                              请您使用菜单栏或Ctrl+D收藏本站。")

        }

    }
    createCookie("_fv", "1", 30, "/;domain=taocz.com")

}
function AutoScroll(obj) {
    $(obj).find("ul:first").animate({
        marginTop: "-22px"

    },
    500, 
    function() {
        $(this).css({
            marginTop: "0px"

        }).find("li:first").appendTo(this)

    })

}
$(document).ready(function() {
    var myar = setInterval('AutoScroll("#scrollDiv")', 3000);
    $("#scrollDiv").hover(function() {
        clearInterval(myar)

    },
    function() {
        myar = setInterval('AutoScroll("#scrollDiv")', 3000)

    })

});
(function($, window, document, undefined) {


    $.belowthefold = function(element, settings) {
        var fold;
        if (settings.container === undefined || settings.container === window) {
            fold = (window.innerHeight ? window.innerHeight: $window.height()) + $window.scrollTop()

        } else {
            fold = $(settings.container).offset().top + $(settings.container).height()

        }
        return fold <= $(element).offset().top - settings.threshold

    };
    $.rightoffold = function(element, settings) {
        var fold;
        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft()

        } else {
            fold = $(settings.container).offset().left + $(settings.container).width()

        }
        return fold <= $(element).offset().left - settings.threshold

    };
    $.abovethetop = function(element, settings) {
        var fold;
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop()

        } else {
            fold = $(settings.container).offset().top

        }
        return fold >= $(element).offset().top + settings.threshold + $(element).height()

    };
    $.leftofbegin = function(element, settings) {
        var fold;
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft()

        } else {
            fold = $(settings.container).offset().left

        }
        return fold >= $(element).offset().left + settings.threshold + $(element).width()

    };
    $.inviewport = function(element, settings) {
        return ! $.rightoffold(element, settings) && !$.leftofbegin(element, settings) && !$.belowthefold(element, settings) && !$.abovethetop(element, settings)

    };
    $.extend($.expr[":"], {
        "below-the-fold": function(a) {
            return $.belowthefold(a, {
                threshold: 0

            })

        },
        "above-the-top": function(a) {
            return ! $.belowthefold(a, {
                threshold: 0

            })

        },
        "right-of-screen": function(a) {
            return $.rightoffold(a, {
                threshold: 0

            })

        },
        "left-of-screen": function(a) {
            return ! $.rightoffold(a, {
                threshold: 0

            })

        },
        "in-viewport": function(a) {
            return $.inviewport(a, {
                threshold: 0

            })

        },
        "above-the-fold": function(a) {
            return ! $.belowthefold(a, {
                threshold: 0

            })

        },
        "right-of-fold": function(a) {
            return $.rightoffold(a, {
                threshold: 0

            })

        },
        "left-of-fold": function(a) {
            return ! $.rightoffold(a, {
                threshold: 0

            })

        }

    })

})(jQuery, window, document);