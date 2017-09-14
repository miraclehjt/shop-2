var bizFilter = {
	bizCateHtml: [],
	bizAttHtml: [],
	req_url: "category.php",
	filterElemId: "filter_content",
	atts: [],
	currentAtts: [],
	params: [],
	canceled: !1,
	closeDivCount: 0,
	init: function() {
		this.bindToggle($("#" + this.filterElemId));
		this.initDom();
		this.initDivFixed();
	},
	initDivFixed: function() {
		var a = this,
			b = function() {
				"none" != $("._next").css("display") && $("div.filtrate_category").each(function() {
					"none" != $(this).next().css("display") && $(this).children("a").hasClass("filtrate_category_show") && a.divSticky($(this))
				})
			};
		$(document).bind("touchmove", b);
		$(window).scroll(b)
	},
	divSticky: function(a) {
		var b = $(window).scrollTop(),
			c = a.next(),
			e = parseInt(c.offset().top) - parseInt(a.height()),
			d = parseInt(c.height()) + parseInt(c.offset().top) - parseInt(a.height());
		b > e && b < d ? a.hasClass("fixed") || (a.attr("style", "").addClass("fixed"), c.css("margin-top", a.height()), a.css("top", "0")) : a.hasClass("fixed") && (a.removeClass("fixed"), c.css("margin-top", 0))
	},
	initDom: function() {
		var a = this.getQuerystringObj();
		this.req_url = 0 < window.location.href.indexOf("search.php") ? "search.php" : "category.php";
		"undefined" != typeof a.cid && "" != a.cid && (!1 !== a.cid.indexOf(".") && (a.cid = a.cid.replaceAll(".", "_")), $("a[cid=" + a.cid + "]", $("#filter_category_list")).addClass("on"));
		this.partShow()
	},
	partShow: function() {
		var a = $("#filter_category_list"),
			b = $("#filter_1_list"),
			c = $("#filter_region_list");
		a.show().find("li").slice(4).hide();
		0 == b.children("li.on").length && b.show().children("li").slice(12).hide();
		0 == c.children("li.on").length && c.show().children("li").slice(12).hide()
	},
	bindToggle: function(a) {
		var b = this;
		$(".filtrate_category,.filtrate_category_a", a).click(function() {
			$(this).hasClass("filtrate_category_show") ? ($(this).parent().removeClass("fixed"), $(this).parent().next(".filtrate_list").css("margin-top", "0").hide(), $(this).removeClass("filtrate_category_show"),$(this).children("span").html("展开")) : ($(this).parent().removeClass("fixed"), $(this).parent().next(".filtrate_list").show(), $(this).addClass("filtrate_category_show"), $(this).children("span").html("收起"), $(this).parent().next(".filtrate_list").find("li").show())
		})
	},
	getQuerystringObj: function() {
		var a = {},
			b = window.location.search.slice(1).split("&");
		for (i in b) {
			var c = b[i].split("=");
			a[decodeURIComponent(c[0])] = c[1]
		}
		return a
	}
};