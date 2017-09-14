//预售规则
$(function() {
	$(".gui").mouseenter(function() {
		$("#dd").css("display", "block");
	});
	$(".gui").mouseleave(function() {
		$("#dd").css("display", "none");
	});
	$("#dd").mouseenter(function() {
		$(this).css("display", "block");
	});
	$("#dd").mouseleave(function() {
		$(this).css("display", "none")
	});
});

// 预售阶梯价格
// 页面刷新时 显示最初的值
function jietijiage() {
	$(".jieti-renshu:lt(3)").css("display", "block");
}
$(document).ready(function() {
	var jietishu1 = $(".st").prevAll().size()
	var jietishu = jietishu1 + 1; // 获取个数
	var jieti = $(".jieti-jiage .st").next(); // 获取下一个
	var jieti1 = $(".jieti-jiage .st").prev(); // 获取上一个
	// 判断选中人数的位置和显示
	if (jietishu % 3 == 1) {
		jieti.css("display", "block");
		jieti.next().css("display", "block");
		$(".st").css("display", "block");
	} else if (jietishu % 3 == 2) {
		jieti1.css("display", "block")
		$(".st").css("display", "block");
		$(".st").css("borderRight", "1px dashed #ccc");
		// $(".jieti-jiage .st").addClass("jieti-Rbian");
		jieti.css("display", "block");
	} else if (jietishu % 3 == 0) {
		jieti1.prev().css("display", "block");
		jieti1.css("display", "block");
		$(".st").css("display", "block");
	}
	// 页面每一行的第三个都不要右边框
	if (($(" .jieti-renshu").size()) < 3) {
		$(".jieti-renshu:eq(-1)").addClass("jieti-Rbian");
	} else {
		$(".jieti-renshu:eq(-1)").removeClass("jieti-Rbian");
	}
	// 当总数少于或等于3个的时候 点击按钮是不显示的
	if (($(".jieti-renshu").size()) <= 3) {
		$(".jieti-anniu").css("display", "none");
	}

})

// 当点击出现全部的值
$(function() {
	$(".jieti-anniu").click(function() {
		var renshu = $(".jieti-renshu");
		$(".jieti-xianshi").css("display", "block");
		$(".jieti-xianshi").css("z-index", "100");
		for (var i = 0; i < renshu.length; i++) {
			$(".jieti-xianshi").html(renshu);
			;
		}
		if (($(".jieti-xianshi .jieti-renshu").size()) < 3) {
			$(".jieti-xianshi .jieti-renshu").addClass("jieti-Rbian");
		}
		if (($(".jieti-xianshi .jieti-renshu").size()) % 3 != 0) {
			$(".jieti-xianshi .jieti-renshu").eq(-1).addClass("jieti-Rbian");
		}
		$(".jieti-xianshi .jieti-renshu").css("display", "block");
		$(".jieti-jiage").css("display", "block");
		$(".jieti-jiage").css("height", "81px");
	})
	// 鼠标移走显示最初的值
	$(".jieti-xianshi").mouseleave(function() {
		$(".jieti-xianshi").css("display", "none");
		var renshu = $(".jieti-renshu");
		var renshu1 = $(".jieti-renshu").eq(-1).html();
		$(".jieti-jiage ").html(renshu);
		$(".st").siblings().css("display", "none");
		var renshuhe1 = $(".st").prevAll().size()
		var renshuhe = renshuhe1 + 1;

		var renshu2 = $(".st").next();
		var renshu3 = renshu2.next();
		var renshu4 = $(".st").prev();
		var renshu5 = renshu4.prev();
		if (renshuhe % 3 == 1) {
			renshu2.css("display", "block");
			renshu3.css("display", "block");
		} else if (renshuhe % 3 == 2) {
			renshu4.css("display", "block");
			renshu2.css("display", "block");
			if ((renshu2.html()) == undefined) {
				$(".st ").after('<div class="jieti-renshu jieti-BBbian" style="display:block"></div>');
			}
		} else if (renshuhe % 3 == 0) {
			renshu5.css("display", "block");
			renshu4.css("display", "block");
		}

		$(".jieti-jiage .jieti-renshu").eq(2).removeClass("jieti-Rbian");
		$(".jieti-jiage ").css("borderBottom", "0px");
	})
	
	// 点击预售下拉箭头
	$(".jieti-anniu").mouseenter(function() {
		$(this).css("background", "#E31939");
	});
	$(".jieti-anniu").mouseleave(function() {
		$(this).css("background", "#FBFBFB");
	})
})
