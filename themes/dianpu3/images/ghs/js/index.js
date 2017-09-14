
void 0 === $.ui && ($.ui = {}), function(a, b) {
	function c(a) {
		return "[object Object]" === Object.prototype.toString.call(a)
	}

	function d(a) {
		try {
			a = "true" === a ? !0 : "false" === a ? !1 : "null" === a ? null : +a + "" === a ? +a : /(?:\{[\s\S]*\}|\[[\s\S]*\])$/.test(a) ? JSON.parse(a) : a
		} catch (c) {
			a = b
		}
		return a
	}

	function e(a) {
		for (var c, e, f = {}, g = a && a.attributes, h = g && g.length; h--;) e = g[h], c = e.name, "data-" === c.substring(0, 5) && (c = c.substring(5), e = d(e.value), e === b || (f[c] = e));
		return f
	}

	function f() {
		for (var b, d = [].slice.call(arguments), e = d.length; e--;) b = b || d[e], c(d[e]) || d.splice(e, 1);
		return d.length ? a.extend.apply(null, [!0,
		{}].concat(d)) : b
	}

	function g(b, c) {
		function d(c, g) {
			var h = this;
			h.el = a(c);
			var i = h.options = f(d.options, e(c), g);
			return h.name = b.toLowerCase(), a.ui.guid++, h.guid = a.ui.guid, h.init(i), /debug/.test(location.search) && console.log(h), h
		}
		for (var g = ["options"], h = 0; g.length > h; h++) {
			var i = g[h];
			c[i] && (d[i] = c[i]), delete c[i]
		}
		for (var h in c) d.prototype[h] = c[h];
		return d
	}
	a.ui.guid = 0, a.ui.fn = function(b) {
		var b = b.toLowerCase();
		a.fn[b] = function(c) {
			var d;
			return a.each(this, function(e, f) {
				d = new a.ui[b](f, c)
			}), d
		}
	}, a.ui.define = function(b, c) {
		a.ui[b] = g(b, c), a.ui.fn(b)
	}
}(jQuery), function(a) {
	if (void 0 === a.browser) {
		var b = navigator.userAgent.toLowerCase();
		a.browser = {
			version: (b.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
			safari: /webkit/.test(b),
			opera: /opera/.test(b),
			msie: /msie/.test(b) && !/opera/.test(b),
			mozilla: /mozilla/.test(b) && !/(compatible|webkit)/.test(b)
		}
	}
	a.browser.isIE6 = function() {
		return a.browser.msie && 6 == a.browser.version
	}, a.browser.isIE7 = function() {
		return a.browser.msie && 7 == a.browser.version
	}, a.browser.isIE8 = function() {
		return a.browser.msie && 8 == a.browser.version
	}, a.browser.isIE9 = function() {
		return a.browser.msie && 9 == a.browser.version
	}, a.browser.isIE10 = function() {
		return a.browser.msie && 10 == a.browser.version
	}, a.browser.isIE11 = function() {
		return a.browser.msie && 11 == a.browser.version
	}
}(jQuery), function(a) {
	a.page = function() {}, a.page.doc = function() {
		return "BackCompat" == document.compatMode ? document.body : document.documentElement
	}, a.page.clientWidth = function() {
		return a.page.doc().clientWidth
	}, a.page.clientHeight = function() {
		return a.page.doc().clientHeight
	}, a.page.docWidth = function() {
		return Math.max(a.page.doc().clientWidth, a.page.doc().scrollWidth)
	}, a.page.docHeight = function() {
		return Math.max(a.page.doc().clientHeight, a.page.doc().scrollHeight)
	}, void 0 === a.contains && (a.contains = function(a, b) {
		return a.compareDocumentPosition ? !! (16 & a.compareDocumentPosition(b)) : a !== b && a.contains(b)
	})
}(jQuery), function(a) {
	a.throttle = function(a, b) {
		var c, d, e, f, g = 0,
			h = function() {
				g = new Date, e = null, f = a.apply(c, d)
			};
		return function() {
			var i = new Date,
				j = b - (i - g);
			return c = this, d = arguments, 0 >= j ? (clearTimeout(e), e = null, g = i, f = a.apply(c, d)) : e || (e = setTimeout(h, j)), f
		}
	}
}(jQuery), function(a) {
	a.tpl = function(a, b) {
		var c = "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" + a.replace(/[\r\t\n]/g, " ").split("<%").join("   ").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("   ").join("');").split("%>").join("p.push('").split("\r").join("\\'") + "');}return p.join('');";
		return fn = Function("obj", c), b ? fn(b) : fn
	}
}(jQuery), !
function(a) {
	a.ui.define("switchable", {
		options: {
			type: "tab",
			direction: "left",
			tabSetup: !1,
			navClass: "ui-switchable-trigger",
			navItem: "ui-switchable-item",
			navSelectedClass: "ui-switchable-selected",
			navIframe: "data-iframe",
			mainClass: "ui-switchable-panel",
			mainSelectedClass: "ui-switchable-selected",
			page: !1,
			autoLock: !1,
			prevClass: "ui-switchable-prev",
			nextClass: "ui-switchable-next",
			pageCancel: "ui-switchable-cancel",
			hasArrow: !1,
			arrowClass: "ui-switchable-arrow",
			event: "mouseover",
			speed: 400,
			callback: null,
			delay: 150,
			defaultPanel: 0,
			autoPlay: !1,
			stayTime: 5e3
		},
		init: function() {
			var a = this;
			a.nav = a.el.find("." + a.options.navItem), a.main = a.el.find("." + a.options.mainClass), a.size = a.main.size();
			var b = this.options.defaultPanel;
			this.last = b, this.current = b, this.isInit = !0, this.switchTo(b), a.autoInterval = null, a.eventTimer = null, a.page(), a.autoPlay(), this.bind()
		},
		bind: function() {
			var b = this;
			b.nav.each(function(c) {
				a(this).bind(b.options.event, function() {
					clearTimeout(b.eventTimer), clearInterval(b.autoInterval), b.eventTimer = setTimeout(function() {
						b.current = c, b.switchTo(c)
					}, b.options.delay)
				}).bind("mouseleave", function() {
					b.autoPlay(), clearTimeout(b.eventTimer)
				}), "click" == b.options.event && a(this).bind("mouseover", function() {
					clearTimeout(b.eventTimer), clearInterval(b.autoInterval)
				})
			})
		},
		switchTo: function(a) {
			var b = this.options;
			this.iframe(a), this.nav.removeClass(b.navSelectedClass), this.nav.eq(a).addClass(b.navSelectedClass), this.main.removeClass(b.mainSelectedClass), this.main.eq(a).addClass(b.mainSelectedClass), (this.isInit || this.last != a) && (this.switchType(a), null != b.callback && b.callback.call(this, a, this.nav.eq(a)), this.last = a)
		},
		switchType: function(a) {
			var b = this.options;
			switch (b.type) {
			case "tab":
				this.tab(a);
				break;
			case "focus":
				this.focus(a);
				break;
			case "slider":
				this.slider(a);
				break;
			case "carousel":
				this.carousel(a)
			}
		},
		switchDefault: function(a) {
			this.main.hide(), this.main.eq(a).show()
		},
		tab: function(a) {
			if (this.options.tabSetup || this.switchDefault(a), this.options.hasArrow) {
				var b = this.options.arrowClass,
					c = (this.nav.eq(a).outerWidth() + 20) * a;
				if (this.isInit) {
					var d = this.nav.parent();
					d.prepend('<div class="' + b + '"><b></b></div>').css({
						position: "relative"
					}), this.el.find("." + b).css({
						left: c
					})
				} else this.el.find("." + b).stop(!0).animate({
					left: c
				}, this.options.speed)
			}
			this.isInit = !1
		},
		focus: function(b) {
			this.isInit ? (this.main.parent().css({
				position: "relative"
			}), this.main.css({
				position: "absolute",
				zIndex: 0,
				opacity: 0
			}).show(), this.main.eq(b).css({
				zIndex: 1,
				opacity: 1
			})) : this.main.eq(this.last).css({
				zIndex: 0
			}).stop(!0).animate({
				opacity: 1
			}, this.options.speed, function() {
				a(this).css("opacity", 0)
			}), this.main.eq(b).css({
				zIndex: 1
			}).stop(!0).animate({
				opacity: 1
			}, this.options.speed), this.isInit = !1
		},
		slider: function(a) {
			var b = this.options,
				c = this.main.parent(),
				d = this.main.outerHeight() * a,
				e = this.main.outerWidth() * a;
			this.isInit ? ("left" == b.direction ? (this.main.css({
				"float": "left"
			}), c.css({
				width: this.el.outerWidth() * this.size
			}), c.css({
				left: -e
			})) : "top" == b.direction && c.css({
				top: -d
			}), this.switchDefault(a), this.isInit = !1) : ("left" == b.direction ? c.stop(!0).animate({
				left: -e
			}, this.options.speed) : "top" == b.direction && c.stop(!0).animate({
				top: -d
			}, this.options.speed), this.main.show())
		},
		carousel: function(a) {
			this.slider(a)
		},
		page: function() {
			var b = this;
			if (b.options.page) {
				var c = this.el.find("." + this.options.nextClass),
					d = this.el.find("." + this.options.prevClass),
					e = this.options.pageCancel;
				d.bind("click", function() {
					b.options.autoLock && (c.removeClass(e), 1 == b.current && a(this).addClass(e), 0 == b.current) || b.prev()
				}), c.bind("click", function() {
					b.options.autoLock && (d.removeClass(e), b.current == b.size - 2 && a(this).addClass(e), b.current == b.size - 1) || b.next()
				}), 0 == b.current && b.options.autoLock && d.addClass(e)
			}
		},
		next: function() {
			this.current = this.current + 1, this.current >= this.size && (this.current = 0), this.switchTo(this.current)
		},
		prev: function() {
			this.current = this.current - 1, this.current < 0 && (this.current = this.size - 1), this.switchTo(this.current)
		},
		autoPlay: function() {
			var a = this;
			this.options.autoPlay && (a.autoInterval = setInterval(function() {
				a.next()
			}, a.options.stayTime))
		},
		iframe: function(a) {
			var b = this,
				c = b.main.eq(a),
				d = b.nav.eq(a),
				e = d.attr(b.options.navIframe);
			if (e) {
				var f = document.createElement("iframe");
				f.src = e, c.html(f), d.removeAttr(b.options.navIframe)
			}
		}
	})
}(jQuery), !
function(a) {
	a.ui.define("lazyload", {
		options: {
			type: "file",
			source: "data-lazy-path",
			init: "data-lazy-init",
			delay: 100,
			space: 300,
			placeholder: "http://misc.360buyimg.com/lib/skin/e/i/loading-jd.gif"
		},
		init: function() {
			function b() {
				var b = "div";
				"img" == d.type && (b = "IMG");
				var f = a(b, c.el);
				a.each(f, function() {
					var b = a(this),
						f = b.attr(d.source);
					if (f) {
						var g = a.page.clientHeight() + a(document).scrollTop() + d.space,
							h = b.offset().top,
							i = b.attr(d.init);
						if ("img" == d.type && (i = b.attr(d.source)), c.isImg) {
							var j = b.attr("src");
							j || b.attr("src", d.placeholder)
						}
						if (e = "done" == i, g > h && !e) if (c.isImg) b.attr("src", i), b.attr(d.source, "done");
						else try {
							seajs.use(f, function(a) {
								a.init(i), b.attr(d.init, "done")
							})
						} catch (k) {} else if (e) return
					}
				}), e && a(window).unbind("scroll", g)
			}
			var c = this,
				d = this.options,
				e = !1;
			c.isImg = !1, "img" == d.type && (c.isImg = !0), c.isImg && "data-lazy-path" == d.source && (d.source = "data-lazy-img"), b();
			var f = function() {
					b()
				},
				g = a.throttle(f, d.delay);
			a(window).bind("scroll", g)
		}
	})
}(jQuery), jQuery.extend(jQuery.easing, {
	def: "easeOutQuad",
	easeInQuint: function(a, b, c, d, e) {
		return d * (b /= e) * b * b * b * b + c
	},
	easeOutQuint: function(a, b, c, d, e) {
		return d * ((b = b / e - 1) * b * b * b * b + 1) + c
	},
	easeInOutQuint: function(a, b, c, d, e) {
		return (b /= e / 2) < 1 ? d / 2 * b * b * b * b * b + c : d / 2 * ((b -= 2) * b * b * b * b + 2) + c
	},
	easeOutElastic: function(a, b, c, d, e) {
		var f = 1.70158,
			g = 0,
			h = d;
		if (0 == b) return c;
		if (1 == (b /= e)) return c + d;
		if (g || (g = .3 * e), h < Math.abs(d)) {
			h = d;
			var f = g / 4
		} else var f = g / (2 * Math.PI) * Math.asin(d / h);
		return h * Math.pow(2, -10 * b) * Math.sin(2 * (b * e - f) * Math.PI / g) + d + c
	},
	easeInOutElastic: function(a, b, c, d, e) {
		var f = 1.70158,
			g = 0,
			h = d;
		if (0 == b) return c;
		if (2 == (b /= e / 2)) return c + d;
		if (g || (g = .3 * e * 1.5), h < Math.abs(d)) {
			h = d;
			var f = g / 4
		} else var f = g / (2 * Math.PI) * Math.asin(d / h);
		return 1 > b ? -.5 * h * Math.pow(2, 10 * (b -= 1)) * Math.sin(2 * (b * e - f) * Math.PI / g) + c : h * Math.pow(2, -10 * (b -= 1)) * Math.sin(2 * (b * e - f) * Math.PI / g) * .5 + d + c
	},
	easeInCirc: function(a, b, c, d, e) {
		return -d * (Math.sqrt(1 - (b /= e) * b) - 1) + c
	},
	easeOutCirc: function(a, b, c, d, e) {
		return d * Math.sqrt(1 - (b = b / e - 1) * b) + c
	},
	easeInOutCirc: function(a, b, c, d, e) {
		return (b /= e / 2) < 1 ? -d / 2 * (Math.sqrt(1 - b * b) - 1) + c : d / 2 * (Math.sqrt(1 - (b -= 2) * b) + 1) + c
	}
});
var Countdown = {
	init: function(a, b) {
		return 0 > a ? !1 : (this.seconds = parseInt(a, 10), this.timer = null, this.callback = b ||
		function() {}, void this.loopCount())
	},
	loopCount: function() {
		var a = this;
		this.timer = setInterval(function() {
			var b = a.formatSeconds(a.seconds);
			return a.callback(b), a.seconds <= 0 ? void clearInterval(a.timer) : void a.seconds--
		}, 1e3)
	},
	formatSeconds: function(a) {
		var b = Math.floor(a / 86400),
			c = Math.floor(a % 86400 / 3600),
			d = Math.floor(a % 86400 % 3600 / 60),
			a = a % 86400 % 3600 % 60;
		return {
			d: b,
			h: c,
			m: d,
			s: a
		}
	}
},
	smarketCallback = {};
smarketCallback.smSlider = function() {}, smarketCallback.timeLine = function() {}, smarketCallback.seckilling = function() {}, smarketCallback.freezer = function() {}, smarketCallback.snacks = function() {}, smarketCallback.snacksSublist = function() {}, smarketCallback.freshExpress = function() {}, smarketCallback.cookingGeologyLeft = function() {}, smarketCallback.cookingGeologyRight = function() {}, smarketCallback.floor1 = function() {}, smarketCallback.floor2 = function() {}, smarketCallback.floor3 = function() {}, smarketCallback.floor4 = function() {};
var smarketUI = {};
smarketUI.init = function() {
	if ($(window).unbind("scroll"), $("img[data-lazyload]").each(function() {
		$(this).attr("data-lazy-img", $(this).attr("data-lazyload")), $(this).removeAttr("data-lazyload")
	}), window.pageConfig) {
		var a = new pageConfig.FN_InitSidebar;
		a.setTop(), a.scroll()
	}
	$("body").lazyload({
		type: "img",
		placeholder: "http://misc.360buyimg.com/lib/img/e/blank.gif",
		delay: 150,
		space: 200
	}), this.smSlider(), this.smCategorys(), this.timeLine(), this.freezer(), this.snacks(), this.freshExpress(), this.cookingGeology(), this.floors(), this.floor1(), this.floor2(), this.floor3(), this.floor4(), this.cartCount = 0
}, smarketUI.triggerLazyimg = function(a) {
	var b = a.find("img[trigger-lazy-img]");
	b.length && b.each(function() {
		$(this).attr("src", $(this).attr("trigger-lazy-img")).removeAttr("trigger-lazy-img")
	})
}, smarketUI.smSlider = function() {
	var a = this;
	$("#smSlider .sm-s-wrap .item").each(function(a) {
		var b = $('<a class="ui-slider-trigger" href="javascript:void(0)"></a>');
		0 === a && b.addClass("curr"), $(".sm-s-trigger").append(b)
	}), $("#smSlider").switchable({
		type: "focus",
		navItem: "ui-slider-trigger",
		navSelectedClass: "curr",
		mainClass: "ui-slider-item",
		mainSelectedClass: "selected",
		delay: 300,
		speed: 500,
		autoPlay: !0,
		callback: function(b) {
			var c = this.main.eq(b),
				d = c.siblings(".item"),
				e = c.find(".site-1"),
				f = c.find(".site-2"),
				g = 600,
				h = {
					img1: {
						left: "38px",
						top: "10px"
					},
					img2: {
						right: "-150px",
						top: "20px"
					}
				},
				i = {
					img1: {
						left: "38px",
						top: "10px"
					},
					img2: {
						right: "24px",
						top: "20px"
					}
				};
			a.triggerLazyimg(c), e.stop(!0).animate({
				top: i.img1.top,
				opacity: 1
			}, g), f.stop(!0).animate({
				right: i.img2.right,
				opacity: 1
			}, g, "easeInOutElastic", function() {
				d.find(".site-1").css({
					top: h.img1.top,
					opacity: 0
				}), d.find(".site-2").css({
					right: h.img2.right,
					opacity: 0
				})
			})
		}
	})
}, smarketUI.smCategorys = function() {
	var a = this,
		b = $("#smCategorys .sm-c-wrap"),
		c = $("#smCategorys .menu .item"),
		d = $("#smCategorys .sub-menu"),
		e = $("#smCategorys .sub-menu .item");
	b.bind("mouseenter", function() {
		d.css("display", "block")
	}).bind("mouseleave", function() {
		d.css("display", "none"), c.removeClass("curr")
	}), c.bind("mouseenter", function() {
		var b = $(this).index(),
			f = c.length - 1;
		if (a.triggerLazyimg(e.eq(b)), $(this).addClass("curr").siblings(".item").removeClass("curr"), e.eq(b).css("display", "block").siblings(".item").css("display", "none"), !pageConfig.wideVersion || !pageConfig.compatible) {
			var g = $(this).position().left;
			b === f && (g = 594), d.stop(!0).animate({
				left: g
			}, 250)
		}
	})
}, smarketUI.timeLine = function() {
	$("#timeLine").switchable({
		type: "focus",
		navItem: "ui-switchable-item",
		navSelectedClass: "curr",
		mainSelectedClass: "selected",
		delay: 300,
		speed: 300,
		callback: function(a) {
			var b = $("#timeLine").find(".tl-tab-item").find("a").eq(a),
				c = $("#timeLine").find(".circle"),
				d = b.position().left;
			c.stop(!0).animate({
				left: d + 28
			}, 450, "easeInOutQuint", function() {}), smarketCallback.timeLine(a, this.main.eq(a))
		}
	}), $("#timeLine").find(".item").find("li").live("mouseenter", function() {
		$(this).addClass("hover")
	}).live("mouseleave", function() {
		$(this).removeClass("hover")
	})
}, smarketUI.seckilling = function() {
	$("#seckilling").switchable({
		type: "focus",
		event: "mouseenter",
		navItem: "ui-switchable-item",
		navSelectedClass: "curr",
		mainSelectedClass: "selected",
		delay: 300,
		speed: 300,
		defaultPanel: !1,
		callback: function(a) {
			var b = $("#seckilling").find(".sk-tab-item").find("a").eq(a),
				c = $("#seckilling").find(".sk-clock"),
				d = b.position().left;
			c.stop(!0).animate({
				left: d + 46
			}, 600, "easeInOutQuint", function() {}), smarketCallback.seckilling(a, this.main.eq(a))
		}
	}), this.setSeckillingCountdown(sysDate)
}, smarketUI.setSeckilling = function(a) {
	var b = $("#seckilling").find(".sk-tab-item").find("a").eq(a),
		c = $("#seckilling").find(".sk-clock"),
		d = b.position().left,
		e = "morning",
		f = $("#seckilling").find(".sk-item").eq(a);
	1 === a ? e = "noon" : 2 === a && (e = "night"), b.addClass("curr").siblings().removeClass("curr"), f.addClass("selected").siblings().removeClass("selected"), f.css({
		"z-index": "1",
		opacity: 0
	}).animate({
		opacity: 1
	}, 400, function() {
		$(this).siblings().css("opacity", 0)
	}), c.addClass(e).stop(!0).animate({
		left: d + 46
	}, 600, "easeInOutQuint"), smarketCallback.seckilling(a, f), this.setSeckillingCountdown(sysDate)
}, smarketUI.setSeckillingCountdown = function(a) {
	var b = function(a, b) {
			return (a / Math.pow(10, b)).toFixed(b).substr(2)
		},
		c = this.getSeckillingStage(a),
		d = c.distance / 1e3;
	void 0 !== Countdown.timer && clearInterval(Countdown.timer), 0 !== d ? Countdown.init(d, function(a) {
		a.h = b(a.h, 2), a.m = b(a.m, 2), a.s = b(a.s, 2), $(".sk-t-clock").html("<span>" + a.h + "</span><i>:</i><span>" + a.m + "</span><i>:</i><span>" + a.s + "</span>"), 0 === a.d && "00" === a.h && "00" === a.m && "00" === a.s && ($(".sk-tab-item").find(".curr").removeClass("killing"), $(".sk-con").find(".selected").find(".btn-m").addClass("disabled").attr("href", "#none"))
	}) : c.isOpen && $(".sk-t-clock").html("<span>00</span><i>:</i><span>00</span><i>:</i><span>00</span>")
}, smarketUI.getSeckillingStage = function(a) {
	var b = new Date(a),
		c = function(b, c, d) {
			var e = new Date(a);
			return e.setHours(b, 0, 0, 0), e
		},
		d = {
			hour6: function() {
				return c(6)
			},
			hour10: function() {
				return c(10)
			},
			hour12: function() {
				return c(12)
			},
			hour14: function() {
				return c(14)
			},
			hour18: function() {
				return c(18)
			},
			hour20: function() {
				return c(20)
			},
			hour24: function() {
				return c(23, 59, 59)
			}
		},
		e = 0,
		f = 0,
		g = 0,
		h = !1;
	return b < d.hour6() ? (e = 3, f = 1, h = !0, g = d.hour6() - b) : d.hour6() <= b && b < d.hour12() ? (e = 1, f = 2, h = !0, g = d.hour12() - b) : d.hour12() <= b && b < d.hour18() ? (e = 2, f = 3, h = !0, g = d.hour18() - b) : d.hour18() <= b && (e = 3, f = 1, h = !0, g = d.hour24() - b + 252e5), {
		stage: e,
		nextStage: f,
		distance: g,
		isOpen: h
	}
}, smarketUI.freezer = function() {
	$("#freezer").switchable({
		type: "tab",
		event: "click",
		navItem: "filter-item",
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		delay: 0,
		callback: function(a) {
			smarketCallback.freezer(a, this.main.eq(a))
		}
	}), $("#freezer .drink-list li").live("mouseenter", function() {
		$(this).addClass("curr");
		var a = $(this).find(".d-l-cart");
		a.stop(!0).css("visibility", "visible").animate({
			opacity: 1,
			top: "-74px"
		}, 400, "easeOutCirc")
	}).live("mouseleave", function() {
		$(this).removeClass("curr");
		var a = $(this).find(".d-l-cart");
		a.stop(!0).animate({
			opacity: 0,
			top: "-86px"
		}, 100, "easeOutCirc", function() {
			$(this).css("visibility", "hidden")
		})
	})
}, smarketUI.snacks = function() {
	var a = this;
	a.snacks.currIndex = 0, $("#snacks").switchable({
		type: "focus",
		event: "click",
		navItem: "filter-item",
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		delay: 0,
		speed: 200,
		callback: function(b) {
			a.snacks.currIndex = b, smarketCallback.snacks(b, this.main.eq(b))
		}
	}), $("#snacks").find(".item").switchable({
		type: "tab",
		event: "click",
		navItem: "sub-tab",
		navSelectedClass: "selected",
		mainClass: "sub-item",
		mainSelectedClass: "selected",
		tabSetup: !1,
		delay: 0,
		callback: function(b) {
			smarketCallback.snacksSublist(b, a.snacks.currIndex, this.main.eq(b))
		}
	}), $("#snacks").find(".sub-con").find("li").live("mouseenter", function() {
		$(this).addClass("hover")
	}).live("mouseleave", function() {
		$(this).removeClass("hover")
	})
}, smarketUI.freshExpress = function() {
	var a = this;
	$("#freshExpress").switchable({
		type: "focus",
		event: "click",
		navItem: "filter-item",
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		delay: 0,
		speed: 200,
		callback: function(b) {
			a.triggerLazyimg(this.main.eq(b)), smarketCallback.freshExpress(b, this.main.eq(b))
		}
	}), $("#freshExpress").find(".fe-list").find("li").live("mouseenter", function() {
		$(this).addClass("hover")
	}).live("mouseleave", function() {
		$(this).removeClass("hover")
	})
}, smarketUI.cookingGeology = function() {
	var a = $("#cookingGeologyLeft"),
		b = $("#cookingGeologyRight");
	a.switchable({
		type: "focus",
		navItem: "ui-switchable-item",
		navSelectedClass: "curr",
		mainSelectedClass: "selected",
		delay: 300,
		speed: 300,
		callback: function(a) {
			var b = $("#cookingGeologyLeft").find(".cg-w-t-item").find("a").eq(a),
				c = $("#cookingGeologyLeft").find(".cg-w-t-label"),
				d = b.position().left,
				e = b.position().top;
			c.stop(!0).animate({
				left: d - 7,
				top: e - 50
			}, 600, "easeInOutQuint", function() {}), smarketCallback.cookingGeologyLeft(a, this.main.eq(a))
		}
	}), b.switchable({
		type: "focus",
		navItem: "ui-switchable-item",
		navSelectedClass: "curr",
		mainSelectedClass: "selected",
		delay: 300,
		speed: 300,
		callback: function(a) {
			var b = $("#cookingGeologyRight").find(".cg-w-t-item").find("a").eq(a),
				c = $("#cookingGeologyRight").find(".cg-w-t-label"),
				d = b.position().left,
				e = b.position().top;
			c.stop(!0).animate({
				left: d - 14,
				top: e - 50
			}, 600, "easeInOutQuint", function() {}), smarketCallback.cookingGeologyRight(a, this.main.eq(a))
		}
	});
	var c = $("#cookingGeology .cg-trigger .cg-t-scissor"),
		d = $("#cookingGeology .cg-trigger .cg-t-title"),
		e = $("#cookingGeology .cg-mask");
	$("#cookingGeology .cg-trigger").bind("click", function() {
		var f = "-200px";
		c.hasClass("animating") || (d.fadeOut(400), c.addClass("animating").animate({
			top: "500px"
		}, 1200, "easeInOutQuint", function() {
			e.fadeIn(800, "easeInOutQuint"), a.animate({
				left: f
			}, 800, "easeInOutQuint"), b.animate({
				right: f
			}, 800, "easeInOutQuint"), $(this).fadeOut(0).removeClass("animating")
		}))
	}), $("#cookingGeology .cg-h-close").bind("click", function() {
		var f = "0px";
		d.fadeIn(400), c.css("top", "20px").fadeIn(400), e.fadeOut(800, "easeInOutQuint"), a.animate({
			left: f
		}, 800, "easeInOutQuint"), b.animate({
			right: f
		}, 800, "easeInOutQuint")
	})
}, smarketUI.floors = function() {
	$(".sm-floor").find(".item-r").find("li").live("mouseenter", function() {
		$(this).addClass("hover")
	}).live("mouseleave", function() {
		$(this).removeClass("hover")
	})
}, smarketUI.floor1 = function() {
	$("#smFloor1").switchable({
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		tabSetup: !0,
		delay: 100,
		callback: function(a) {
			smarketCallback.floor1(a, this.main.eq(a))
		}
	})
}, smarketUI.floor2 = function() {
	$("#smFloor2").switchable({
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		tabSetup: !0,
		callback: function(a) {
			smarketCallback.floor2(a, this.main.eq(a))
		}
	})
}, smarketUI.floor3 = function() {
	$("#smFloor3").switchable({
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		tabSetup: !0,
		callback: function(a) {
			smarketCallback.floor3(a, this.main.eq(a))
		}
	})
}, smarketUI.floor4 = function() {
	$("#smFloor4").switchable({
		navSelectedClass: "selected",
		mainSelectedClass: "selected",
		tabSetup: !0,
		callback: function(a) {
			smarketCallback.floor4(a, this.main.eq(a))
		}
	})
}, smarketUI.init();
var CartRecommend = {
	init: function(a, b, c, d) {
		this.sku = a, this.rid = b, this.locId = c, this.pin = readCookie("pin"), this.pid = null === c ? 1 : c.split("-")[0], this.el = d;
		var e = readCookie("__jda");
		this.uuid = e ? "-" == e.split(".")[1] ? -1 : e.split(".")[1] : -1, this.get()
	},
	get: function() {
		var a = this,
			b = {
				p: this.rid,
				sku: this.sku,
				ck: "ipLocation",
				lid: this.pid,
				lim: 4,
				uuid: this.uuid,
				ec: "gbk"
			};
		this.pin && (b.pin = this.pin), $.ajax({
			url: "http://diviner.jd.com/diviner",
			data: b,
			dataType: "jsonp",
			jsonpCallback: "call" + parseInt(1e5 * Math.random(), 10),
			success: function(b) {
				a.set(b)
			}
		})
	},
	set: function(a) {
		this.skus = [];
		var b = '<ul class="lh">    {for item in data}    {if Number(item.jp)>=0}    <li data-push="${CartRecommend.skus.push(item.sku)}" class="fore1" data-clk="${item.clk}">        <div class="p-img"><a target="_blank" href="http://item.jd.com/${item.sku}.html"><img height="100" width="100" alt="${item.t}" data-img="1" src="${pageConfig.FN_GetImageDomain(item.sku)}n4/${item.img}"></a></div>        <div class="p-name"><a target="_blank" href="http://item.jd.com/${item.sku}.html"" title="${item.t}">${item.t}</a></div>        <div class="p-price"><strong class="J-p-${item.sku}">\uffe5${item.jp}</strong></div>    </li>    {/if}    {/for}</ul>';
		a.success && a.data.length > 0 ? (this.el.html(b.process(a)).parent().show(), this.setTrackCode(a.impr), this.getPriceNum(this.skus, readCookie("ipLoc-djd"), this.el)) : this.el.html('<div class="ac">\u6682\u65e0\u63a8\u8350\u5546\u54c1</div>')
	},
	getPriceNum: function(a, b, c, d, e) {
		a = "string" == typeof a ? [a] : a, c = c || $("body"), d = d || "J-p-";
		var f = "";
		if (null !== b && (f = readCookie("ipLoc-djd") ? "&area=" + readCookie("ipLoc-djd").replace(/-/g, "_") : "&area=1"), "undefined" != typeof a) {
			var g = "http://p.3.cn/prices/mgets?type=1&skuIds=J_" + a.join(",J_") + f;
			$.ajax({
				url: g,
				dataType: "jsonp",
				success: function(a) {
					if (!a && !a.length) return !1;
					for (var b = 0; b < a.length; b++) {
						if (!a[b].id) return !1; {
							var f = a[b].id.replace("J_", ""),
								h = parseFloat(a[b].p);
							parseFloat(a[b].m)
						}
						c.find("." + d + f).html(h > 0 ? "\uffe5" + a[b].p : "\u6682\u65e0\u62a5\u4ef7"), "function" == typeof e && e(f, a[b], g)
					}
				}
			})
		}
	},
	setTrackCode: function(a) {
		var b = this.el.find("li"),
			c = this,
			d = "&m=UA-J2011-1&ref=" + encodeURIComponent(document.referrer);
		b.each(function() {
			var a = $(this).attr("data-clk");
			$(this).bind("click", function(b) {
				var e = (b.srcElement || b.target).tagName.toUpperCase();
				("A" === e || "IMG" === e || "SPAN" === e) && c.newImage(a + d, !0)
			})
		}), this.newImage(a + d)
	},
	newImage: function(a, b) {
		var c = new Image;
		a = b ? a + "&random=" + Math.random() + new Date : a, c.setAttribute("src", a)
	}
},
	smAddToCart = {};
smAddToCart.cartAmount = 0, smAddToCart.addVersion = 0, smAddToCart.add = function(a, b, c, d) {
	0 != b && (this.ele = a, this.sku = b, this.ptype = d || 1, this.pcount = c || 1, 0 === this.addVersion && (this.addVersion = this.getAbTest()), 1 === this.addVersion ? this.versonModal() : 2 === this.addVersion && this.versonAnimate())
}, smAddToCart.getAbTest = function() {
	var a = readCookie("__jda"),
		b = a ? a.split(".")[1] : !1,
		c = 2;
	return b && (hashResult = pageConfig.getHashProbability(b, 1e4), 5e3 > hashResult ? c = 1 : hashResult >= 5e3 && (c = 2)), c
}, smAddToCart.addToCart = function() {
	var a = "http://cart.jd.com/cart/dynamic/gate.action?pid={PID}&pcount={PCOUNT}&ptype={PTYPE}";
	a = a.replace("{PID}", this.sku).replace("{PCOUNT}", this.pcount).replace("{PTYPE}", this.ptype), $.ajax({
		url: a,
		dataType: "jsonp"
	})
}, smAddToCart.versionModalTpl = '<div class="m tip-success" id="add-to-cart"><div class="mt fl icon"></div><div class="mc lh"><div class="c-title"><strong>\u6dfb\u52a0\u6210\u529f</strong></div><div class="c-btn"><a class="c-checkout" href="http://cart.jd.com/cart/cart.html?backurl=http://item.jd.com/{SKU}.html&rid={RANDOM}" target="_blank">\u53bb\u8d2d\u7269\u8f66\u7ed3\u7b97</a><a class="c-return" href="#none" onclick="jdThickBoxclose()">\u7ee7\u7eed\u8d2d\u7269</a></div></div></div><div class="m" id="cart-reco"><div class="mt">\u8d2d\u4e70\u8be5\u5546\u54c1\u7684\u7528\u6237\u8fd8\u8d2d\u4e70\u4e86\uff1a</div><div class="mc loading-style2"></div></div>', smAddToCart.versonModal = function() {
	var a = this;
	this.addToCart(), $.jdThickBox({
		title: "\u52a0\u5165\u8d2d\u7269\u8f66",
		width: 472,
		height: 330,
		_div: "add_to_cart_div",
		source: a.versionModalTpl.replace("{SKU}", a.sku).replace("{RANDOM}", Math.random())
	}, function() {
		var b = ($("#add-to-cart"), $("#cart-reco"));
		b.find(".mc").removeClass("loading-style2"), "undefined" != typeof CartRecommend && setTimeout(function() {
			CartRecommend.init(a.sku, 303001, readCookie("ipLoc-djd"), $("#cart-reco .mc"))
		}, 10)
	})
}, smAddToCart.versonAnimate = function() {
	var a = this;
	this.timer = null, clearTimeout(a.timer), this.addToCart();
	var b = $(this.ele).parents("li").find(".pimg" + this.sku);
	0 === b.length && $(this.ele).parents("#freezer").length > 0 && (b = $(this.ele).parents("li").find("img"));
	var c = b.height(),
		d = b.width(),
		e = b.offset().left,
		f = b.offset().top,
		g = $(document).scrollTop(),
		h = $("#settleup-2013").offset().left + 50,
		i = g - 100,
		j = $('<div class="flyGoods" style="position:absolute;z-index: 10;"></div>'),
		k = $('<div class="cart-result">    <i></i>    <em><a target="_blank" href="http://cart.jd.com/cart/cart.html?backurl=http://channel.jd.com/chaoshi.html&rid=' + parseInt(1e5 * Math.random(), 10) + '">\u5546\u54c1\u5df2\u7ecf\u52a0\u5165\u8d2d\u7269\u8f66</a></em>    <b class="close"></b></div>'),
		l = b.parents("#freezer").length ? 10 : 25;
	j.html(b.clone().removeAttr("id")).css({
		left: e + d / 2 - l + Math.round(40 * Math.random() + 0 - 20),
		top: f
	}), j.find("img").css({
		width: "auto",
		height: "50px"
	}), $("body").append(j), j.animate({
		top: f - c / 2
	}, 500, "easeOutCirc", function() {
		j.animate({
			left: h,
			top: i,
			opacity: .1
		}, 500, "easeInOutQuint", function() {
			j.remove(), 0 === $(".cart-result").length && ($("body").append(k), $.browser.msie && parseInt($.browser.version, 10) <= 6 ? k.css({
				left: h - 100,
				opacity: 1
			}) : k.css({
				left: h - 100
			}).animate({
				top: 15,
				opacity: 1
			}, 400, "easeOutCirc"), k.find(".close").bind("click", function() {
				k.animate({
					top: -10,
					opacity: 0
				}, 400, "easeOutCirc", function() {
					k.remove()
				})
			})), a.timer = setTimeout(function() {
				k.animate({
					top: -10,
					opacity: 0
				}, 400, "easeOutCirc", function() {
					k.remove()
				})
			}, 4e3)
		})
	})
}, smarketCallback.timeLine = function(a, b) {
	if (0 != a && 0 == b.find("ul").find("li").length && (a++, themeListJson && themeListJson["themeList" + a])) {
		var c = themeListJson["themeList" + a];
		b.find("ul").html(chuanYueShiKongHtml.process({
			data: c
		})), getFloorPrice(c), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.freezer = function(a, b) {
	if (0 != a && 0 == b.find("li").length && (a += 5, themeListJson && themeListJson["themeList" + a])) {
		for (var c = themeListJson["themeList" + a], d = [], e = 0, f = c.length; f > e; e++) c[e].remark ? (c[e].num = c[e].remark.split("-")[0] ? c[e].remark.split("-")[0] : 0, c[e].skuId2 = c[e].remark.split("-")[1] ? c[e].remark.split("-")[1] : 0) : (c[e].num = 0, c[e].skuId2 = 0), c[e].skuId && d.push(c[e].skuId), c[e].skuId2 && d.push(c[e].skuId2);
		b.html(lengCangGuiHtml.process({
			data: c
		})), getFreezerPrice(d), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.floor1 = function(a, b) {
	if (0 != a && 0 == b.find(".item-l").children("li").length && (a++, recommendJesonMap && recommendJesonMap["recommendList_1_" + a])) {
		var c = recommendJesonMap["recommendList_1_" + a];
		b.find(".item-l").html(floorHtml.process({
			data: c
		})), getFloorPrice(c), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.floor2 = function(a, b) {
	if (0 != a && 0 == b.find(".item-l").children("li").length && (a++, recommendJesonMap && recommendJesonMap["recommendList_2_" + a])) {
		var c = recommendJesonMap["recommendList_2_" + a];
		b.find(".item-l").html(floorHtml.process({
			data: c
		})), getFloorPrice(c), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.floor3 = function(a, b) {
	if (0 != a && 0 == b.find(".item-l").children("li").length && (a++, recommendJesonMap && recommendJesonMap["recommendList_3_" + a])) {
		var c = recommendJesonMap["recommendList_3_" + a];
		b.find(".item-l").html(floorHtml.process({
			data: c
		})), getFloorPrice(c), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.floor4 = function(a, b) {
	if (0 != a && 0 == b.find(".item-l").children("li").length && (a++, recommendJesonMap && recommendJesonMap["recommendList_4_" + a])) {
		var c = recommendJesonMap["recommendList_4_" + a];
		b.find(".item-l").html(floorHtml.process({
			data: c
		})), getFloorPrice(c), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.seckilling = function(a, b) {
	var c = limitBuyArray[a];
	jQuery.ajax({
		url: "http://qiang.jd.com/HomePageNewLimitBuy.ashx?callback=?",
		data: {
			ids: c
		},
		dataType: "jsonp",
		success: function(a) {
			if (a && a.data && a.data.length > 0) {
				for (var c = a.data[0], d = [], e = null, f = 0, g = c.pros.length; g > f; f++) {
					e = c.pros[f], e.tp = e.tp.replace("n3", "n7");
					var h = '<li><div class="p-img"><a href="http://item.jd.com/' + e.id + '.html" title="' + unescape(e.mc) + '" target="_blank"><img width="180" height="180" src="' + e.tp + '" alt="' + unescape(e.mc) + '"></a></div><div class="p-name"><a href="http://item.jd.com/' + e.id + '.html" title="' + unescape(e.mc) + '" target="_blank">' + unescape(e.mc) + '</a></div><div class="p-price"><strong>\uffe5' + e.qg + "</strong><del>" + e.sc + '</del></div><div class="p-btn"><a class="btn-m seckilling" href="http://item.jd.com/' + e.id + '.html">\u7acb\u5373\u79d2\u6740</a></div></li>';
					d.push(h)
				}
				b.find("ul").html(d.join(""))
			}
		}
	})
};
smarketCallback.snacksSublist = function(a, b, c) {
	if (0 != a && 0 == c.children("li").length && (a++, b++, matrixJsonMap && matrixJsonMap["matrixList_" + b + "_" + a])) {
		var d = matrixJsonMap["matrixList_" + b + "_" + a];
		c.html(snacksHtml.process({
			data: d
		})), getFloorPrice(d), pageConfig.FN_ImgError(c[0])
	}
}, smarketCallback.freshExpress = function(a, b) {
	if (0 != a && 0 == b.find(".fe-list").children("li").length && (a++, chaoshiMapJson && chaoshiMapJson["floor" + a + "List"])) {
		var c = chaoshiMapJson["floor" + a + "List"];
		b.find(".fe-list").html(freshExpressHtml.process({
			data: c
		})), getFloorPrice(c), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.cookingGeologyLeft = function(a, b) {
	if (0 != a && 0 == b.find("li").length) {
		a++;
		var c = null;
		2 == a && recommendList2 && (c = recommendList2), 3 == a && recommendList3 && (c = recommendList3), 4 == a && recommendList4 && (c = recommendList4), 5 == a && recommendList5 && (c = recommendList5), 6 == a && recommendList6 && (c = recommendList6), 7 == a && recommendList7 && (c = recommendList7), 8 == a && recommendList8 && (c = recommendList8), 9 == a && recommendList9 && (c = recommendList9), 10 == a && recommendList10 && (c = recommendList10), c && (b.html(cookingGeologyHtml.process({
			data: c
		})), getFloorPrice(c)), pageConfig.FN_ImgError(b[0])
	}
}, smarketCallback.cookingGeologyRight = function(a, b) {
	if (0 != a && 0 == b.find("li").length) {
		a += 11;
		var c = null;
		12 == a && recommendList12 && (c = recommendList12), 13 == a && recommendList13 && (c = recommendList13), 14 == a && recommendList14 && (c = recommendList14), 15 == a && recommendList15 && (c = recommendList15), 16 == a && recommendList16 && (c = recommendList16), 17 == a && recommendList17 && (c = recommendList17), 18 == a && recommendList18 && (c = recommendList18), c && (b.html(cookingGeologyHtml.process({
			data: c
		})), getFloorPrice(c))
	}
	pageConfig.FN_ImgError(b[0])
};
var floorHtml = '{for item in data}<li><div class="p-img"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank"><img class="err-product pimg${item.skuId}" width="100" height="100" data-img="1" src="${item.imageUrl}" alt="${item.skuName}"/></a></div><div class="p-name"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank">${item.skuName}</a></div><div class="p-price" sku="${item.skuId}"><strong></strong></div><div class="p-ext"><a class="btn-s addCart" href="javascript:void(0)" onclick="smAddToCart.add(this,${item.skuId})">\u52a0\u5165\u8d2d\u7269\u8f66</a></div></li>{/for}',
	freshExpressHtml = '{for item in data}<li><div class="p-img"><a href="http://item.jd.com/${item.skuId}.html" target="_blank"><img width="138" height="138" alt="${item.skuName}" data-img="1" class="err-product pimg${item.skuId}" src="${item.imageUrl}"></a></div><div sku="${item.skuId}" class="p-price"><strong></strong></div><div class="p-ext"><div class="p-name"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank">${item.skuName}</a></div><div class="p-btn"><a class="btn-s addCart" href="javascript:void(0)" onclick="smAddToCart.add(this,${item.skuId})">\u52a0\u5165\u8d2d\u7269\u8f66</a></div></div></li>{/for}',
	snacksHtml = '{for item in data}<li><div class="p-img"><a href="http://item.jd.com/${item.skuId}.html" target="_blank"><img class="err-product pimg${item.skuId}" width="160" height="160" data-img="1" src="${item.imageUrl}" alt="${item.skuName}"/></a></div><div class="p-price" sku="${item.skuId}"><strong></strong></div><div class="p-ext"><div class="p-name"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank">${item.skuName}</a></div><div class="p-btn"><a class="btn-s addCart" href="javascript:void(0)" onclick="smAddToCart.add(this,${item.skuId})">\u52a0\u5165\u8d2d\u7269\u8f66</a></div></div></li>{/for}',
	cookingGeologyHtml = '{for item in data}<li><div class="p-img"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank"><img class="err-product pimg${item.skuId}" width="100" height="100" data-img="1" src="${item.imageUrl}" alt="${item.skuName}"/></a></div><div class="p-name"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank">${item.skuName}</a></div><div class="p-price" sku="${item.skuId}"><strong></strong></div><div class="p-ext"> <a class="btn-s addCart" href="javascript:void(0)" onclick="smAddToCart.add(this,${item.skuId})">\u52a0\u5165\u8d2d\u7269\u8f66</a></div></li>{/for}',
	lengCangGuiHtml = '{for item in data}<li><div class="d-l-cart"><div class="p-name"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank">${item.skuName}</a></div><div class="p-btn"><a class="btn-s addCart single${item.skuId}" href="javascript:void(0)" onclick="smAddToCart.add(this,${item.skuId})"><i></i><span><em>1</em>\u4ef6</span><strong></strong></a><a class="btn-s addCart multi${item.skuId2}" href="javascript:void(0)"  onclick="smAddToCart.add(this,${item.skuId2})"><i></i><span><em>${item.num}</em>\u4ef6</span><strong></strong></a></div><span class="d-l-arrow"><em>\u25c6</em><i>\u25c6</i></span></div><a href="http://item.jd.com/${item.skuId}.html" target="_blank"><img class="err-product pimg${item.skuId}" width="30" height="100" data-img="1" src="${item.imageUrl}" alt="${item.skuName}"/></a></li>{/for}',
	chuanYueShiKongHtml = '{for item in data}<li><div class="p-img"><a href="http://item.jd.com/${item.skuId}.html" title="${item.skuName}" target="_blank"><img class="err-product  pimg${item.skuId}" width="80" height="80" data-img="1" src="${item.imageUrl}" alt="${item.skuName}"/></a></div><div class="p-ext"><div class="p-name"><a href="http://item.jd.com/${item.skuId}.html" title=${item.skuName}" target="_blank">${item.skuName}</a></div><div class="p-price" sku="${item.skuId}"><strong></strong></div></div></li>{/for}';