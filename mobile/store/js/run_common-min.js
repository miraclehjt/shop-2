/*!  2016-03-28 Shadow & 鸿宇科技 QQ:1527200768 */
(function (e, t) {
    function n(e) {
        var t = e.length, n = lt.type(e);
        return lt.isWindow(e) ? !1 : 1 === e.nodeType && t ? !0 : "array" === n || "function" !== n && (0 === t || "number" == typeof t && t > 0 && t - 1 in e)
    }

    function i(e) {
        var t = kt[e] = {};
        return lt.each(e.match(ut) || [], function (e, n) {
            t[n] = !0
        }), t
    }

    function a(e, n, i, a) {
        if (lt.acceptData(e)) {
            var o, r, s = lt.expando, l = "string" == typeof n, c = e.nodeType, u = c ? lt.cache : e, d = c ? e[s] : e[s] && s;
            if (d && u[d] && (a || u[d].data) || !l || i !== t)return d || (c ? e[s] = d = Z.pop() || lt.guid++ : d = s), u[d] || (u[d] = {}, c || (u[d].toJSON = lt.noop)), ("object" == typeof n || "function" == typeof n) && (a ? u[d] = lt.extend(u[d], n) : u[d].data = lt.extend(u[d].data, n)), o = u[d], a || (o.data || (o.data = {}), o = o.data), i !== t && (o[lt.camelCase(n)] = i), l ? (r = o[n], null == r && (r = o[lt.camelCase(n)])) : r = o, r
        }
    }

    function o(e, t, n) {
        if (lt.acceptData(e)) {
            var i, a, o, r = e.nodeType, l = r ? lt.cache : e, c = r ? e[lt.expando] : lt.expando;
            if (l[c]) {
                if (t && (o = n ? l[c] : l[c].data)) {
                    lt.isArray(t) ? t = t.concat(lt.map(t, lt.camelCase)) : t in o ? t = [t] : (t = lt.camelCase(t), t = t in o ? [t] : t.split(" "));
                    for (i = 0, a = t.length; a > i; i++)delete o[t[i]];
                    if (!(n ? s : lt.isEmptyObject)(o))return
                }
                (n || (delete l[c].data, s(l[c]))) && (r ? lt.cleanData([e], !0) : lt.support.deleteExpando || l != l.window ? delete l[c] : l[c] = null)
            }
        }
    }

    function r(e, n, i) {
        if (i === t && 1 === e.nodeType) {
            var a = "data-" + n.replace(Ct, "-$1").toLowerCase();
            if (i = e.getAttribute(a), "string" == typeof i) {
                try {
                    i = "true" === i ? !0 : "false" === i ? !1 : "null" === i ? null : +i + "" === i ? +i : Tt.test(i) ? lt.parseJSON(i) : i
                } catch (o) {
                }
                lt.data(e, n, i)
            } else i = t
        }
        return i
    }

    function s(e) {
        var t;
        for (t in e)if (("data" !== t || !lt.isEmptyObject(e[t])) && "toJSON" !== t)return !1;
        return !0
    }

    function l() {
        return !0
    }

    function c() {
        return !1
    }

    function u(e, t) {
        do e = e[t]; while (e && 1 !== e.nodeType);
        return e
    }

    function d(e, t, n) {
        if (t = t || 0, lt.isFunction(t))return lt.grep(e, function (e, i) {
            var a = !!t.call(e, i, e);
            return a === n
        });
        if (t.nodeType)return lt.grep(e, function (e) {
            return e === t === n
        });
        if ("string" == typeof t) {
            var i = lt.grep(e, function (e) {
                return 1 === e.nodeType
            });
            if (Ut.test(t))return lt.filter(t, i, !n);
            t = lt.filter(t, i)
        }
        return lt.grep(e, function (e) {
            return lt.inArray(e, t) >= 0 === n
        })
    }

    function p(e) {
        var t = Vt.split("|"), n = e.createDocumentFragment();
        if (n.createElement)for (; t.length;)n.createElement(t.pop());
        return n
    }

    function h(e, t) {
        return e.getElementsByTagName(t)[0] || e.appendChild(e.ownerDocument.createElement(t))
    }

    function f(e) {
        var t = e.getAttributeNode("type");
        return e.type = (t && t.specified) + "/" + e.type, e
    }

    function g(e) {
        var t = on.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function m(e, t) {
        for (var n, i = 0; null != (n = e[i]); i++)lt._data(n, "globalEval", !t || lt._data(t[i], "globalEval"))
    }

    function v(e, t) {
        if (1 === t.nodeType && lt.hasData(e)) {
            var n, i, a, o = lt._data(e), r = lt._data(t, o), s = o.events;
            if (s) {
                delete r.handle, r.events = {};
                for (n in s)for (i = 0, a = s[n].length; a > i; i++)lt.event.add(t, n, s[n][i])
            }
            r.data && (r.data = lt.extend({}, r.data))
        }
    }

    function y(e, t) {
        var n, i, a;
        if (1 === t.nodeType) {
            if (n = t.nodeName.toLowerCase(), !lt.support.noCloneEvent && t[lt.expando]) {
                a = lt._data(t);
                for (i in a.events)lt.removeEvent(t, i, a.handle);
                t.removeAttribute(lt.expando)
            }
            "script" === n && t.text !== e.text ? (f(t).text = e.text, g(t)) : "object" === n ? (t.parentNode && (t.outerHTML = e.outerHTML), lt.support.html5Clone && e.innerHTML && !lt.trim(t.innerHTML) && (t.innerHTML = e.innerHTML)) : "input" === n && tn.test(e.type) ? (t.defaultChecked = t.checked = e.checked, t.value !== e.value && (t.value = e.value)) : "option" === n ? t.defaultSelected = t.selected = e.defaultSelected : ("input" === n || "textarea" === n) && (t.defaultValue = e.defaultValue)
        }
    }

    function b(e, n) {
        var i, a, o = 0, r = typeof e.getElementsByTagName !== X ? e.getElementsByTagName(n || "*") : typeof e.querySelectorAll !== X ? e.querySelectorAll(n || "*") : t;
        if (!r)for (r = [], i = e.childNodes || e; null != (a = i[o]); o++)!n || lt.nodeName(a, n) ? r.push(a) : lt.merge(r, b(a, n));
        return n === t || n && lt.nodeName(e, n) ? lt.merge([e], r) : r
    }

    function w(e) {
        tn.test(e.type) && (e.defaultChecked = e.checked)
    }

    function x(e, t) {
        if (t in e)return t;
        for (var n = t.charAt(0).toUpperCase() + t.slice(1), i = t, a = Cn.length; a--;)if (t = Cn[a] + n, t in e)return t;
        return i
    }

    function _(e, t) {
        return e = t || e, "none" === lt.css(e, "display") || !lt.contains(e.ownerDocument, e)
    }

    function k(e, t) {
        for (var n, i, a, o = [], r = 0, s = e.length; s > r; r++)i = e[r], i.style && (o[r] = lt._data(i, "olddisplay"), n = i.style.display, t ? (o[r] || "none" !== n || (i.style.display = ""), "" === i.style.display && _(i) && (o[r] = lt._data(i, "olddisplay", E(i.nodeName)))) : o[r] || (a = _(i), (n && "none" !== n || !a) && lt._data(i, "olddisplay", a ? n : lt.css(i, "display"))));
        for (r = 0; s > r; r++)i = e[r], i.style && (t && "none" !== i.style.display && "" !== i.style.display || (i.style.display = t ? o[r] || "" : "none"));
        return e
    }

    function T(e, t, n) {
        var i = yn.exec(t);
        return i ? Math.max(0, i[1] - (n || 0)) + (i[2] || "px") : t
    }

    function C(e, t, n, i, a) {
        for (var o = n === (i ? "border" : "content") ? 4 : "width" === t ? 1 : 0, r = 0; 4 > o; o += 2)"margin" === n && (r += lt.css(e, n + Tn[o], !0, a)), i ? ("content" === n && (r -= lt.css(e, "padding" + Tn[o], !0, a)), "margin" !== n && (r -= lt.css(e, "border" + Tn[o] + "Width", !0, a))) : (r += lt.css(e, "padding" + Tn[o], !0, a), "padding" !== n && (r += lt.css(e, "border" + Tn[o] + "Width", !0, a)));
        return r
    }

    function S(e, t, n) {
        var i = !0, a = "width" === t ? e.offsetWidth : e.offsetHeight, o = dn(e), r = lt.support.boxSizing && "border-box" === lt.css(e, "boxSizing", !1, o);
        if (0 >= a || null == a) {
            if (a = pn(e, t, o), (0 > a || null == a) && (a = e.style[t]), bn.test(a))return a;
            i = r && (lt.support.boxSizingReliable || a === e.style[t]), a = parseFloat(a) || 0
        }
        return a + C(e, t, n || (r ? "border" : "content"), i, o) + "px"
    }

    function E(e) {
        var t = Y, n = xn[e];
        return n || (n = N(e, t), "none" !== n && n || (un = (un || lt("<fe frameborder='0' width='0' height='0'/>").css("cssText", "display:block !important")).appendTo(t.documentElement), t = (un[0].contentWindow || un[0].contentDocument).document, t.write("<!doctype html><html><body>"), t.close(), n = N(e, t), un.detach()), xn[e] = n), n
    }

    function N(e, t) {
        var n = lt(t.createElement(e)).appendTo(t.body), i = lt.css(n[0], "display");
        return n.remove(), i
    }

    function j(e, t, n, i) {
        var a;
        if (lt.isArray(t))lt.each(t, function (t, a) {
            n || En.test(e) ? i(e, a) : j(e + "[" + ("object" == typeof a ? t : "") + "]", a, n, i)
        }); else if (n || "object" !== lt.type(t))i(e, t); else for (a in t)j(e + "[" + a + "]", t[a], n, i)
    }

    function D(e) {
        return function (t, n) {
            "string" != typeof t && (n = t, t = "*");
            var i, a = 0, o = t.toLowerCase().match(ut) || [];
            if (lt.isFunction(n))for (; i = o[a++];)"+" === i[0] ? (i = i.slice(1) || "*", (e[i] = e[i] || []).unshift(n)) : (e[i] = e[i] || []).push(n)
        }
    }

    function I(e, n, i, a) {
        function o(l) {
            var c;
            return r[l] = !0, lt.each(e[l] || [], function (e, l) {
                var u = l(n, i, a);
                return "string" != typeof u || s || r[u] ? s ? !(c = u) : t : (n.dataTypes.unshift(u), o(u), !1)
            }), c
        }

        var r = {}, s = e === $n;
        return o(n.dataTypes[0]) || !r["*"] && o("*")
    }

    function A(e, n) {
        var i, a, o = lt.ajaxSettings.flatOptions || {};
        for (a in n)n[a] !== t && ((o[a] ? e : i || (i = {}))[a] = n[a]);
        return i && lt.extend(!0, e, i), e
    }

    function L(e, n, i) {
        var a, o, r, s, l = e.contents, c = e.dataTypes, u = e.responseFields;
        for (s in u)s in i && (n[u[s]] = i[s]);
        for (; "*" === c[0];)c.shift(), o === t && (o = e.mimeType || n.getResponseHeader("Content-Type"));
        if (o)for (s in l)if (l[s] && l[s].test(o)) {
            c.unshift(s);
            break
        }
        if (c[0]in i)r = c[0]; else {
            for (s in i) {
                if (!c[0] || e.converters[s + " " + c[0]]) {
                    r = s;
                    break
                }
                a || (a = s)
            }
            r = r || a
        }
        return r ? (r !== c[0] && c.unshift(r), i[r]) : t
    }

    function M(e, t) {
        var n, i, a, o, r = {}, s = 0, l = e.dataTypes.slice(), c = l[0];
        if (e.dataFilter && (t = e.dataFilter(t, e.dataType)), l[1])for (a in e.converters)r[a.toLowerCase()] = e.converters[a];
        for (; i = l[++s];)if ("*" !== i) {
            if ("*" !== c && c !== i) {
                if (a = r[c + " " + i] || r["* " + i], !a)for (n in r)if (o = n.split(" "), o[1] === i && (a = r[c + " " + o[0]] || r["* " + o[0]])) {
                    a === !0 ? a = r[n] : r[n] !== !0 && (i = o[0], l.splice(s--, 0, i));
                    break
                }
                if (a !== !0)if (a && e["throws"])t = a(t); else try {
                    t = a(t)
                } catch (u) {
                    return {state: "parsererror", error: a ? u : "No conversion from " + c + " to " + i}
                }
            }
            c = i
        }
        return {state: "success", data: t}
    }

    function P() {
        try {
            return new e.XMLHttpRequest
        } catch (t) {
        }
    }

    function R() {
        try {
            return new e.ActiveXObject("Microsoft.XMLHTTP")
        } catch (t) {
        }
    }

    function O() {
        return setTimeout(function () {
            Zn = t
        }), Zn = lt.now()
    }

    function z(e, t) {
        lt.each(t, function (t, n) {
            for (var i = (oi[t] || []).concat(oi["*"]), a = 0, o = i.length; o > a; a++)if (i[a].call(e, t, n))return
        })
    }

    function F(e, t, n) {
        var i, a, o = 0, r = ai.length, s = lt.Deferred().always(function () {
            delete l.elem
        }), l = function () {
            if (a)return !1;
            for (var t = Zn || O(), n = Math.max(0, c.startTime + c.duration - t), i = n / c.duration || 0, o = 1 - i, r = 0, l = c.tweens.length; l > r; r++)c.tweens[r].run(o);
            return s.notifyWith(e, [c, o, n]), 1 > o && l ? n : (s.resolveWith(e, [c]), !1)
        }, c = s.promise({
            elem: e,
            props: lt.extend({}, t),
            opts: lt.extend(!0, {specialEasing: {}}, n),
            originalProperties: t,
            originalOptions: n,
            startTime: Zn || O(),
            duration: n.duration,
            tweens: [],
            createTween: function (t, n) {
                var i = lt.Tween(e, c.opts, t, n, c.opts.specialEasing[t] || c.opts.easing);
                return c.tweens.push(i), i
            },
            stop: function (t) {
                var n = 0, i = t ? c.tweens.length : 0;
                if (a)return this;
                for (a = !0; i > n; n++)c.tweens[n].run(1);
                return t ? s.resolveWith(e, [c, t]) : s.rejectWith(e, [c, t]), this
            }
        }), u = c.props;
        for (H(u, c.opts.specialEasing); r > o; o++)if (i = ai[o].call(c, e, u, c.opts))return i;
        return z(c, u), lt.isFunction(c.opts.start) && c.opts.start.call(e, c), lt.fx.timer(lt.extend(l, {
            elem: e,
            anim: c,
            queue: c.opts.queue
        })), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always)
    }

    function H(e, t) {
        var n, i, a, o, r;
        for (a in e)if (i = lt.camelCase(a), o = t[i], n = e[a], lt.isArray(n) && (o = n[1], n = e[a] = n[0]), a !== i && (e[i] = n, delete e[a]), r = lt.cssHooks[i], r && "expand"in r) {
            n = r.expand(n), delete e[i];
            for (a in n)a in e || (e[a] = n[a], t[a] = o)
        } else t[i] = o
    }

    function B(e, t, n) {
        var i, a, o, r, s, l, c, u, d, p = this, h = e.style, f = {}, g = [], m = e.nodeType && _(e);
        n.queue || (u = lt._queueHooks(e, "fx"), null == u.unqueued && (u.unqueued = 0, d = u.empty.fire, u.empty.fire = function () {
            u.unqueued || d()
        }), u.unqueued++, p.always(function () {
            p.always(function () {
                u.unqueued--, lt.queue(e, "fx").length || u.empty.fire()
            })
        })), 1 === e.nodeType && ("height"in t || "width"in t) && (n.overflow = [h.overflow, h.overflowX, h.overflowY], "inline" === lt.css(e, "display") && "none" === lt.css(e, "float") && (lt.support.inlineBlockNeedsLayout && "inline" !== E(e.nodeName) ? h.zoom = 1 : h.display = "inline-block")), n.overflow && (h.overflow = "hidden", lt.support.shrinkWrapBlocks || p.always(function () {
            h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
        }));
        for (a in t)if (r = t[a], ti.exec(r)) {
            if (delete t[a], l = l || "toggle" === r, r === (m ? "hide" : "show"))continue;
            g.push(a)
        }
        if (o = g.length) {
            s = lt._data(e, "fxshow") || lt._data(e, "fxshow", {}), "hidden"in s && (m = s.hidden), l && (s.hidden = !m), m ? lt(e).show() : p.done(function () {
                lt(e).hide()
            }), p.done(function () {
                var t;
                lt._removeData(e, "fxshow");
                for (t in f)lt.style(e, t, f[t])
            });
            for (a = 0; o > a; a++)i = g[a], c = p.createTween(i, m ? s[i] : 0), f[i] = s[i] || lt.style(e, i), i in s || (s[i] = c.start, m && (c.end = c.start, c.start = "width" === i || "height" === i ? 1 : 0))
        }
    }

    function W(e, t, n, i, a) {
        return new W.prototype.init(e, t, n, i, a)
    }

    function U(e, t) {
        var n, i = {height: e}, a = 0;
        for (t = t ? 1 : 0; 4 > a; a += 2 - t)n = Tn[a], i["margin" + n] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i
    }

    function $(e) {
        return lt.isWindow(e) ? e : 9 === e.nodeType ? e.defaultView || e.parentWindow : !1
    }

    var q, V, X = typeof t, Y = e.document, G = e.location, K = e.jQuery, Q = e.$, J = {}, Z = [], et = "1.9.1", tt = Z.concat, nt = Z.push, it = Z.slice, at = Z.indexOf, ot = J.toString, rt = J.hasOwnProperty, st = et.trim, lt = function (e, t) {
        return new lt.fn.init(e, t, V)
    }, ct = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, ut = /\S+/g, dt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, pt = /^(?:(<[\w\W]+>)[^>]*|#([\w-]*))$/, ht = /^<(\w+)\s*\/?>(?:<\/\1>|)$/, ft = /^[\],:{}\s]*$/, gt = /(?:^|:|,)(?:\s*\[)+/g, mt = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g, vt = /"[^"\\\r\n]*"|true|false|null|-?(?:\d+\.|)\d+(?:[eE][+-]?\d+|)/g, yt = /^-ms-/, bt = /-([\da-z])/gi, wt = function (e, t) {
        return t.toUpperCase()
    }, xt = function (e) {
        (Y.addEventListener || "load" === e.type || "complete" === Y.readyState) && (_t(), lt.ready())
    }, _t = function () {
        Y.addEventListener ? (Y.removeEventListener("DOMContentLoaded", xt, !1), e.removeEventListener("load", xt, !1)) : (Y.detachEvent("onreadystatechange", xt), e.detachEvent("onload", xt))
    };
    lt.fn = lt.prototype = {
        jquery: et, constructor: lt, init: function (e, n, i) {
            var a, o;
            if (!e)return this;
            if ("string" == typeof e) {
                if (a = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && e.length >= 3 ? [null, e, null] : pt.exec(e), !a || !a[1] && n)return !n || n.jquery ? (n || i).find(e) : this.constructor(n).find(e);
                if (a[1]) {
                    if (n = n instanceof lt ? n[0] : n, lt.merge(this, lt.parseHTML(a[1], n && n.nodeType ? n.ownerDocument || n : Y, !0)), ht.test(a[1]) && lt.isPlainObject(n))for (a in n)lt.isFunction(this[a]) ? this[a](n[a]) : this.attr(a, n[a]);
                    return this
                }
                if (o = Y.getElementById(a[2]), o && o.parentNode) {
                    if (o.id !== a[2])return i.find(e);
                    this.length = 1, this[0] = o
                }
                return this.context = Y, this.selector = e, this
            }
            return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : lt.isFunction(e) ? i.ready(e) : (e.selector !== t && (this.selector = e.selector, this.context = e.context), lt.makeArray(e, this))
        }, selector: "", length: 0, size: function () {
            return this.length
        }, toArray: function () {
            return it.call(this)
        }, get: function (e) {
            return null == e ? this.toArray() : 0 > e ? this[this.length + e] : this[e]
        }, pushStack: function (e) {
            var t = lt.merge(this.constructor(), e);
            return t.prevObject = this, t.context = this.context, t
        }, each: function (e, t) {
            return lt.each(this, e, t)
        }, ready: function (e) {
            return lt.ready.promise().done(e), this
        }, slice: function () {
            return this.pushStack(it.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, eq: function (e) {
            var t = this.length, n = +e + (0 > e ? t : 0);
            return this.pushStack(n >= 0 && t > n ? [this[n]] : [])
        }, map: function (e) {
            return this.pushStack(lt.map(this, function (t, n) {
                return e.call(t, n, t)
            }))
        }, end: function () {
            return this.prevObject || this.constructor(null)
        }, push: nt, sort: [].sort, splice: [].splice
    }, lt.fn.init.prototype = lt.fn, lt.extend = lt.fn.extend = function () {
        var e, n, i, a, o, r, s = arguments[0] || {}, l = 1, c = arguments.length, u = !1;
        for ("boolean" == typeof s && (u = s, s = arguments[1] || {}, l = 2), "object" == typeof s || lt.isFunction(s) || (s = {}), c === l && (s = this, --l); c > l; l++)if (null != (o = arguments[l]))for (a in o)e = s[a], i = o[a], s !== i && (u && i && (lt.isPlainObject(i) || (n = lt.isArray(i))) ? (n ? (n = !1, r = e && lt.isArray(e) ? e : []) : r = e && lt.isPlainObject(e) ? e : {}, s[a] = lt.extend(u, r, i)) : i !== t && (s[a] = i));
        return s
    }, lt.extend({
        noConflict: function (t) {
            return e.$ === lt && (e.$ = Q), t && e.jQuery === lt && (e.jQuery = K), lt
        }, isReady: !1, readyWait: 1, holdReady: function (e) {
            e ? lt.readyWait++ : lt.ready(!0)
        }, ready: function (e) {
            if (e === !0 ? !--lt.readyWait : !lt.isReady) {
                if (!Y.body)return setTimeout(lt.ready);
                lt.isReady = !0, e !== !0 && --lt.readyWait > 0 || (q.resolveWith(Y, [lt]), lt.fn.trigger && lt(Y).trigger("ready").off("ready"))
            }
        }, isFunction: function (e) {
            return "function" === lt.type(e)
        }, isArray: Array.isArray || function (e) {
            return "array" === lt.type(e)
        }, isWindow: function (e) {
            return null != e && e == e.window
        }, isNumeric: function (e) {
            return !isNaN(parseFloat(e)) && isFinite(e)
        }, type: function (e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? J[ot.call(e)] || "object" : typeof e
        }, isPlainObject: function (e) {
            if (!e || "object" !== lt.type(e) || e.nodeType || lt.isWindow(e))return !1;
            try {
                if (e.constructor && !rt.call(e, "constructor") && !rt.call(e.constructor.prototype, "isPrototypeOf"))return !1
            } catch (n) {
                return !1
            }
            var i;
            for (i in e);
            return i === t || rt.call(e, i)
        }, isEmptyObject: function (e) {
            var t;
            for (t in e)return !1;
            return !0
        }, error: function (e) {
            throw Error(e)
        }, parseHTML: function (e, t, n) {
            if (!e || "string" != typeof e)return null;
            "boolean" == typeof t && (n = t, t = !1), t = t || Y;
            var i = ht.exec(e), a = !n && [];
            return i ? [t.createElement(i[1])] : (i = lt.buildFragment([e], t, a), a && lt(a).remove(), lt.merge([], i.childNodes))
        }, parseJSON: function (n) {
            return e.JSON && e.JSON.parse ? e.JSON.parse(n) : null === n ? n : "string" == typeof n && (n = lt.trim(n), n && ft.test(n.replace(mt, "@").replace(vt, "]").replace(gt, ""))) ? Function("return " + n)() : (lt.error("Invalid JSON: " + n), t)
        }, parseXML: function (n) {
            var i, a;
            if (!n || "string" != typeof n)return null;
            try {
                e.DOMParser ? (a = new DOMParser, i = a.parseFromString(n, "text/xml")) : (i = new ActiveXObject("Microsoft.XMLDOM"), i.async = "false", i.loadXML(n))
            } catch (o) {
                i = t
            }
            return i && i.documentElement && !i.getElementsByTagName("parsererror").length || lt.error("Invalid XML: " + n), i
        }, noop: function () {
        }, globalEval: function (t) {
            t && lt.trim(t) && (e.execScript || function (t) {
                e.eval.call(e, t)
            })(t)
        }, camelCase: function (e) {
            return e.replace(yt, "ms-").replace(bt, wt)
        }, nodeName: function (e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
        }, each: function (e, t, i) {
            var a, o = 0, r = e.length, s = n(e);
            if (i) {
                if (s)for (; r > o && (a = t.apply(e[o], i), a !== !1); o++); else for (o in e)if (a = t.apply(e[o], i), a === !1)break
            } else if (s)for (; r > o && (a = t.call(e[o], o, e[o]), a !== !1); o++); else for (o in e)if (a = t.call(e[o], o, e[o]), a === !1)break;
            return e
        }, trim: st && !st.call("﻿ ") ? function (e) {
            return null == e ? "" : st.call(e)
        } : function (e) {
            return null == e ? "" : (e + "").replace(dt, "")
        }, makeArray: function (e, t) {
            var i = t || [];
            return null != e && (n(Object(e)) ? lt.merge(i, "string" == typeof e ? [e] : e) : nt.call(i, e)), i
        }, inArray: function (e, t, n) {
            var i;
            if (t) {
                if (at)return at.call(t, e, n);
                for (i = t.length, n = n ? 0 > n ? Math.max(0, i + n) : n : 0; i > n; n++)if (n in t && t[n] === e)return n
            }
            return -1
        }, merge: function (e, n) {
            var i = n.length, a = e.length, o = 0;
            if ("number" == typeof i)for (; i > o; o++)e[a++] = n[o]; else for (; n[o] !== t;)e[a++] = n[o++];
            return e.length = a, e
        }, grep: function (e, t, n) {
            var i, a = [], o = 0, r = e.length;
            for (n = !!n; r > o; o++)i = !!t(e[o], o), n !== i && a.push(e[o]);
            return a
        }, map: function (e, t, i) {
            var a, o = 0, r = e.length, s = n(e), l = [];
            if (s)for (; r > o; o++)a = t(e[o], o, i), null != a && (l[l.length] = a); else for (o in e)a = t(e[o], o, i), null != a && (l[l.length] = a);
            return tt.apply([], l)
        }, guid: 1, proxy: function (e, n) {
            var i, a, o;
            return "string" == typeof n && (o = e[n], n = e, e = o), lt.isFunction(e) ? (i = it.call(arguments, 2), a = function () {
                return e.apply(n || this, i.concat(it.call(arguments)))
            }, a.guid = e.guid = e.guid || lt.guid++, a) : t
        }, access: function (e, n, i, a, o, r, s) {
            var l = 0, c = e.length, u = null == i;
            if ("object" === lt.type(i)) {
                o = !0;
                for (l in i)lt.access(e, n, l, i[l], !0, r, s)
            } else if (a !== t && (o = !0, lt.isFunction(a) || (s = !0), u && (s ? (n.call(e, a), n = null) : (u = n, n = function (e, t, n) {
                    return u.call(lt(e), n)
                })), n))for (; c > l; l++)n(e[l], i, s ? a : a.call(e[l], l, n(e[l], i)));
            return o ? e : u ? n.call(e) : c ? n(e[0], i) : r
        }, now: function () {
            return (new Date).getTime()
        }
    }), lt.ready.promise = function (t) {
        if (!q)if (q = lt.Deferred(), "complete" === Y.readyState)setTimeout(lt.ready); else if (Y.addEventListener)Y.addEventListener("DOMContentLoaded", xt, !1), e.addEventListener("load", xt, !1); else {
            Y.attachEvent("onreadystatechange", xt), e.attachEvent("onload", xt);
            var n = !1;
            try {
                n = null == e.frameElement && Y.documentElement
            } catch (i) {
            }
            n && n.doScroll && function a() {
                if (!lt.isReady) {
                    try {
                        n.doScroll("left")
                    } catch (e) {
                        return setTimeout(a, 50)
                    }
                    _t(), lt.ready()
                }
            }()
        }
        return q.promise(t)
    }, lt.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function (e, t) {
        J["[object " + t + "]"] = t.toLowerCase()
    }), V = lt(Y);
    var kt = {};
    lt.Callbacks = function (e) {
        e = "string" == typeof e ? kt[e] || i(e) : lt.extend({}, e);
        var n, a, o, r, s, l, c = [], u = !e.once && [], d = function (t) {
            for (a = e.memory && t, o = !0, s = l || 0, l = 0, r = c.length, n = !0; c && r > s; s++)if (c[s].apply(t[0], t[1]) === !1 && e.stopOnFalse) {
                a = !1;
                break
            }
            n = !1, c && (u ? u.length && d(u.shift()) : a ? c = [] : p.disable())
        }, p = {
            add: function () {
                if (c) {
                    var t = c.length;
                    (function i(t) {
                        lt.each(t, function (t, n) {
                            var a = lt.type(n);
                            "function" === a ? e.unique && p.has(n) || c.push(n) : n && n.length && "string" !== a && i(n)
                        })
                    })(arguments), n ? r = c.length : a && (l = t, d(a))
                }
                return this
            }, remove: function () {
                return c && lt.each(arguments, function (e, t) {
                    for (var i; (i = lt.inArray(t, c, i)) > -1;)c.splice(i, 1), n && (r >= i && r--, s >= i && s--)
                }), this
            }, has: function (e) {
                return e ? lt.inArray(e, c) > -1 : !(!c || !c.length)
            }, empty: function () {
                return c = [], this
            }, disable: function () {
                return c = u = a = t, this
            }, disabled: function () {
                return !c
            }, lock: function () {
                return u = t, a || p.disable(), this
            }, locked: function () {
                return !u
            }, fireWith: function (e, t) {
                return t = t || [], t = [e, t.slice ? t.slice() : t], !c || o && !u || (n ? u.push(t) : d(t)), this
            }, fire: function () {
                return p.fireWith(this, arguments), this
            }, fired: function () {
                return !!o
            }
        };
        return p
    }, lt.extend({
        Deferred: function (e) {
            var t = [["resolve", "done", lt.Callbacks("once memory"), "resolved"], ["reject", "fail", lt.Callbacks("once memory"), "rejected"], ["notify", "progress", lt.Callbacks("memory")]], n = "pending", i = {
                state: function () {
                    return n
                }, always: function () {
                    return a.done(arguments).fail(arguments), this
                }, then: function () {
                    var e = arguments;
                    return lt.Deferred(function (n) {
                        lt.each(t, function (t, o) {
                            var r = o[0], s = lt.isFunction(e[t]) && e[t];
                            a[o[1]](function () {
                                var e = s && s.apply(this, arguments);
                                e && lt.isFunction(e.promise) ? e.promise().done(n.resolve).fail(n.reject).progress(n.notify) : n[r + "With"](this === i ? n.promise() : this, s ? [e] : arguments)
                            })
                        }), e = null
                    }).promise()
                }, promise: function (e) {
                    return null != e ? lt.extend(e, i) : i
                }
            }, a = {};
            return i.pipe = i.then, lt.each(t, function (e, o) {
                var r = o[2], s = o[3];
                i[o[1]] = r.add, s && r.add(function () {
                    n = s
                }, t[1 ^ e][2].disable, t[2][2].lock), a[o[0]] = function () {
                    return a[o[0] + "With"](this === a ? i : this, arguments), this
                }, a[o[0] + "With"] = r.fireWith
            }), i.promise(a), e && e.call(a, a), a
        }, when: function (e) {
            var t, n, i, a = 0, o = it.call(arguments), r = o.length, s = 1 !== r || e && lt.isFunction(e.promise) ? r : 0, l = 1 === s ? e : lt.Deferred(), c = function (e, n, i) {
                return function (a) {
                    n[e] = this, i[e] = arguments.length > 1 ? it.call(arguments) : a, i === t ? l.notifyWith(n, i) : --s || l.resolveWith(n, i)
                }
            };
            if (r > 1)for (t = Array(r), n = Array(r), i = Array(r); r > a; a++)o[a] && lt.isFunction(o[a].promise) ? o[a].promise().done(c(a, i, o)).fail(l.reject).progress(c(a, n, t)) : --s;
            return s || l.resolveWith(i, o), l.promise()
        }
    }), lt.support = function () {
        var t, n, i, a, o, r, s, l, c, u, d = Y.createElement("div");
        if (d.setAttribute("className", "t"), d.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", n = d.getElementsByTagName("*"), i = d.getElementsByTagName("a")[0], !n || !i || !n.length)return {};
        o = Y.createElement("select"), s = o.appendChild(Y.createElement("option")), a = d.getElementsByTagName("input")[0], i.style.cssText = "top:1px;float:left;opacity:.5", t = {
            getSetAttribute: "t" !== d.className,
            leadingWhitespace: 3 === d.firstChild.nodeType,
            tbody: !d.getElementsByTagName("tbody").length,
            htmlSerialize: !!d.getElementsByTagName("link").length,
            style: /top/.test(i.getAttribute("style")),
            hrefNormalized: "/a" === i.getAttribute("href"),
            opacity: /^0.5/.test(i.style.opacity),
            cssFloat: !!i.style.cssFloat,
            checkOn: !!a.value,
            optSelected: s.selected,
            enctype: !!Y.createElement("form").enctype,
            html5Clone: "<:nav></:nav>" !== Y.createElement("nav").cloneNode(!0).outerHTML,
            boxModel: "CSS1Compat" === Y.compatMode,
            deleteExpando: !0,
            noCloneEvent: !0,
            inlineBlockNeedsLayout: !1,
            shrinkWrapBlocks: !1,
            reliableMarginRight: !0,
            boxSizingReliable: !0,
            pixelPosition: !1
        }, a.checked = !0, t.noCloneChecked = a.cloneNode(!0).checked, o.disabled = !0, t.optDisabled = !s.disabled;
        try {
            delete d.test
        } catch (p) {
            t.deleteExpando = !1
        }
        a = Y.createElement("input"), a.setAttribute("value", ""), t.input = "" === a.getAttribute("value"), a.value = "t", a.setAttribute("type", "radio"), t.radioValue = "t" === a.value, a.setAttribute("checked", "t"), a.setAttribute("name", "t"), r = Y.createDocumentFragment(), r.appendChild(a), t.appendChecked = a.checked, t.checkClone = r.cloneNode(!0).cloneNode(!0).lastChild.checked, d.attachEvent && (d.attachEvent("onclick", function () {
            t.noCloneEvent = !1
        }), d.cloneNode(!0).click());
        for (u in{
            submit: !0,
            change: !0,
            focusin: !0
        })d.setAttribute(l = "on" + u, "t"), t[u + "Bubbles"] = l in e || d.attributes[l].expando === !1;
        return d.style.backgroundClip = "content-box", d.cloneNode(!0).style.backgroundClip = "", t.clearCloneStyle = "content-box" === d.style.backgroundClip, lt(function () {
            var n, i, a, o = "padding:0;margin:0;border:0;display:block;box-sizing:content-box;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;", r = Y.getElementsByTagName("body")[0];
            r && (n = Y.createElement("div"), n.style.cssText = "border:0;width:0;height:0;position:absolute;top:0;left:-9999px;margin-top:1px", r.appendChild(n).appendChild(d), d.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", a = d.getElementsByTagName("td"), a[0].style.cssText = "padding:0;margin:0;border:0;display:none", c = 0 === a[0].offsetHeight, a[0].style.display = "", a[1].style.display = "none", t.reliableHiddenOffsets = c && 0 === a[0].offsetHeight, d.innerHTML = "", d.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;", t.boxSizing = 4 === d.offsetWidth, t.doesNotIncludeMarginInBodyOffset = 1 !== r.offsetTop, e.getComputedStyle && (t.pixelPosition = "1%" !== (e.getComputedStyle(d, null) || {}).top, t.boxSizingReliable = "4px" === (e.getComputedStyle(d, null) || {width: "4px"}).width, i = d.appendChild(Y.createElement("div")), i.style.cssText = d.style.cssText = o, i.style.marginRight = i.style.width = "0", d.style.width = "1px", t.reliableMarginRight = !parseFloat((e.getComputedStyle(i, null) || {}).marginRight)), typeof d.style.zoom !== X && (d.innerHTML = "", d.style.cssText = o + "width:1px;padding:1px;display:inline;zoom:1", t.inlineBlockNeedsLayout = 3 === d.offsetWidth, d.style.display = "block", d.innerHTML = "<div></div>", d.firstChild.style.width = "5px", t.shrinkWrapBlocks = 3 !== d.offsetWidth, t.inlineBlockNeedsLayout && (r.style.zoom = 1)), r.removeChild(n), n = d = a = i = null)
        }), n = o = r = s = i = a = null, t
    }();
    var Tt = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/, Ct = /([A-Z])/g;
    lt.extend({
        cache: {},
        expando: "jQuery" + (et + Math.random()).replace(/\D/g, ""),
        noData: {embed: !0, object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000", applet: !0},
        hasData: function (e) {
            return e = e.nodeType ? lt.cache[e[lt.expando]] : e[lt.expando], !!e && !s(e)
        },
        data: function (e, t, n) {
            return a(e, t, n)
        },
        removeData: function (e, t) {
            return o(e, t)
        },
        _data: function (e, t, n) {
            return a(e, t, n, !0)
        },
        _removeData: function (e, t) {
            return o(e, t, !0)
        },
        acceptData: function (e) {
            if (e.nodeType && 1 !== e.nodeType && 9 !== e.nodeType)return !1;
            var t = e.nodeName && lt.noData[e.nodeName.toLowerCase()];
            return !t || t !== !0 && e.getAttribute("classid") === t
        }
    }), lt.fn.extend({
        data: function (e, n) {
            var i, a, o = this[0], s = 0, l = null;
            if (e === t) {
                if (this.length && (l = lt.data(o), 1 === o.nodeType && !lt._data(o, "parsedAttrs"))) {
                    for (i = o.attributes; i.length > s; s++)a = i[s].name, a.indexOf("data-") || (a = lt.camelCase(a.slice(5)), r(o, a, l[a]));
                    lt._data(o, "parsedAttrs", !0)
                }
                return l
            }
            return "object" == typeof e ? this.each(function () {
                lt.data(this, e)
            }) : lt.access(this, function (n) {
                return n === t ? o ? r(o, e, lt.data(o, e)) : null : (this.each(function () {
                    lt.data(this, e, n)
                }), t)
            }, null, n, arguments.length > 1, null, !0)
        }, removeData: function (e) {
            return this.each(function () {
                lt.removeData(this, e)
            })
        }
    }), lt.extend({
        queue: function (e, n, i) {
            var a;
            return e ? (n = (n || "fx") + "queue", a = lt._data(e, n), i && (!a || lt.isArray(i) ? a = lt._data(e, n, lt.makeArray(i)) : a.push(i)), a || []) : t
        }, dequeue: function (e, t) {
            t = t || "fx";
            var n = lt.queue(e, t), i = n.length, a = n.shift(), o = lt._queueHooks(e, t), r = function () {
                lt.dequeue(e, t)
            };
            "inprogress" === a && (a = n.shift(), i--), o.cur = a, a && ("fx" === t && n.unshift("inprogress"), delete o.stop, a.call(e, r, o)), !i && o && o.empty.fire()
        }, _queueHooks: function (e, t) {
            var n = t + "queueHooks";
            return lt._data(e, n) || lt._data(e, n, {
                    empty: lt.Callbacks("once memory").add(function () {
                        lt._removeData(e, t + "queue"), lt._removeData(e, n)
                    })
                })
        }
    }), lt.fn.extend({
        queue: function (e, n) {
            var i = 2;
            return "string" != typeof e && (n = e, e = "fx", i--), i > arguments.length ? lt.queue(this[0], e) : n === t ? this : this.each(function () {
                var t = lt.queue(this, e, n);
                lt._queueHooks(this, e), "fx" === e && "inprogress" !== t[0] && lt.dequeue(this, e)
            })
        }, dequeue: function (e) {
            return this.each(function () {
                lt.dequeue(this, e)
            })
        }, delay: function (e, t) {
            return e = lt.fx ? lt.fx.speeds[e] || e : e, t = t || "fx", this.queue(t, function (t, n) {
                var i = setTimeout(t, e);
                n.stop = function () {
                    clearTimeout(i)
                }
            })
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, n) {
            var i, a = 1, o = lt.Deferred(), r = this, s = this.length, l = function () {
                --a || o.resolveWith(r, [r])
            };
            for ("string" != typeof e && (n = e, e = t), e = e || "fx"; s--;)i = lt._data(r[s], e + "queueHooks"), i && i.empty && (a++, i.empty.add(l));
            return l(), o.promise(n)
        }
    });
    var St, Et, Nt = /[\t\r\n]/g, jt = /\r/g, Dt = /^(?:input|select|textarea|button|object)$/i, It = /^(?:a|area)$/i, At = /^(?:checked|selected|autofocus|autoplay|async|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped)$/i, Lt = /^(?:checked|selected)$/i, Mt = lt.support.getSetAttribute, Pt = lt.support.input;
    lt.fn.extend({
        attr: function (e, t) {
            return lt.access(this, lt.attr, e, t, arguments.length > 1)
        }, removeAttr: function (e) {
            return this.each(function () {
                lt.removeAttr(this, e)
            })
        }, prop: function (e, t) {
            return lt.access(this, lt.prop, e, t, arguments.length > 1)
        }, removeProp: function (e) {
            return e = lt.propFix[e] || e, this.each(function () {
                try {
                    this[e] = t, delete this[e]
                } catch (n) {
                }
            })
        }, addClass: function (e) {
            var t, n, i, a, o, r = 0, s = this.length, l = "string" == typeof e && e;
            if (lt.isFunction(e))return this.each(function (t) {
                lt(this).addClass(e.call(this, t, this.className))
            });
            if (l)for (t = (e || "").match(ut) || []; s > r; r++)if (n = this[r], i = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(Nt, " ") : " ")) {
                for (o = 0; a = t[o++];)0 > i.indexOf(" " + a + " ") && (i += a + " ");
                n.className = lt.trim(i)
            }
            return this
        }, removeClass: function (e) {
            var t, n, i, a, o, r = 0, s = this.length, l = 0 === arguments.length || "string" == typeof e && e;
            if (lt.isFunction(e))return this.each(function (t) {
                lt(this).removeClass(e.call(this, t, this.className))
            });
            if (l)for (t = (e || "").match(ut) || []; s > r; r++)if (n = this[r], i = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(Nt, " ") : "")) {
                for (o = 0; a = t[o++];)for (; i.indexOf(" " + a + " ") >= 0;)i = i.replace(" " + a + " ", " ");
                n.className = e ? lt.trim(i) : ""
            }
            return this
        }, toggleClass: function (e, t) {
            var n = typeof e, i = "boolean" == typeof t;
            return lt.isFunction(e) ? this.each(function (n) {
                lt(this).toggleClass(e.call(this, n, this.className, t), t)
            }) : this.each(function () {
                if ("string" === n)for (var a, o = 0, r = lt(this), s = t, l = e.match(ut) || []; a = l[o++];)s = i ? s : !r.hasClass(a), r[s ? "addClass" : "removeClass"](a); else(n === X || "boolean" === n) && (this.className && lt._data(this, "__className__", this.className), this.className = this.className || e === !1 ? "" : lt._data(this, "__className__") || "")
            })
        }, hasClass: function (e) {
            for (var t = " " + e + " ", n = 0, i = this.length; i > n; n++)if (1 === this[n].nodeType && (" " + this[n].className + " ").replace(Nt, " ").indexOf(t) >= 0)return !0;
            return !1
        }, val: function (e) {
            var n, i, a, o = this[0];
            {
                if (arguments.length)return a = lt.isFunction(e), this.each(function (n) {
                    var o, r = lt(this);
                    1 === this.nodeType && (o = a ? e.call(this, n, r.val()) : e, null == o ? o = "" : "number" == typeof o ? o += "" : lt.isArray(o) && (o = lt.map(o, function (e) {
                        return null == e ? "" : e + ""
                    })), i = lt.valHooks[this.type] || lt.valHooks[this.nodeName.toLowerCase()], i && "set"in i && i.set(this, o, "value") !== t || (this.value = o))
                });
                if (o)return i = lt.valHooks[o.type] || lt.valHooks[o.nodeName.toLowerCase()], i && "get"in i && (n = i.get(o, "value")) !== t ? n : (n = o.value, "string" == typeof n ? n.replace(jt, "") : null == n ? "" : n)
            }
        }
    }), lt.extend({
        valHooks: {
            option: {
                get: function (e) {
                    var t = e.attributes.value;
                    return !t || t.specified ? e.value : e.text
                }
            }, select: {
                get: function (e) {
                    for (var t, n, i = e.options, a = e.selectedIndex, o = "select-one" === e.type || 0 > a, r = o ? null : [], s = o ? a + 1 : i.length, l = 0 > a ? s : o ? a : 0; s > l; l++)if (n = i[l], !(!n.selected && l !== a || (lt.support.optDisabled ? n.disabled : null !== n.getAttribute("disabled")) || n.parentNode.disabled && lt.nodeName(n.parentNode, "optgroup"))) {
                        if (t = lt(n).val(), o)return t;
                        r.push(t)
                    }
                    return r
                }, set: function (e, t) {
                    var n = lt.makeArray(t);
                    return lt(e).find("option").each(function () {
                        this.selected = lt.inArray(lt(this).val(), n) >= 0
                    }), n.length || (e.selectedIndex = -1), n
                }
            }
        },
        attr: function (e, n, i) {
            var a, o, r, s = e.nodeType;
            if (e && 3 !== s && 8 !== s && 2 !== s)return typeof e.getAttribute === X ? lt.prop(e, n, i) : (o = 1 !== s || !lt.isXMLDoc(e), o && (n = n.toLowerCase(), a = lt.attrHooks[n] || (At.test(n) ? Et : St)), i === t ? a && o && "get"in a && null !== (r = a.get(e, n)) ? r : (typeof e.getAttribute !== X && (r = e.getAttribute(n)), null == r ? t : r) : null !== i ? a && o && "set"in a && (r = a.set(e, i, n)) !== t ? r : (e.setAttribute(n, i + ""), i) : (lt.removeAttr(e, n), t))
        },
        removeAttr: function (e, t) {
            var n, i, a = 0, o = t && t.match(ut);
            if (o && 1 === e.nodeType)for (; n = o[a++];)i = lt.propFix[n] || n, At.test(n) ? !Mt && Lt.test(n) ? e[lt.camelCase("default-" + n)] = e[i] = !1 : e[i] = !1 : lt.attr(e, n, ""), e.removeAttribute(Mt ? n : i)
        },
        attrHooks: {
            type: {
                set: function (e, t) {
                    if (!lt.support.radioValue && "radio" === t && lt.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        propFix: {
            tabindex: "tabIndex",
            readonly: "readOnly",
            "for": "htmlFor",
            "class": "className",
            maxlength: "maxLength",
            cellspacing: "cellSpacing",
            cellpadding: "cellPadding",
            rowspan: "rowSpan",
            colspan: "colSpan",
            usemap: "useMap",
            frameborder: "frameBorder",
            contenteditable: "contentEditable"
        },
        prop: function (e, n, i) {
            var a, o, r, s = e.nodeType;
            if (e && 3 !== s && 8 !== s && 2 !== s)return r = 1 !== s || !lt.isXMLDoc(e), r && (n = lt.propFix[n] || n, o = lt.propHooks[n]), i !== t ? o && "set"in o && (a = o.set(e, i, n)) !== t ? a : e[n] = i : o && "get"in o && null !== (a = o.get(e, n)) ? a : e[n]
        },
        propHooks: {
            tabIndex: {
                get: function (e) {
                    var n = e.getAttributeNode("tabindex");
                    return n && n.specified ? parseInt(n.value, 10) : Dt.test(e.nodeName) || It.test(e.nodeName) && e.href ? 0 : t
                }
            }
        }
    }), Et = {
        get: function (e, n) {
            var i = lt.prop(e, n), a = "boolean" == typeof i && e.getAttribute(n), o = "boolean" == typeof i ? Pt && Mt ? null != a : Lt.test(n) ? e[lt.camelCase("default-" + n)] : !!a : e.getAttributeNode(n);
            return o && o.value !== !1 ? n.toLowerCase() : t
        }, set: function (e, t, n) {
            return t === !1 ? lt.removeAttr(e, n) : Pt && Mt || !Lt.test(n) ? e.setAttribute(!Mt && lt.propFix[n] || n, n) : e[lt.camelCase("default-" + n)] = e[n] = !0, n
        }
    }, Pt && Mt || (lt.attrHooks.value = {
        get: function (e, n) {
            var i = e.getAttributeNode(n);
            return lt.nodeName(e, "input") ? e.defaultValue : i && i.specified ? i.value : t
        }, set: function (e, n, i) {
            return lt.nodeName(e, "input") ? (e.defaultValue = n, t) : St && St.set(e, n, i)
        }
    }), Mt || (St = lt.valHooks.button = {
        get: function (e, n) {
            var i = e.getAttributeNode(n);
            return i && ("id" === n || "name" === n || "coords" === n ? "" !== i.value : i.specified) ? i.value : t
        }, set: function (e, n, i) {
            var a = e.getAttributeNode(i);
            return a || e.setAttributeNode(a = e.ownerDocument.createAttribute(i)), a.value = n += "", "value" === i || n === e.getAttribute(i) ? n : t
        }
    }, lt.attrHooks.contenteditable = {
        get: St.get, set: function (e, t, n) {
            St.set(e, "" === t ? !1 : t, n)
        }
    }, lt.each(["width", "height"], function (e, n) {
        lt.attrHooks[n] = lt.extend(lt.attrHooks[n], {
            set: function (e, i) {
                return "" === i ? (e.setAttribute(n, "auto"), i) : t
            }
        })
    })), lt.support.hrefNormalized || (lt.each(["href", "src", "width", "height"], function (e, n) {
        lt.attrHooks[n] = lt.extend(lt.attrHooks[n], {
            get: function (e) {
                var i = e.getAttribute(n, 2);
                return null == i ? t : i
            }
        })
    }), lt.each(["href", "src"], function (e, t) {
        lt.propHooks[t] = {
            get: function (e) {
                return e.getAttribute(t, 4)
            }
        }
    })), lt.support.style || (lt.attrHooks.style = {
        get: function (e) {
            return e.style.cssText || t
        }, set: function (e, t) {
            return e.style.cssText = t + ""
        }
    }), lt.support.optSelected || (lt.propHooks.selected = lt.extend(lt.propHooks.selected, {
        get: function (e) {
            var t = e.parentNode;
            return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null
        }
    })), lt.support.enctype || (lt.propFix.enctype = "encoding"), lt.support.checkOn || lt.each(["radio", "checkbox"], function () {
        lt.valHooks[this] = {
            get: function (e) {
                return null === e.getAttribute("value") ? "on" : e.value
            }
        }
    }), lt.each(["radio", "checkbox"], function () {
        lt.valHooks[this] = lt.extend(lt.valHooks[this], {
            set: function (e, n) {
                return lt.isArray(n) ? e.checked = lt.inArray(lt(e).val(), n) >= 0 : t
            }
        })
    });
    var Rt = /^(?:input|select|textarea)$/i, Ot = /^key/, zt = /^(?:mouse|contextmenu)|click/, Ft = /^(?:focusinfocus|focusoutblur)$/, Ht = /^([^.]*)(?:\.(.+)|)$/;
    lt.event = {
        global: {},
        add: function (e, n, i, a, o) {
            var r, s, l, c, u, d, p, h, f, g, m, v = lt._data(e);
            if (v) {
                for (i.handler && (c = i, i = c.handler, o = c.selector), i.guid || (i.guid = lt.guid++), (s = v.events) || (s = v.events = {}), (d = v.handle) || (d = v.handle = function (e) {
                    return typeof lt === X || e && lt.event.triggered === e.type ? t : lt.event.dispatch.apply(d.elem, arguments)
                }, d.elem = e), n = (n || "").match(ut) || [""], l = n.length; l--;)r = Ht.exec(n[l]) || [], f = m = r[1], g = (r[2] || "").split(".").sort(), u = lt.event.special[f] || {}, f = (o ? u.delegateType : u.bindType) || f, u = lt.event.special[f] || {}, p = lt.extend({
                    type: f,
                    origType: m,
                    data: a,
                    handler: i,
                    guid: i.guid,
                    selector: o,
                    needsContext: o && lt.expr.match.needsContext.test(o),
                    namespace: g.join(".")
                }, c), (h = s[f]) || (h = s[f] = [], h.delegateCount = 0, u.setup && u.setup.call(e, a, g, d) !== !1 || (e.addEventListener ? e.addEventListener(f, d, !1) : e.attachEvent && e.attachEvent("on" + f, d))), u.add && (u.add.call(e, p), p.handler.guid || (p.handler.guid = i.guid)), o ? h.splice(h.delegateCount++, 0, p) : h.push(p), lt.event.global[f] = !0;
                e = null
            }
        },
        remove: function (e, t, n, i, a) {
            var o, r, s, l, c, u, d, p, h, f, g, m = lt.hasData(e) && lt._data(e);
            if (m && (u = m.events)) {
                for (t = (t || "").match(ut) || [""], c = t.length; c--;)if (s = Ht.exec(t[c]) || [], h = g = s[1], f = (s[2] || "").split(".").sort(), h) {
                    for (d = lt.event.special[h] || {}, h = (i ? d.delegateType : d.bindType) || h, p = u[h] || [], s = s[2] && RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), l = o = p.length; o--;)r = p[o], !a && g !== r.origType || n && n.guid !== r.guid || s && !s.test(r.namespace) || i && i !== r.selector && ("**" !== i || !r.selector) || (p.splice(o, 1), r.selector && p.delegateCount--, d.remove && d.remove.call(e, r));
                    l && !p.length && (d.teardown && d.teardown.call(e, f, m.handle) !== !1 || lt.removeEvent(e, h, m.handle), delete u[h])
                } else for (h in u)lt.event.remove(e, h + t[c], n, i, !0);
                lt.isEmptyObject(u) && (delete m.handle, lt._removeData(e, "events"))
            }
        },
        trigger: function (n, i, a, o) {
            var r, s, l, c, u, d, p, h = [a || Y], f = rt.call(n, "type") ? n.type : n, g = rt.call(n, "namespace") ? n.namespace.split(".") : [];
            if (l = d = a = a || Y, 3 !== a.nodeType && 8 !== a.nodeType && !Ft.test(f + lt.event.triggered) && (f.indexOf(".") >= 0 && (g = f.split("."), f = g.shift(), g.sort()), s = 0 > f.indexOf(":") && "on" + f, n = n[lt.expando] ? n : new lt.Event(f, "object" == typeof n && n), n.isTrigger = !0, n.namespace = g.join("."), n.namespace_re = n.namespace ? RegExp("(^|\\.)" + g.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, n.result = t, n.target || (n.target = a), i = null == i ? [n] : lt.makeArray(i, [n]), u = lt.event.special[f] || {}, o || !u.trigger || u.trigger.apply(a, i) !== !1)) {
                if (!o && !u.noBubble && !lt.isWindow(a)) {
                    for (c = u.delegateType || f, Ft.test(c + f) || (l = l.parentNode); l; l = l.parentNode)h.push(l), d = l;
                    d === (a.ownerDocument || Y) && h.push(d.defaultView || d.parentWindow || e)
                }
                for (p = 0; (l = h[p++]) && !n.isPropagationStopped();)n.type = p > 1 ? c : u.bindType || f, r = (lt._data(l, "events") || {})[n.type] && lt._data(l, "handle"), r && r.apply(l, i), r = s && l[s], r && lt.acceptData(l) && r.apply && r.apply(l, i) === !1 && n.preventDefault();
                if (n.type = f, !(o || n.isDefaultPrevented() || u._default && u._default.apply(a.ownerDocument, i) !== !1 || "click" === f && lt.nodeName(a, "a") || !lt.acceptData(a) || !s || !a[f] || lt.isWindow(a))) {
                    d = a[s], d && (a[s] = null), lt.event.triggered = f;
                    try {
                        a[f]()
                    } catch (m) {
                    }
                    lt.event.triggered = t, d && (a[s] = d)
                }
                return n.result
            }
        },
        dispatch: function (e) {
            e = lt.event.fix(e);
            var n, i, a, o, r, s = [], l = it.call(arguments), c = (lt._data(this, "events") || {})[e.type] || [], u = lt.event.special[e.type] || {};
            if (l[0] = e, e.delegateTarget = this, !u.preDispatch || u.preDispatch.call(this, e) !== !1) {
                for (s = lt.event.handlers.call(this, e, c), n = 0; (o = s[n++]) && !e.isPropagationStopped();)for (e.currentTarget = o.elem, r = 0; (a = o.handlers[r++]) && !e.isImmediatePropagationStopped();)(!e.namespace_re || e.namespace_re.test(a.namespace)) && (e.handleObj = a, e.data = a.data, i = ((lt.event.special[a.origType] || {}).handle || a.handler).apply(o.elem, l), i !== t && (e.result = i) === !1 && (e.preventDefault(), e.stopPropagation()));
                return u.postDispatch && u.postDispatch.call(this, e), e.result
            }
        },
        handlers: function (e, n) {
            var i, a, o, r, s = [], l = n.delegateCount, c = e.target;
            if (l && c.nodeType && (!e.button || "click" !== e.type))for (; c != this; c = c.parentNode || this)if (1 === c.nodeType && (c.disabled !== !0 || "click" !== e.type)) {
                for (o = [], r = 0; l > r; r++)a = n[r], i = a.selector + " ", o[i] === t && (o[i] = a.needsContext ? lt(i, this).index(c) >= 0 : lt.find(i, this, null, [c]).length), o[i] && o.push(a);
                o.length && s.push({elem: c, handlers: o})
            }
            return n.length > l && s.push({elem: this, handlers: n.slice(l)}), s
        },
        fix: function (e) {
            if (e[lt.expando])return e;
            var t, n, i, a = e.type, o = e, r = this.fixHooks[a];
            for (r || (this.fixHooks[a] = r = zt.test(a) ? this.mouseHooks : Ot.test(a) ? this.keyHooks : {}), i = r.props ? this.props.concat(r.props) : this.props, e = new lt.Event(o), t = i.length; t--;)n = i[t], e[n] = o[n];
            return e.target || (e.target = o.srcElement || Y), 3 === e.target.nodeType && (e.target = e.target.parentNode), e.metaKey = !!e.metaKey, r.filter ? r.filter(e, o) : e
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (e, n) {
                var i, a, o, r = n.button, s = n.fromElement;
                return null == e.pageX && null != n.clientX && (a = e.target.ownerDocument || Y, o = a.documentElement, i = a.body, e.pageX = n.clientX + (o && o.scrollLeft || i && i.scrollLeft || 0) - (o && o.clientLeft || i && i.clientLeft || 0), e.pageY = n.clientY + (o && o.scrollTop || i && i.scrollTop || 0) - (o && o.clientTop || i && i.clientTop || 0)), !e.relatedTarget && s && (e.relatedTarget = s === e.target ? n.toElement : s), e.which || r === t || (e.which = 1 & r ? 1 : 2 & r ? 3 : 4 & r ? 2 : 0), e
            }
        },
        special: {
            load: {noBubble: !0}, click: {
                trigger: function () {
                    return lt.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : t
                }
            }, focus: {
                trigger: function () {
                    if (this !== Y.activeElement && this.focus)try {
                        return this.focus(), !1
                    } catch (e) {
                    }
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === Y.activeElement && this.blur ? (this.blur(), !1) : t
                }, delegateType: "focusout"
            }, beforeunload: {
                postDispatch: function (e) {
                    e.result !== t && (e.originalEvent.returnValue = e.result)
                }
            }
        },
        simulate: function (e, t, n, i) {
            var a = lt.extend(new lt.Event, n, {type: e, isSimulated: !0, originalEvent: {}});
            i ? lt.event.trigger(a, null, t) : lt.event.dispatch.call(t, a), a.isDefaultPrevented() && n.preventDefault()
        }
    }, lt.removeEvent = Y.removeEventListener ? function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n, !1)
    } : function (e, t, n) {
        var i = "on" + t;
        e.detachEvent && (typeof e[i] === X && (e[i] = null), e.detachEvent(i, n))
    }, lt.Event = function (e, n) {
        return this instanceof lt.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || e.returnValue === !1 || e.getPreventDefault && e.getPreventDefault() ? l : c) : this.type = e, n && lt.extend(this, n), this.timeStamp = e && e.timeStamp || lt.now(), this[lt.expando] = !0, t) : new lt.Event(e, n)
    }, lt.Event.prototype = {
        isDefaultPrevented: c,
        isPropagationStopped: c,
        isImmediatePropagationStopped: c,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = l, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1)
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = l, e && (e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0)
        },
        stopImmediatePropagation: function () {
            this.isImmediatePropagationStopped = l, this.stopPropagation()
        }
    }, lt.each({mouseenter: "mouseover", mouseleave: "mouseout"}, function (e, t) {
        lt.event.special[e] = {
            delegateType: t, bindType: t, handle: function (e) {
                var n, i = this, a = e.relatedTarget, o = e.handleObj;
                return (!a || a !== i && !lt.contains(i, a)) && (e.type = o.origType, n = o.handler.apply(this, arguments), e.type = t), n
            }
        }
    }), lt.support.submitBubbles || (lt.event.special.submit = {
        setup: function () {
            return lt.nodeName(this, "form") ? !1 : (lt.event.add(this, "click._submit keypress._submit", function (e) {
                var n = e.target, i = lt.nodeName(n, "input") || lt.nodeName(n, "button") ? n.form : t;
                i && !lt._data(i, "submitBubbles") && (lt.event.add(i, "submit._submit", function (e) {
                    e._submit_bubble = !0
                }), lt._data(i, "submitBubbles", !0))
            }), t)
        }, postDispatch: function (e) {
            e._submit_bubble && (delete e._submit_bubble, this.parentNode && !e.isTrigger && lt.event.simulate("submit", this.parentNode, e, !0))
        }, teardown: function () {
            return lt.nodeName(this, "form") ? !1 : (lt.event.remove(this, "._submit"), t)
        }
    }), lt.support.changeBubbles || (lt.event.special.change = {
        setup: function () {
            return Rt.test(this.nodeName) ? (("checkbox" === this.type || "radio" === this.type) && (lt.event.add(this, "propertychange._change", function (e) {
                "checked" === e.originalEvent.propertyName && (this._just_changed = !0)
            }), lt.event.add(this, "click._change", function (e) {
                this._just_changed && !e.isTrigger && (this._just_changed = !1), lt.event.simulate("change", this, e, !0)
            })), !1) : (lt.event.add(this, "beforeactivate._change", function (e) {
                var t = e.target;
                Rt.test(t.nodeName) && !lt._data(t, "changeBubbles") && (lt.event.add(t, "change._change", function (e) {
                    !this.parentNode || e.isSimulated || e.isTrigger || lt.event.simulate("change", this.parentNode, e, !0)
                }), lt._data(t, "changeBubbles", !0))
            }), t)
        }, handle: function (e) {
            var n = e.target;
            return this !== n || e.isSimulated || e.isTrigger || "radio" !== n.type && "checkbox" !== n.type ? e.handleObj.handler.apply(this, arguments) : t
        }, teardown: function () {
            return lt.event.remove(this, "._change"), !Rt.test(this.nodeName)
        }
    }), lt.support.focusinBubbles || lt.each({focus: "focusin", blur: "focusout"}, function (e, t) {
        var n = 0, i = function (e) {
            lt.event.simulate(t, e.target, lt.event.fix(e), !0)
        };
        lt.event.special[t] = {
            setup: function () {
                0 === n++ && Y.addEventListener(e, i, !0)
            }, teardown: function () {
                0 === --n && Y.removeEventListener(e, i, !0)
            }
        }
    }), lt.fn.extend({
        on: function (e, n, i, a, o) {
            var r, s;
            if ("object" == typeof e) {
                "string" != typeof n && (i = i || n, n = t);
                for (r in e)this.on(r, n, i, e[r], o);
                return this
            }
            if (null == i && null == a ? (a = n, i = n = t) : null == a && ("string" == typeof n ? (a = i, i = t) : (a = i, i = n, n = t)), a === !1)a = c; else if (!a)return this;
            return 1 === o && (s = a, a = function (e) {
                return lt().off(e), s.apply(this, arguments)
            }, a.guid = s.guid || (s.guid = lt.guid++)), this.each(function () {
                lt.event.add(this, e, a, i, n)
            })
        }, one: function (e, t, n, i) {
            return this.on(e, t, n, i, 1)
        }, off: function (e, n, i) {
            var a, o;
            if (e && e.preventDefault && e.handleObj)return a = e.handleObj, lt(e.delegateTarget).off(a.namespace ? a.origType + "." + a.namespace : a.origType, a.selector, a.handler), this;
            if ("object" == typeof e) {
                for (o in e)this.off(o, n, e[o]);
                return this
            }
            return (n === !1 || "function" == typeof n) && (i = n, n = t), i === !1 && (i = c), this.each(function () {
                lt.event.remove(this, e, i, n)
            })
        }, bind: function (e, t, n) {
            return this.on(e, null, t, n)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, n, i) {
            return this.on(t, e, n, i)
        }, undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }, trigger: function (e, t) {
            return this.each(function () {
                lt.event.trigger(e, t, this)
            })
        }, triggerHandler: function (e, n) {
            var i = this[0];
            return i ? lt.event.trigger(e, n, i, !0) : t
        }
    }), function (e, t) {
        function n(e) {
            return ft.test(e + "")
        }

        function i() {
            var e, t = [];
            return e = function (n, i) {
                return t.push(n += " ") > T.cacheLength && delete e[t.shift()], e[n] = i
            }
        }

        function a(e) {
            return e[F] = !0, e
        }

        function o(e) {
            var t = I.createElement("div");
            try {
                return e(t)
            } catch (n) {
                return !1
            } finally {
                t = null
            }
        }

        function r(e, t, n, i) {
            var a, o, r, s, l, c, u, h, f, g;
            if ((t ? t.ownerDocument || t : H) !== I && D(t), t = t || I, n = n || [], !e || "string" != typeof e)return n;
            if (1 !== (s = t.nodeType) && 9 !== s)return [];
            if (!L && !i) {
                if (a = gt.exec(e))if (r = a[1]) {
                    if (9 === s) {
                        if (o = t.getElementById(r), !o || !o.parentNode)return n;
                        if (o.id === r)return n.push(o), n
                    } else if (t.ownerDocument && (o = t.ownerDocument.getElementById(r)) && O(t, o) && o.id === r)return n.push(o), n
                } else {
                    if (a[2])return Q.apply(n, J.call(t.getElementsByTagName(e), 0)), n;
                    if ((r = a[3]) && B.getByClassName && t.getElementsByClassName)return Q.apply(n, J.call(t.getElementsByClassName(r), 0)), n
                }
                if (B.qsa && !M.test(e)) {
                    if (u = !0, h = F, f = t, g = 9 === s && e, 1 === s && "object" !== t.nodeName.toLowerCase()) {
                        for (c = d(e), (u = t.getAttribute("id")) ? h = u.replace(yt, "\\$&") : t.setAttribute("id", h), h = "[id='" + h + "'] ", l = c.length; l--;)c[l] = h + p(c[l]);
                        f = ht.test(e) && t.parentNode || t, g = c.join(",")
                    }
                    if (g)try {
                        return Q.apply(n, J.call(f.querySelectorAll(g), 0)), n
                    } catch (m) {
                    } finally {
                        u || t.removeAttribute("id")
                    }
                }
            }
            return w(e.replace(rt, "$1"), t, n, i)
        }

        function s(e, t) {
            var n = t && e, i = n && (~t.sourceIndex || Y) - (~e.sourceIndex || Y);
            if (i)return i;
            if (n)for (; n = n.nextSibling;)if (n === t)return -1;
            return e ? 1 : -1
        }

        function l(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return "input" === n && t.type === e
            }
        }

        function c(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e
            }
        }

        function u(e) {
            return a(function (t) {
                return t = +t, a(function (n, i) {
                    for (var a, o = e([], n.length, t), r = o.length; r--;)n[a = o[r]] && (n[a] = !(i[a] = n[a]))
                })
            })
        }

        function d(e, t) {
            var n, i, a, o, s, l, c, u = q[e + " "];
            if (u)return t ? 0 : u.slice(0);
            for (s = e, l = [], c = T.preFilter; s;) {
                (!n || (i = st.exec(s))) && (i && (s = s.slice(i[0].length) || s), l.push(a = [])), n = !1, (i = ct.exec(s)) && (n = i.shift(), a.push({
                    value: n,
                    type: i[0].replace(rt, " ")
                }), s = s.slice(n.length));
                for (o in T.filter)!(i = pt[o].exec(s)) || c[o] && !(i = c[o](i)) || (n = i.shift(), a.push({
                    value: n,
                    type: o,
                    matches: i
                }), s = s.slice(n.length));
                if (!n)break
            }
            return t ? s.length : s ? r.error(e) : q(e, l).slice(0)
        }

        function p(e) {
            for (var t = 0, n = e.length, i = ""; n > t; t++)i += e[t].value;
            return i
        }

        function h(e, t, n) {
            var i = t.dir, a = n && "parentNode" === i, o = U++;
            return t.first ? function (t, n, o) {
                for (; t = t[i];)if (1 === t.nodeType || a)return e(t, n, o)
            } : function (t, n, r) {
                var s, l, c, u = W + " " + o;
                if (r) {
                    for (; t = t[i];)if ((1 === t.nodeType || a) && e(t, n, r))return !0
                } else for (; t = t[i];)if (1 === t.nodeType || a)if (c = t[F] || (t[F] = {}), (l = c[i]) && l[0] === u) {
                    if ((s = l[1]) === !0 || s === k)return s === !0
                } else if (l = c[i] = [u], l[1] = e(t, n, r) || k, l[1] === !0)return !0
            }
        }

        function f(e) {
            return e.length > 1 ? function (t, n, i) {
                for (var a = e.length; a--;)if (!e[a](t, n, i))return !1;
                return !0
            } : e[0]
        }

        function g(e, t, n, i, a) {
            for (var o, r = [], s = 0, l = e.length, c = null != t; l > s; s++)(o = e[s]) && (!n || n(o, i, a)) && (r.push(o), c && t.push(s));
            return r
        }

        function m(e, t, n, i, o, r) {
            return i && !i[F] && (i = m(i)), o && !o[F] && (o = m(o, r)), a(function (a, r, s, l) {
                var c, u, d, p = [], h = [], f = r.length, m = a || b(t || "*", s.nodeType ? [s] : s, []), v = !e || !a && t ? m : g(m, p, e, s, l), y = n ? o || (a ? e : f || i) ? [] : r : v;
                if (n && n(v, y, s, l), i)for (c = g(y, h), i(c, [], s, l), u = c.length; u--;)(d = c[u]) && (y[h[u]] = !(v[h[u]] = d));
                if (a) {
                    if (o || e) {
                        if (o) {
                            for (c = [], u = y.length; u--;)(d = y[u]) && c.push(v[u] = d);
                            o(null, y = [], c, l)
                        }
                        for (u = y.length; u--;)(d = y[u]) && (c = o ? Z.call(a, d) : p[u]) > -1 && (a[c] = !(r[c] = d))
                    }
                } else y = g(y === r ? y.splice(f, y.length) : y), o ? o(null, r, y, l) : Q.apply(r, y)
            })
        }

        function v(e) {
            for (var t, n, i, a = e.length, o = T.relative[e[0].type], r = o || T.relative[" "], s = o ? 1 : 0, l = h(function (e) {
                return e === t
            }, r, !0), c = h(function (e) {
                return Z.call(t, e) > -1
            }, r, !0), u = [function (e, n, i) {
                return !o && (i || n !== j) || ((t = n).nodeType ? l(e, n, i) : c(e, n, i))
            }]; a > s; s++)if (n = T.relative[e[s].type])u = [h(f(u), n)]; else {
                if (n = T.filter[e[s].type].apply(null, e[s].matches), n[F]) {
                    for (i = ++s; a > i && !T.relative[e[i].type]; i++);
                    return m(s > 1 && f(u), s > 1 && p(e.slice(0, s - 1)).replace(rt, "$1"), n, i > s && v(e.slice(s, i)), a > i && v(e = e.slice(i)), a > i && p(e))
                }
                u.push(n)
            }
            return f(u)
        }

        function y(e, t) {
            var n = 0, i = t.length > 0, o = e.length > 0, s = function (a, s, l, c, u) {
                var d, p, h, f = [], m = 0, v = "0", y = a && [], b = null != u, w = j, x = a || o && T.find.TAG("*", u && s.parentNode || s), _ = W += null == w ? 1 : Math.random() || .1;
                for (b && (j = s !== I && s, k = n); null != (d = x[v]); v++) {
                    if (o && d) {
                        for (p = 0; h = e[p++];)if (h(d, s, l)) {
                            c.push(d);
                            break
                        }
                        b && (W = _, k = ++n)
                    }
                    i && ((d = !h && d) && m--, a && y.push(d))
                }
                if (m += v, i && v !== m) {
                    for (p = 0; h = t[p++];)h(y, f, s, l);
                    if (a) {
                        if (m > 0)for (; v--;)y[v] || f[v] || (f[v] = K.call(c));
                        f = g(f)
                    }
                    Q.apply(c, f), b && !a && f.length > 0 && m + t.length > 1 && r.uniqueSort(c)
                }
                return b && (W = _, j = w), y
            };
            return i ? a(s) : s
        }

        function b(e, t, n) {
            for (var i = 0, a = t.length; a > i; i++)r(e, t[i], n);
            return n
        }

        function w(e, t, n, i) {
            var a, o, r, s, l, c = d(e);
            if (!i && 1 === c.length) {
                if (o = c[0] = c[0].slice(0), o.length > 2 && "ID" === (r = o[0]).type && 9 === t.nodeType && !L && T.relative[o[1].type]) {
                    if (t = T.find.ID(r.matches[0].replace(wt, xt), t)[0], !t)return n;
                    e = e.slice(o.shift().value.length)
                }
                for (a = pt.needsContext.test(e) ? 0 : o.length; a-- && (r = o[a], !T.relative[s = r.type]);)if ((l = T.find[s]) && (i = l(r.matches[0].replace(wt, xt), ht.test(o[0].type) && t.parentNode || t))) {
                    if (o.splice(a, 1), e = i.length && p(o), !e)return Q.apply(n, J.call(i, 0)), n;
                    break
                }
            }
            return E(e, c)(i, t, L, n, ht.test(e)), n
        }

        function x() {
        }

        var _, k, T, C, S, E, N, j, D, I, A, L, M, P, R, O, z, F = "sizzle" + -new Date, H = e.document, B = {}, W = 0, U = 0, $ = i(), q = i(), V = i(), X = typeof t, Y = 1 << 31, G = [], K = G.pop, Q = G.push, J = G.slice, Z = G.indexOf || function (e) {
                for (var t = 0, n = this.length; n > t; t++)if (this[t] === e)return t;
                return -1
            }, et = "[\\x20\\t\\r\\n\\f]", tt = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+", nt = tt.replace("w", "w#"), it = "([*^$|!~]?=)", at = "\\[" + et + "*(" + tt + ")" + et + "*(?:" + it + et + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + nt + ")|)|)" + et + "*\\]", ot = ":(" + tt + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + at.replace(3, 8) + ")*)|.*)\\)|)", rt = RegExp("^" + et + "+|((?:^|[^\\\\])(?:\\\\.)*)" + et + "+$", "g"), st = RegExp("^" + et + "*," + et + "*"), ct = RegExp("^" + et + "*([\\x20\\t\\r\\n\\f>+~])" + et + "*"), ut = RegExp(ot), dt = RegExp("^" + nt + "$"), pt = {
            ID: RegExp("^#(" + tt + ")"),
            CLASS: RegExp("^\\.(" + tt + ")"),
            NAME: RegExp("^\\[name=['\"]?(" + tt + ")['\"]?\\]"),
            TAG: RegExp("^(" + tt.replace("w", "w*") + ")"),
            ATTR: RegExp("^" + at),
            PSEUDO: RegExp("^" + ot),
            CHILD: RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + et + "*(even|odd|(([+-]|)(\\d*)n|)" + et + "*(?:([+-]|)" + et + "*(\\d+)|))" + et + "*\\)|)", "i"),
            needsContext: RegExp("^" + et + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + et + "*((?:-\\d)?\\d*)" + et + "*\\)|)(?=[^-]|$)", "i")
        }, ht = /[\x20\t\r\n\f]*[+~]/, ft = /^[^{]+\{\s*\[native code/, gt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, mt = /^(?:input|select|textarea|button)$/i, vt = /^h\d$/i, yt = /'|\\/g, bt = /\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g, wt = /\\([\da-fA-F]{1,6}[\x20\t\r\n\f]?|.)/g, xt = function (e, t) {
            var n = "0x" + t - 65536;
            return n !== n ? t : 0 > n ? String.fromCharCode(n + 65536) : String.fromCharCode(55296 | n >> 10, 56320 | 1023 & n)
        };
        try {
            J.call(H.documentElement.childNodes, 0)[0].nodeType
        } catch (_t) {
            J = function (e) {
                for (var t, n = []; t = this[e++];)n.push(t);
                return n
            }
        }
        S = r.isXML = function (e) {
            var t = e && (e.ownerDocument || e).documentElement;
            return t ? "HTML" !== t.nodeName : !1
        }, D = r.setDocument = function (e) {
            var i = e ? e.ownerDocument || e : H;
            return i !== I && 9 === i.nodeType && i.documentElement ? (I = i, A = i.documentElement, L = S(i), B.tagNameNoComments = o(function (e) {
                return e.appendChild(i.createComment("")), !e.getElementsByTagName("*").length
            }), B.attributes = o(function (e) {
                e.innerHTML = "<select></select>";
                var t = typeof e.lastChild.getAttribute("multiple");
                return "boolean" !== t && "string" !== t
            }), B.getByClassName = o(function (e) {
                return e.innerHTML = "<div class='hidden e'></div><div class='hidden'></div>", e.getElementsByClassName && e.getElementsByClassName("e").length ? (e.lastChild.className = "e", 2 === e.getElementsByClassName("e").length) : !1
            }), B.getByName = o(function (e) {
                e.id = F + 0, e.innerHTML = "<a name='" + F + "'></a><div name='" + F + "'></div>", A.insertBefore(e, A.firstChild);
                var t = i.getElementsByName && i.getElementsByName(F).length === 2 + i.getElementsByName(F + 0).length;
                return B.getIdNotName = !i.getElementById(F), A.removeChild(e), t
            }), T.attrHandle = o(function (e) {
                return e.innerHTML = "<a href='#'></a>", e.firstChild && typeof e.firstChild.getAttribute !== X && "#" === e.firstChild.getAttribute("href")
            }) ? {} : {
                href: function (e) {
                    return e.getAttribute("href", 2)
                }, type: function (e) {
                    return e.getAttribute("type")
                }
            }, B.getIdNotName ? (T.find.ID = function (e, t) {
                if (typeof t.getElementById !== X && !L) {
                    var n = t.getElementById(e);
                    return n && n.parentNode ? [n] : []
                }
            }, T.filter.ID = function (e) {
                var t = e.replace(wt, xt);
                return function (e) {
                    return e.getAttribute("id") === t
                }
            }) : (T.find.ID = function (e, n) {
                if (typeof n.getElementById !== X && !L) {
                    var i = n.getElementById(e);
                    return i ? i.id === e || typeof i.getAttributeNode !== X && i.getAttributeNode("id").value === e ? [i] : t : []
                }
            }, T.filter.ID = function (e) {
                var t = e.replace(wt, xt);
                return function (e) {
                    var n = typeof e.getAttributeNode !== X && e.getAttributeNode("id");
                    return n && n.value === t
                }
            }), T.find.TAG = B.tagNameNoComments ? function (e, n) {
                return typeof n.getElementsByTagName !== X ? n.getElementsByTagName(e) : t
            } : function (e, t) {
                var n, i = [], a = 0, o = t.getElementsByTagName(e);
                if ("*" === e) {
                    for (; n = o[a++];)1 === n.nodeType && i.push(n);
                    return i
                }
                return o
            }, T.find.NAME = B.getByName && function (e, n) {
                return typeof n.getElementsByName !== X ? n.getElementsByName(name) : t
            }, T.find.CLASS = B.getByClassName && function (e, n) {
                return typeof n.getElementsByClassName === X || L ? t : n.getElementsByClassName(e)
            }, P = [], M = [":focus"], (B.qsa = n(i.querySelectorAll)) && (o(function (e) {
                e.innerHTML = "<select><option selected=''></option></select>", e.querySelectorAll("[selected]").length || M.push("\\[" + et + "*(?:checked|disabled|ismap|multiple|readonly|selected|value)"), e.querySelectorAll(":checked").length || M.push(":checked")
            }), o(function (e) {
                e.innerHTML = "<input type='hidden' i=''/>", e.querySelectorAll("[i^='']").length && M.push("[*^$]=" + et + "*(?:\"\"|'')"), e.querySelectorAll(":enabled").length || M.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), M.push(",.*:")
            })), (B.matchesSelector = n(R = A.matchesSelector || A.mozMatchesSelector || A.webkitMatchesSelector || A.oMatchesSelector || A.msMatchesSelector)) && o(function (e) {
                B.disconnectedMatch = R.call(e, "div"), R.call(e, "[s!='']:x"), P.push("!=", ot)
            }), M = RegExp(M.join("|")), P = RegExp(P.join("|")), O = n(A.contains) || A.compareDocumentPosition ? function (e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, i = t && t.parentNode;
                return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
            } : function (e, t) {
                if (t)for (; t = t.parentNode;)if (t === e)return !0;
                return !1
            }, z = A.compareDocumentPosition ? function (e, t) {
                var n;
                return e === t ? (N = !0, 0) : (n = t.compareDocumentPosition && e.compareDocumentPosition && e.compareDocumentPosition(t)) ? 1 & n || e.parentNode && 11 === e.parentNode.nodeType ? e === i || O(H, e) ? -1 : t === i || O(H, t) ? 1 : 0 : 4 & n ? -1 : 1 : e.compareDocumentPosition ? -1 : 1
            } : function (e, t) {
                var n, a = 0, o = e.parentNode, r = t.parentNode, l = [e], c = [t];
                if (e === t)return N = !0, 0;
                if (!o || !r)return e === i ? -1 : t === i ? 1 : o ? -1 : r ? 1 : 0;
                if (o === r)return s(e, t);
                for (n = e; n = n.parentNode;)l.unshift(n);
                for (n = t; n = n.parentNode;)c.unshift(n);
                for (; l[a] === c[a];)a++;
                return a ? s(l[a], c[a]) : l[a] === H ? -1 : c[a] === H ? 1 : 0
            }, N = !1, [0, 0].sort(z), B.detectDuplicates = N, I) : I
        }, r.matches = function (e, t) {
            return r(e, null, null, t)
        }, r.matchesSelector = function (e, t) {
            if ((e.ownerDocument || e) !== I && D(e), t = t.replace(bt, "='$1']"), !(!B.matchesSelector || L || P && P.test(t) || M.test(t)))try {
                var n = R.call(e, t);
                if (n || B.disconnectedMatch || e.document && 11 !== e.document.nodeType)return n
            } catch (i) {
            }
            return r(t, I, null, [e]).length > 0
        }, r.contains = function (e, t) {
            return (e.ownerDocument || e) !== I && D(e), O(e, t)
        }, r.attr = function (e, t) {
            var n;
            return (e.ownerDocument || e) !== I && D(e), L || (t = t.toLowerCase()), (n = T.attrHandle[t]) ? n(e) : L || B.attributes ? e.getAttribute(t) : ((n = e.getAttributeNode(t)) || e.getAttribute(t)) && e[t] === !0 ? t : n && n.specified ? n.value : null
        }, r.error = function (e) {
            throw Error("Syntax error, unrecognized expression: " + e)
        }, r.uniqueSort = function (e) {
            var t, n = [], i = 1, a = 0;
            if (N = !B.detectDuplicates, e.sort(z), N) {
                for (; t = e[i]; i++)t === e[i - 1] && (a = n.push(i));
                for (; a--;)e.splice(n[a], 1)
            }
            return e
        }, C = r.getText = function (e) {
            var t, n = "", i = 0, a = e.nodeType;
            if (a) {
                if (1 === a || 9 === a || 11 === a) {
                    if ("string" == typeof e.textContent)return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling)n += C(e)
                } else if (3 === a || 4 === a)return e.nodeValue
            } else for (; t = e[i]; i++)n += C(t);
            return n
        }, T = r.selectors = {
            cacheLength: 50,
            createPseudo: a,
            match: pt,
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (e) {
                    return e[1] = e[1].replace(wt, xt), e[3] = (e[4] || e[5] || "").replace(wt, xt), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                }, CHILD: function (e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || r.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && r.error(e[0]), e
                }, PSEUDO: function (e) {
                    var t, n = !e[5] && e[2];
                    return pt.CHILD.test(e[0]) ? null : (e[4] ? e[2] = e[4] : n && ut.test(n) && (t = d(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                }
            },
            filter: {
                TAG: function (e) {
                    return "*" === e ? function () {
                        return !0
                    } : (e = e.replace(wt, xt).toLowerCase(), function (t) {
                        return t.nodeName && t.nodeName.toLowerCase() === e
                    })
                }, CLASS: function (e) {
                    var t = $[e + " "];
                    return t || (t = RegExp("(^|" + et + ")" + e + "(" + et + "|$)")) && $(e, function (e) {
                            return t.test(e.className || typeof e.getAttribute !== X && e.getAttribute("class") || "")
                        })
                }, ATTR: function (e, t, n) {
                    return function (i) {
                        var a = r.attr(i, e);
                        return null == a ? "!=" === t : t ? (a += "", "=" === t ? a === n : "!=" === t ? a !== n : "^=" === t ? n && 0 === a.indexOf(n) : "*=" === t ? n && a.indexOf(n) > -1 : "$=" === t ? n && a.slice(-n.length) === n : "~=" === t ? (" " + a + " ").indexOf(n) > -1 : "|=" === t ? a === n || a.slice(0, n.length + 1) === n + "-" : !1) : !0
                    }
                }, CHILD: function (e, t, n, i, a) {
                    var o = "nth" !== e.slice(0, 3), r = "last" !== e.slice(-4), s = "of-type" === t;
                    return 1 === i && 0 === a ? function (e) {
                        return !!e.parentNode
                    } : function (t, n, l) {
                        var c, u, d, p, h, f, g = o !== r ? "nextSibling" : "previousSibling", m = t.parentNode, v = s && t.nodeName.toLowerCase(), y = !l && !s;
                        if (m) {
                            if (o) {
                                for (; g;) {
                                    for (d = t; d = d[g];)if (s ? d.nodeName.toLowerCase() === v : 1 === d.nodeType)return !1;
                                    f = g = "only" === e && !f && "nextSibling"
                                }
                                return !0
                            }
                            if (f = [r ? m.firstChild : m.lastChild], r && y) {
                                for (u = m[F] || (m[F] = {}), c = u[e] || [], h = c[0] === W && c[1], p = c[0] === W && c[2], d = h && m.childNodes[h]; d = ++h && d && d[g] || (p = h = 0) || f.pop();)if (1 === d.nodeType && ++p && d === t) {
                                    u[e] = [W, h, p];
                                    break
                                }
                            } else if (y && (c = (t[F] || (t[F] = {}))[e]) && c[0] === W)p = c[1]; else for (; (d = ++h && d && d[g] || (p = h = 0) || f.pop()) && ((s ? d.nodeName.toLowerCase() !== v : 1 !== d.nodeType) || !++p || (y && ((d[F] || (d[F] = {}))[e] = [W, p]), d !== t)););
                            return p -= a, p === i || 0 === p % i && p / i >= 0
                        }
                    }
                }, PSEUDO: function (e, t) {
                    var n, i = T.pseudos[e] || T.setFilters[e.toLowerCase()] || r.error("unsupported pseudo: " + e);
                    return i[F] ? i(t) : i.length > 1 ? (n = [e, e, "", t], T.setFilters.hasOwnProperty(e.toLowerCase()) ? a(function (e, n) {
                        for (var a, o = i(e, t), r = o.length; r--;)a = Z.call(e, o[r]), e[a] = !(n[a] = o[r])
                    }) : function (e) {
                        return i(e, 0, n)
                    }) : i
                }
            },
            pseudos: {
                not: a(function (e) {
                    var t = [], n = [], i = E(e.replace(rt, "$1"));
                    return i[F] ? a(function (e, t, n, a) {
                        for (var o, r = i(e, null, a, []), s = e.length; s--;)(o = r[s]) && (e[s] = !(t[s] = o))
                    }) : function (e, a, o) {
                        return t[0] = e, i(t, null, o, n), !n.pop()
                    }
                }), has: a(function (e) {
                    return function (t) {
                        return r(e, t).length > 0
                    }
                }), contains: a(function (e) {
                    return function (t) {
                        return (t.textContent || t.innerText || C(t)).indexOf(e) > -1
                    }
                }), lang: a(function (e) {
                    return dt.test(e || "") || r.error("unsupported lang: " + e), e = e.replace(wt, xt).toLowerCase(), function (t) {
                        var n;
                        do if (n = L ? t.getAttribute("xml:lang") || t.getAttribute("lang") : t.lang)return n = n.toLowerCase(), n === e || 0 === n.indexOf(e + "-"); while ((t = t.parentNode) && 1 === t.nodeType);
                        return !1
                    }
                }), target: function (t) {
                    var n = e.location && e.location.hash;
                    return n && n.slice(1) === t.id
                }, root: function (e) {
                    return e === A
                }, focus: function (e) {
                    return e === I.activeElement && (!I.hasFocus || I.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                }, enabled: function (e) {
                    return e.disabled === !1
                }, disabled: function (e) {
                    return e.disabled === !0
                }, checked: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected
                }, selected: function (e) {
                    return e.parentNode && e.parentNode.selectedIndex, e.selected === !0
                }, empty: function (e) {
                    for (e = e.firstChild; e; e = e.nextSibling)if (e.nodeName > "@" || 3 === e.nodeType || 4 === e.nodeType)return !1;
                    return !0
                }, parent: function (e) {
                    return !T.pseudos.empty(e)
                }, header: function (e) {
                    return vt.test(e.nodeName)
                }, input: function (e) {
                    return mt.test(e.nodeName)
                }, button: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t
                }, text: function (e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || t.toLowerCase() === e.type)
                }, first: u(function () {
                    return [0]
                }), last: u(function (e, t) {
                    return [t - 1]
                }), eq: u(function (e, t, n) {
                    return [0 > n ? n + t : n]
                }), even: u(function (e, t) {
                    for (var n = 0; t > n; n += 2)e.push(n);
                    return e
                }), odd: u(function (e, t) {
                    for (var n = 1; t > n; n += 2)e.push(n);
                    return e
                }), lt: u(function (e, t, n) {
                    for (var i = 0 > n ? n + t : n; --i >= 0;)e.push(i);
                    return e
                }), gt: u(function (e, t, n) {
                    for (var i = 0 > n ? n + t : n; t > ++i;)e.push(i);
                    return e
                })
            }
        };
        for (_ in{radio: !0, checkbox: !0, file: !0, password: !0, image: !0})T.pseudos[_] = l(_);
        for (_ in{submit: !0, reset: !0})T.pseudos[_] = c(_);
        E = r.compile = function (e, t) {
            var n, i = [], a = [], o = V[e + " "];
            if (!o) {
                for (t || (t = d(e)), n = t.length; n--;)o = v(t[n]), o[F] ? i.push(o) : a.push(o);
                o = V(e, y(a, i))
            }
            return o
        }, T.pseudos.nth = T.pseudos.eq, T.filters = x.prototype = T.pseudos, T.setFilters = new x, D(), r.attr = lt.attr, lt.find = r, lt.expr = r.selectors, lt.expr[":"] = lt.expr.pseudos, lt.unique = r.uniqueSort, lt.text = r.getText, lt.isXMLDoc = r.isXML, lt.contains = r.contains
    }(e);
    var Bt = /Until$/, Wt = /^(?:parents|prev(?:Until|All))/, Ut = /^.[^:#\[\.,]*$/, $t = lt.expr.match.needsContext, qt = {
        children: !0,
        contents: !0,
        next: !0,
        prev: !0
    };
    lt.fn.extend({
        find: function (e) {
            var t, n, i, a = this.length;
            if ("string" != typeof e)return i = this, this.pushStack(lt(e).filter(function () {
                for (t = 0; a > t; t++)if (lt.contains(i[t], this))return !0
            }));
            for (n = [], t = 0; a > t; t++)lt.find(e, this[t], n);
            return n = this.pushStack(a > 1 ? lt.unique(n) : n), n.selector = (this.selector ? this.selector + " " : "") + e, n
        }, has: function (e) {
            var t, n = lt(e, this), i = n.length;
            return this.filter(function () {
                for (t = 0; i > t; t++)if (lt.contains(this, n[t]))return !0
            })
        }, not: function (e) {
            return this.pushStack(d(this, e, !1))
        }, filter: function (e) {
            return this.pushStack(d(this, e, !0))
        }, is: function (e) {
            return !!e && ("string" == typeof e ? $t.test(e) ? lt(e, this.context).index(this[0]) >= 0 : lt.filter(e, this).length > 0 : this.filter(e).length > 0)
        }, closest: function (e, t) {
            for (var n, i = 0, a = this.length, o = [], r = $t.test(e) || "string" != typeof e ? lt(e, t || this.context) : 0; a > i; i++)for (n = this[i]; n && n.ownerDocument && n !== t && 11 !== n.nodeType;) {
                if (r ? r.index(n) > -1 : lt.find.matchesSelector(n, e)) {
                    o.push(n);
                    break
                }
                n = n.parentNode
            }
            return this.pushStack(o.length > 1 ? lt.unique(o) : o)
        }, index: function (e) {
            return e ? "string" == typeof e ? lt.inArray(this[0], lt(e)) : lt.inArray(e.jquery ? e[0] : e, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            var n = "string" == typeof e ? lt(e, t) : lt.makeArray(e && e.nodeType ? [e] : e), i = lt.merge(this.get(), n);
            return this.pushStack(lt.unique(i))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), lt.fn.andSelf = lt.fn.addBack, lt.each({
        parent: function (e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        }, parents: function (e) {
            return lt.dir(e, "parentNode")
        }, parentsUntil: function (e, t, n) {
            return lt.dir(e, "parentNode", n)
        }, next: function (e) {
            return u(e, "nextSibling")
        }, prev: function (e) {
            return u(e, "previousSibling")
        }, nextAll: function (e) {
            return lt.dir(e, "nextSibling")
        }, prevAll: function (e) {
            return lt.dir(e, "previousSibling")
        }, nextUntil: function (e, t, n) {
            return lt.dir(e, "nextSibling", n)
        }, prevUntil: function (e, t, n) {
            return lt.dir(e, "previousSibling", n)
        }, siblings: function (e) {
            return lt.sibling((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return lt.sibling(e.firstChild)
        }, contents: function (e) {
            return lt.nodeName(e, "fe") ? e.contentDocument || e.contentWindow.document : lt.merge([], e.childNodes)
        }
    }, function (e, t) {
        lt.fn[e] = function (n, i) {
            var a = lt.map(this, t, n);
            return Bt.test(e) || (i = n), i && "string" == typeof i && (a = lt.filter(i, a)), a = this.length > 1 && !qt[e] ? lt.unique(a) : a, this.length > 1 && Wt.test(e) && (a = a.reverse()), this.pushStack(a)
        }
    }), lt.extend({
        filter: function (e, t, n) {
            return n && (e = ":not(" + e + ")"), 1 === t.length ? lt.find.matchesSelector(t[0], e) ? [t[0]] : [] : lt.find.matches(e, t)
        }, dir: function (e, n, i) {
            for (var a = [], o = e[n]; o && 9 !== o.nodeType && (i === t || 1 !== o.nodeType || !lt(o).is(i));)1 === o.nodeType && a.push(o), o = o[n];
            return a
        }, sibling: function (e, t) {
            for (var n = []; e; e = e.nextSibling)1 === e.nodeType && e !== t && n.push(e);
            return n
        }
    });
    var Vt = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video", Xt = / jQuery\d+="(?:null|\d+)"/g, Yt = RegExp("<(?:" + Vt + ")[\\s/>]", "i"), Gt = /^\s+/, Kt = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi, Qt = /<([\w:]+)/, Jt = /<tbody/i, Zt = /<|&#?\w+;/, en = /<(?:script|style|link)/i, tn = /^(?:checkbox|radio)$/i, nn = /checked\s*(?:[^=]|=\s*.checked.)/i, an = /^$|\/(?:java|ecma)script/i, on = /^true\/(.*)/, rn = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g, sn = {
        option: [1, "<select multiple='multiple'>", "</select>"],
        legend: [1, "<fieldset>", "</fieldset>"],
        area: [1, "<map>", "</map>"],
        param: [1, "<object>", "</object>"],
        thead: [1, "<table>", "</table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: lt.support.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
    }, ln = p(Y), cn = ln.appendChild(Y.createElement("div"));
    sn.optgroup = sn.option, sn.tbody = sn.tfoot = sn.colgroup = sn.caption = sn.thead, sn.th = sn.td, lt.fn.extend({
        text: function (e) {
            return lt.access(this, function (e) {
                return e === t ? lt.text(this) : this.empty().append((this[0] && this[0].ownerDocument || Y).createTextNode(e))
            }, null, e, arguments.length)
        }, wrapAll: function (e) {
            if (lt.isFunction(e))return this.each(function (t) {
                lt(this).wrapAll(e.call(this, t))
            });
            if (this[0]) {
                var t = lt(e, this[0].ownerDocument).eq(0).clone(!0);
                this[0].parentNode && t.insertBefore(this[0]), t.map(function () {
                    for (var e = this; e.firstChild && 1 === e.firstChild.nodeType;)e = e.firstChild;
                    return e
                }).append(this)
            }
            return this
        }, wrapInner: function (e) {
            return lt.isFunction(e) ? this.each(function (t) {
                lt(this).wrapInner(e.call(this, t))
            }) : this.each(function () {
                var t = lt(this), n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            })
        }, wrap: function (e) {
            var t = lt.isFunction(e);
            return this.each(function (n) {
                lt(this).wrapAll(t ? e.call(this, n) : e)
            })
        }, unwrap: function () {
            return this.parent().each(function () {
                lt.nodeName(this, "body") || lt(this).replaceWith(this.childNodes)
            }).end()
        }, append: function () {
            return this.domManip(arguments, !0, function (e) {
                (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && this.appendChild(e)
            })
        }, prepend: function () {
            return this.domManip(arguments, !0, function (e) {
                (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && this.insertBefore(e, this.firstChild)
            })
        }, before: function () {
            return this.domManip(arguments, !1, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        }, after: function () {
            return this.domManip(arguments, !1, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        }, remove: function (e, t) {
            for (var n, i = 0; null != (n = this[i]); i++)(!e || lt.filter(e, [n]).length > 0) && (t || 1 !== n.nodeType || lt.cleanData(b(n)), n.parentNode && (t && lt.contains(n.ownerDocument, n) && m(b(n, "script")), n.parentNode.removeChild(n)));
            return this
        }, empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) {
                for (1 === e.nodeType && lt.cleanData(b(e, !1)); e.firstChild;)e.removeChild(e.firstChild);
                e.options && lt.nodeName(e, "select") && (e.options.length = 0)
            }
            return this
        }, clone: function (e, t) {
            return e = null == e ? !1 : e, t = null == t ? e : t, this.map(function () {
                return lt.clone(this, e, t)
            })
        }, html: function (e) {
            return lt.access(this, function (e) {
                var n = this[0] || {}, i = 0, a = this.length;
                if (e === t)return 1 === n.nodeType ? n.innerHTML.replace(Xt, "") : t;
                if (!("string" != typeof e || en.test(e) || !lt.support.htmlSerialize && Yt.test(e) || !lt.support.leadingWhitespace && Gt.test(e) || sn[(Qt.exec(e) || ["", ""])[1].toLowerCase()])) {
                    e = e.replace(Kt, "<$1></$2>");
                    try {
                        for (; a > i; i++)n = this[i] || {}, 1 === n.nodeType && (lt.cleanData(b(n, !1)), n.innerHTML = e);
                        n = 0
                    } catch (o) {
                    }
                }
                n && this.empty().append(e)
            }, null, e, arguments.length)
        }, replaceWith: function (e) {
            var t = lt.isFunction(e);
            return t || "string" == typeof e || (e = lt(e).not(this).detach()), this.domManip([e], !0, function (e) {
                var t = this.nextSibling, n = this.parentNode;
                n && (lt(this).remove(), n.insertBefore(e, t))
            })
        }, detach: function (e) {
            return this.remove(e, !0)
        }, domManip: function (e, n, i) {
            e = tt.apply([], e);
            var a, o, r, s, l, c, u = 0, d = this.length, p = this, m = d - 1, v = e[0], y = lt.isFunction(v);
            if (y || !(1 >= d || "string" != typeof v || lt.support.checkClone) && nn.test(v))return this.each(function (a) {
                var o = p.eq(a);
                y && (e[0] = v.call(this, a, n ? o.html() : t)), o.domManip(e, n, i)
            });
            if (d && (c = lt.buildFragment(e, this[0].ownerDocument, !1, this), a = c.firstChild, 1 === c.childNodes.length && (c = a), a)) {
                for (n = n && lt.nodeName(a, "tr"), s = lt.map(b(c, "script"), f), r = s.length; d > u; u++)o = c, u !== m && (o = lt.clone(o, !0, !0), r && lt.merge(s, b(o, "script"))), i.call(n && lt.nodeName(this[u], "table") ? h(this[u], "tbody") : this[u], o, u);
                if (r)for (l = s[s.length - 1].ownerDocument, lt.map(s, g), u = 0; r > u; u++)o = s[u], an.test(o.type || "") && !lt._data(o, "globalEval") && lt.contains(l, o) && (o.src ? lt.ajax({
                    url: o.src,
                    type: "GET",
                    dataType: "script",
                    async: !1,
                    global: !1,
                    "throws": !0
                }) : lt.globalEval((o.text || o.textContent || o.innerHTML || "").replace(rn, "")));
                c = a = null
            }
            return this
        }
    }), lt.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, t) {
        lt.fn[e] = function (e) {
            for (var n, i = 0, a = [], o = lt(e), r = o.length - 1; r >= i; i++)n = i === r ? this : this.clone(!0), lt(o[i])[t](n), nt.apply(a, n.get());
            return this.pushStack(a)
        }
    }), lt.extend({
        clone: function (e, t, n) {
            var i, a, o, r, s, l = lt.contains(e.ownerDocument, e);
            if (lt.support.html5Clone || lt.isXMLDoc(e) || !Yt.test("<" + e.nodeName + ">") ? o = e.cloneNode(!0) : (cn.innerHTML = e.outerHTML, cn.removeChild(o = cn.firstChild)), !(lt.support.noCloneEvent && lt.support.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || lt.isXMLDoc(e)))for (i = b(o), s = b(e), r = 0; null != (a = s[r]); ++r)i[r] && y(a, i[r]);
            if (t)if (n)for (s = s || b(e), i = i || b(o), r = 0; null != (a = s[r]); r++)v(a, i[r]); else v(e, o);
            return i = b(o, "script"), i.length > 0 && m(i, !l && b(e, "script")), i = s = a = null, o
        }, buildFragment: function (e, t, n, i) {
            for (var a, o, r, s, l, c, u, d = e.length, h = p(t), f = [], g = 0; d > g; g++)if (o = e[g], o || 0 === o)if ("object" === lt.type(o))lt.merge(f, o.nodeType ? [o] : o); else if (Zt.test(o)) {
                for (s = s || h.appendChild(t.createElement("div")), l = (Qt.exec(o) || ["", ""])[1].toLowerCase(), u = sn[l] || sn._default, s.innerHTML = u[1] + o.replace(Kt, "<$1></$2>") + u[2], a = u[0]; a--;)s = s.lastChild;
                if (!lt.support.leadingWhitespace && Gt.test(o) && f.push(t.createTextNode(Gt.exec(o)[0])), !lt.support.tbody)for (o = "table" !== l || Jt.test(o) ? "<table>" !== u[1] || Jt.test(o) ? 0 : s : s.firstChild, a = o && o.childNodes.length; a--;)lt.nodeName(c = o.childNodes[a], "tbody") && !c.childNodes.length && o.removeChild(c);
                for (lt.merge(f, s.childNodes), s.textContent = ""; s.firstChild;)s.removeChild(s.firstChild);
                s = h.lastChild
            } else f.push(t.createTextNode(o));
            for (s && h.removeChild(s), lt.support.appendChecked || lt.grep(b(f, "input"), w), g = 0; o = f[g++];)if ((!i || -1 === lt.inArray(o, i)) && (r = lt.contains(o.ownerDocument, o), s = b(h.appendChild(o), "script"), r && m(s), n))for (a = 0; o = s[a++];)an.test(o.type || "") && n.push(o);
            return s = null, h
        }, cleanData: function (e, t) {
            for (var n, i, a, o, r = 0, s = lt.expando, l = lt.cache, c = lt.support.deleteExpando, u = lt.event.special; null != (n = e[r]); r++)if ((t || lt.acceptData(n)) && (a = n[s], o = a && l[a])) {
                if (o.events)for (i in o.events)u[i] ? lt.event.remove(n, i) : lt.removeEvent(n, i, o.handle);
                l[a] && (delete l[a], c ? delete n[s] : typeof n.removeAttribute !== X ? n.removeAttribute(s) : n[s] = null, Z.push(a))
            }
        }
    });
    var un, dn, pn, hn = /alpha\([^)]*\)/i, fn = /opacity\s*=\s*([^)]*)/, gn = /^(top|right|bottom|left)$/, mn = /^(none|table(?!-c[ea]).+)/, vn = /^margin/, yn = RegExp("^(" + ct + ")(.*)$", "i"), bn = RegExp("^(" + ct + ")(?!px)[a-z%]+$", "i"), wn = RegExp("^([+-])=(" + ct + ")", "i"), xn = {BODY: "block"}, _n = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
    }, kn = {
        letterSpacing: 0,
        fontWeight: 400
    }, Tn = ["Top", "Right", "Bottom", "Left"], Cn = ["Webkit", "O", "Moz", "ms"];
    lt.fn.extend({
        css: function (e, n) {
            return lt.access(this, function (e, n, i) {
                var a, o, r = {}, s = 0;
                if (lt.isArray(n)) {
                    for (o = dn(e), a = n.length; a > s; s++)r[n[s]] = lt.css(e, n[s], !1, o);
                    return r
                }
                return i !== t ? lt.style(e, n, i) : lt.css(e, n)
            }, e, n, arguments.length > 1)
        }, show: function () {
            return k(this, !0)
        }, hide: function () {
            return k(this)
        }, toggle: function (e) {
            var t = "boolean" == typeof e;
            return this.each(function () {
                (t ? e : _(this)) ? lt(this).show() : lt(this).hide()
            })
        }
    }), lt.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = pn(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            columnCount: !0,
            fillOpacity: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {"float": lt.support.cssFloat ? "cssFloat" : "styleFloat"},
        style: function (e, n, i, a) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var o, r, s, l = lt.camelCase(n), c = e.style;
                if (n = lt.cssProps[l] || (lt.cssProps[l] = x(c, l)), s = lt.cssHooks[n] || lt.cssHooks[l], i === t)return s && "get"in s && (o = s.get(e, !1, a)) !== t ? o : c[n];
                if (r = typeof i, "string" === r && (o = wn.exec(i)) && (i = (o[1] + 1) * o[2] + parseFloat(lt.css(e, n)), r = "number"), !(null == i || "number" === r && isNaN(i) || ("number" !== r || lt.cssNumber[l] || (i += "px"), lt.support.clearCloneStyle || "" !== i || 0 !== n.indexOf("background") || (c[n] = "inherit"), s && "set"in s && (i = s.set(e, i, a)) === t)))try {
                    c[n] = i
                } catch (u) {
                }
            }
        },
        css: function (e, n, i, a) {
            var o, r, s, l = lt.camelCase(n);
            return n = lt.cssProps[l] || (lt.cssProps[l] = x(e.style, l)), s = lt.cssHooks[n] || lt.cssHooks[l], s && "get"in s && (r = s.get(e, !0, i)), r === t && (r = pn(e, n, a)), "normal" === r && n in kn && (r = kn[n]), "" === i || i ? (o = parseFloat(r), i === !0 || lt.isNumeric(o) ? o || 0 : r) : r
        },
        swap: function (e, t, n, i) {
            var a, o, r = {};
            for (o in t)r[o] = e.style[o], e.style[o] = t[o];
            a = n.apply(e, i || []);
            for (o in t)e.style[o] = r[o];
            return a
        }
    }), e.getComputedStyle ? (dn = function (t) {
        return e.getComputedStyle(t, null)
    }, pn = function (e, n, i) {
        var a, o, r, s = i || dn(e), l = s ? s.getPropertyValue(n) || s[n] : t, c = e.style;
        return s && ("" !== l || lt.contains(e.ownerDocument, e) || (l = lt.style(e, n)), bn.test(l) && vn.test(n) && (a = c.width, o = c.minWidth, r = c.maxWidth, c.minWidth = c.maxWidth = c.width = l, l = s.width, c.width = a, c.minWidth = o, c.maxWidth = r)), l
    }) : Y.documentElement.currentStyle && (dn = function (e) {
        return e.currentStyle
    }, pn = function (e, n, i) {
        var a, o, r, s = i || dn(e), l = s ? s[n] : t, c = e.style;
        return null == l && c && c[n] && (l = c[n]), bn.test(l) && !gn.test(n) && (a = c.left, o = e.runtimeStyle, r = o && o.left, r && (o.left = e.currentStyle.left), c.left = "fontSize" === n ? "1em" : l, l = c.pixelLeft + "px", c.left = a, r && (o.left = r)), "" === l ? "auto" : l
    }), lt.each(["height", "width"], function (e, n) {
        lt.cssHooks[n] = {
            get: function (e, i, a) {
                return i ? 0 === e.offsetWidth && mn.test(lt.css(e, "display")) ? lt.swap(e, _n, function () {
                    return S(e, n, a)
                }) : S(e, n, a) : t
            }, set: function (e, t, i) {
                var a = i && dn(e);
                return T(e, t, i ? C(e, n, i, lt.support.boxSizing && "border-box" === lt.css(e, "boxSizing", !1, a), a) : 0)
            }
        }
    }), lt.support.opacity || (lt.cssHooks.opacity = {
        get: function (e, t) {
            return fn.test((t && e.currentStyle ? e.currentStyle.filter : e.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : ""
        }, set: function (e, t) {
            var n = e.style, i = e.currentStyle, a = lt.isNumeric(t) ? "alpha(opacity=" + 100 * t + ")" : "", o = i && i.filter || n.filter || "";
            n.zoom = 1, (t >= 1 || "" === t) && "" === lt.trim(o.replace(hn, "")) && n.removeAttribute && (n.removeAttribute("filter"), "" === t || i && !i.filter) || (n.filter = hn.test(o) ? o.replace(hn, a) : o + " " + a)
        }
    }), lt(function () {
        lt.support.reliableMarginRight || (lt.cssHooks.marginRight = {
            get: function (e, n) {
                return n ? lt.swap(e, {display: "inline-block"}, pn, [e, "marginRight"]) : t
            }
        }), !lt.support.pixelPosition && lt.fn.position && lt.each(["top", "left"], function (e, n) {
            lt.cssHooks[n] = {
                get: function (e, i) {
                    return i ? (i = pn(e, n), bn.test(i) ? lt(e).position()[n] + "px" : i) : t
                }
            }
        })
    }), lt.expr && lt.expr.filters && (lt.expr.filters.hidden = function (e) {
        return 0 >= e.offsetWidth && 0 >= e.offsetHeight || !lt.support.reliableHiddenOffsets && "none" === (e.style && e.style.display || lt.css(e, "display"))
    }, lt.expr.filters.visible = function (e) {
        return !lt.expr.filters.hidden(e)
    }), lt.each({margin: "", padding: "", border: "Width"}, function (e, t) {
        lt.cssHooks[e + t] = {
            expand: function (n) {
                for (var i = 0, a = {}, o = "string" == typeof n ? n.split(" ") : [n]; 4 > i; i++)a[e + Tn[i] + t] = o[i] || o[i - 2] || o[0];
                return a
            }
        }, vn.test(e) || (lt.cssHooks[e + t].set = T)
    });
    var Sn = /%20/g, En = /\[\]$/, Nn = /\r?\n/g, jn = /^(?:submit|button|image|reset|file)$/i, Dn = /^(?:input|select|textarea|keygen)/i;
    lt.fn.extend({
        serialize: function () {
            return lt.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var e = lt.prop(this, "elements");
                return e ? lt.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !lt(this).is(":disabled") && Dn.test(this.nodeName) && !jn.test(e) && (this.checked || !tn.test(e))
            }).map(function (e, t) {
                var n = lt(this).val();
                return null == n ? null : lt.isArray(n) ? lt.map(n, function (e) {
                    return {name: t.name, value: e.replace(Nn, "\r\n")}
                }) : {name: t.name, value: n.replace(Nn, "\r\n")}
            }).get()
        }
    }), lt.param = function (e, n) {
        var i, a = [], o = function (e, t) {
            t = lt.isFunction(t) ? t() : null == t ? "" : t, a[a.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
        };
        if (n === t && (n = lt.ajaxSettings && lt.ajaxSettings.traditional), lt.isArray(e) || e.jquery && !lt.isPlainObject(e))lt.each(e, function () {
            o(this.name, this.value)
        }); else for (i in e)j(i, e[i], n, o);
        return a.join("&").replace(Sn, "+")
    }, lt.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (e, t) {
        lt.fn[t] = function (e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }), lt.fn.hover = function (e, t) {
        return this.mouseenter(e).mouseleave(t || e)
    };
    var In, An, Ln = lt.now(), Mn = /\?/, Pn = /#.*$/, Rn = /([?&])_=[^&]*/, On = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm, zn = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, Fn = /^(?:GET|HEAD)$/, Hn = /^\/\//, Bn = /^([\w.+-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/, Wn = lt.fn.load, Un = {}, $n = {}, qn = "*/".concat("*");
    try {
        An = G.href
    } catch (Vn) {
        An = Y.createElement("a"), An.href = "", An = An.href
    }
    In = Bn.exec(An.toLowerCase()) || [], lt.fn.load = function (e, n, i) {
        if ("string" != typeof e && Wn)return Wn.apply(this, arguments);
        var a, o, r, s = this, l = e.indexOf(" ");
        return l >= 0 && (a = e.slice(l, e.length), e = e.slice(0, l)), lt.isFunction(n) ? (i = n, n = t) : n && "object" == typeof n && (r = "POST"), s.length > 0 && lt.ajax({
            url: e,
            type: r,
            dataType: "html",
            data: n
        }).done(function (e) {
            o = arguments, s.html(a ? lt("<div>").append(lt.parseHTML(e)).find(a) : e)
        }).complete(i && function (e, t) {
            s.each(i, o || [e.responseText, t, e])
        }), this
    }, lt.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        lt.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), lt.each(["get", "post"], function (e, n) {
        lt[n] = function (e, i, a, o) {
            return lt.isFunction(i) && (o = o || a, a = i, i = t), lt.ajax({
                url: e,
                type: n,
                dataType: o,
                data: i,
                success: a
            })
        }
    }), lt.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: An,
            type: "GET",
            isLocal: zn.test(In[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": qn,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /xml/, html: /html/, json: /json/},
            responseFields: {xml: "responseXML", text: "responseText"},
            converters: {"* text": e.String, "text html": !0, "text json": lt.parseJSON, "text xml": lt.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? A(A(e, lt.ajaxSettings), t) : A(lt.ajaxSettings, e)
        },
        ajaxPrefilter: D(Un),
        ajaxTransport: D($n),
        ajax: function (e, n) {
            function i(e, n, i, a) {
                var o, d, y, b, x, k = n;
                2 !== w && (w = 2, l && clearTimeout(l), u = t, s = a || "", _.readyState = e > 0 ? 4 : 0, i && (b = L(p, _, i)), e >= 200 && 300 > e || 304 === e ? (p.ifModified && (x = _.getResponseHeader("Last-Modified"), x && (lt.lastModified[r] = x), x = _.getResponseHeader("etag"), x && (lt.etag[r] = x)), 204 === e ? (o = !0, k = "nocontent") : 304 === e ? (o = !0, k = "notmodified") : (o = M(p, b), k = o.state, d = o.data, y = o.error, o = !y)) : (y = k, (e || !k) && (k = "error", 0 > e && (e = 0))), _.status = e, _.statusText = (n || k) + "", o ? g.resolveWith(h, [d, k, _]) : g.rejectWith(h, [_, k, y]), _.statusCode(v), v = t, c && f.trigger(o ? "ajaxSuccess" : "ajaxError", [_, p, o ? d : y]), m.fireWith(h, [_, k]), c && (f.trigger("ajaxComplete", [_, p]), --lt.active || lt.event.trigger("ajaxStop")))
            }

            "object" == typeof e && (n = e, e = t), n = n || {};
            var a, o, r, s, l, c, u, d, p = lt.ajaxSetup({}, n), h = p.context || p, f = p.context && (h.nodeType || h.jquery) ? lt(h) : lt.event, g = lt.Deferred(), m = lt.Callbacks("once memory"), v = p.statusCode || {}, y = {}, b = {}, w = 0, x = "canceled", _ = {
                readyState: 0,
                getResponseHeader: function (e) {
                    var t;
                    if (2 === w) {
                        if (!d)for (d = {}; t = On.exec(s);)d[t[1].toLowerCase()] = t[2];
                        t = d[e.toLowerCase()]
                    }
                    return null == t ? null : t
                },
                getAllResponseHeaders: function () {
                    return 2 === w ? s : null
                },
                setRequestHeader: function (e, t) {
                    var n = e.toLowerCase();
                    return w || (e = b[n] = b[n] || e, y[e] = t), this
                },
                overrideMimeType: function (e) {
                    return w || (p.mimeType = e), this
                },
                statusCode: function (e) {
                    var t;
                    if (e)if (2 > w)for (t in e)v[t] = [v[t], e[t]]; else _.always(e[_.status]);
                    return this
                },
                abort: function (e) {
                    var t = e || x;
                    return u && u.abort(t), i(0, t), this
                }
            };
            if (g.promise(_).complete = m.add, _.success = _.done, _.error = _.fail, p.url = ((e || p.url || An) + "").replace(Pn, "").replace(Hn, In[1] + "//"), p.type = n.method || n.type || p.method || p.type, p.dataTypes = lt.trim(p.dataType || "*").toLowerCase().match(ut) || [""], null == p.crossDomain && (a = Bn.exec(p.url.toLowerCase()), p.crossDomain = !(!a || a[1] === In[1] && a[2] === In[2] && (a[3] || ("http:" === a[1] ? 80 : 443)) == (In[3] || ("http:" === In[1] ? 80 : 443)))), p.data && p.processData && "string" != typeof p.data && (p.data = lt.param(p.data, p.traditional)), I(Un, p, n, _), 2 === w)return _;
            c = p.global, c && 0 === lt.active++ && lt.event.trigger("ajaxStart"), p.type = p.type.toUpperCase(), p.hasContent = !Fn.test(p.type), r = p.url, p.hasContent || (p.data && (r = p.url += (Mn.test(r) ? "&" : "?") + p.data, delete p.data), p.cache === !1 && (p.url = Rn.test(r) ? r.replace(Rn, "$1_=" + Ln++) : r + (Mn.test(r) ? "&" : "?") + "_=" + Ln++)), p.ifModified && (lt.lastModified[r] && _.setRequestHeader("If-Modified-Since", lt.lastModified[r]), lt.etag[r] && _.setRequestHeader("If-None-Match", lt.etag[r])), (p.data && p.hasContent && p.contentType !== !1 || n.contentType) && _.setRequestHeader("Content-Type", p.contentType), _.setRequestHeader("Accept", p.dataTypes[0] && p.accepts[p.dataTypes[0]] ? p.accepts[p.dataTypes[0]] + ("*" !== p.dataTypes[0] ? ", " + qn + "; q=0.01" : "") : p.accepts["*"]);
            for (o in p.headers)_.setRequestHeader(o, p.headers[o]);
            if (p.beforeSend && (p.beforeSend.call(h, _, p) === !1 || 2 === w))return _.abort();
            x = "abort";
            for (o in{success: 1, error: 1, complete: 1})_[o](p[o]);
            if (u = I($n, p, n, _)) {
                _.readyState = 1, c && f.trigger("ajaxSend", [_, p]), p.async && p.timeout > 0 && (l = setTimeout(function () {
                    _.abort("timeout")
                }, p.timeout));
                try {
                    w = 1, u.send(y, i)
                } catch (k) {
                    if (!(2 > w))throw k;
                    i(-1, k)
                }
            } else i(-1, "No Transport");
            return _
        },
        getScript: function (e, n) {
            return lt.get(e, t, n, "script")
        },
        getJSON: function (e, t, n) {
            return lt.get(e, t, n, "json")
        }
    }), lt.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /(?:java|ecma)script/},
        converters: {
            "text script": function (e) {
                return lt.globalEval(e), e
            }
        }
    }), lt.ajaxPrefilter("script", function (e) {
        e.cache === t && (e.cache = !1), e.crossDomain && (e.type = "GET", e.global = !1)
    }), lt.ajaxTransport("script", function (e) {
        if (e.crossDomain) {
            var n, i = Y.head || lt("head")[0] || Y.documentElement;
            return {
                send: function (t, a) {
                    n = Y.createElement("script"), n.async = !0, e.scriptCharset && (n.charset = e.scriptCharset), n.src = e.url, n.onload = n.onreadystatechange = function (e, t) {
                        (t || !n.readyState || /loaded|complete/.test(n.readyState)) && (n.onload = n.onreadystatechange = null, n.parentNode && n.parentNode.removeChild(n), n = null, t || a(200, "success"))
                    }, i.insertBefore(n, i.firstChild)
                }, abort: function () {
                    n && n.onload(t, !0)
                }
            }
        }
    });
    var Xn = [], Yn = /(=)\?(?=&|$)|\?\?/;
    lt.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var e = Xn.pop() || lt.expando + "_" + Ln++;
            return this[e] = !0, e
        }
    }), lt.ajaxPrefilter("json jsonp", function (n, i, a) {
        var o, r, s, l = n.jsonp !== !1 && (Yn.test(n.url) ? "url" : "string" == typeof n.data && !(n.contentType || "").indexOf("application/x-www-form-urlencoded") && Yn.test(n.data) && "data");
        return l || "jsonp" === n.dataTypes[0] ? (o = n.jsonpCallback = lt.isFunction(n.jsonpCallback) ? n.jsonpCallback() : n.jsonpCallback, l ? n[l] = n[l].replace(Yn, "$1" + o) : n.jsonp !== !1 && (n.url += (Mn.test(n.url) ? "&" : "?") + n.jsonp + "=" + o), n.converters["script json"] = function () {
            return s || lt.error(o + " was not called"), s[0]
        }, n.dataTypes[0] = "json", r = e[o], e[o] = function () {
            s = arguments
        }, a.always(function () {
            e[o] = r, n[o] && (n.jsonpCallback = i.jsonpCallback, Xn.push(o)), s && lt.isFunction(r) && r(s[0]), s = r = t
        }), "script") : t
    });
    var Gn, Kn, Qn = 0, Jn = e.ActiveXObject && function () {
            var e;
            for (e in Gn)Gn[e](t, !0)
        };
    lt.ajaxSettings.xhr = e.ActiveXObject ? function () {
        return !this.isLocal && P() || R()
    } : P, Kn = lt.ajaxSettings.xhr(), lt.support.cors = !!Kn && "withCredentials"in Kn, Kn = lt.support.ajax = !!Kn, Kn && lt.ajaxTransport(function (n) {
        if (!n.crossDomain || lt.support.cors) {
            var i;
            return {
                send: function (a, o) {
                    var r, s, l = n.xhr();
                    if (n.username ? l.open(n.type, n.url, n.async, n.username, n.password) : l.open(n.type, n.url, n.async), n.xhrFields)for (s in n.xhrFields)l[s] = n.xhrFields[s];
                    n.mimeType && l.overrideMimeType && l.overrideMimeType(n.mimeType), n.crossDomain || a["X-Requested-With"] || (a["X-Requested-With"] = "XMLHttpRequest");
                    try {
                        for (s in a)l.setRequestHeader(s, a[s])
                    } catch (c) {
                    }
                    l.send(n.hasContent && n.data || null), i = function (e, a) {
                        var s, c, u, d;
                        try {
                            if (i && (a || 4 === l.readyState))if (i = t, r && (l.onreadystatechange = lt.noop, Jn && delete Gn[r]), a)4 !== l.readyState && l.abort(); else {
                                d = {}, s = l.status, c = l.getAllResponseHeaders(), "string" == typeof l.responseText && (d.text = l.responseText);
                                try {
                                    u = l.statusText
                                } catch (p) {
                                    u = ""
                                }
                                s || !n.isLocal || n.crossDomain ? 1223 === s && (s = 204) : s = d.text ? 200 : 404
                            }
                        } catch (h) {
                            a || o(-1, h)
                        }
                        d && o(s, u, d, c)
                    }, n.async ? 4 === l.readyState ? setTimeout(i) : (r = ++Qn, Jn && (Gn || (Gn = {}, lt(e).unload(Jn)), Gn[r] = i), l.onreadystatechange = i) : i()
                }, abort: function () {
                    i && i(t, !0)
                }
            }
        }
    });
    var Zn, ei, ti = /^(?:toggle|show|hide)$/, ni = RegExp("^(?:([+-])=|)(" + ct + ")([a-z%]*)$", "i"), ii = /queueHooks$/, ai = [B], oi = {
        "*": [function (e, t) {
            var n, i, a = this.createTween(e, t), o = ni.exec(t), r = a.cur(), s = +r || 0, l = 1, c = 20;
            if (o) {
                if (n = +o[2], i = o[3] || (lt.cssNumber[e] ? "" : "px"), "px" !== i && s) {
                    s = lt.css(a.elem, e, !0) || n || 1;
                    do l = l || ".5", s /= l, lt.style(a.elem, e, s + i); while (l !== (l = a.cur() / r) && 1 !== l && --c)
                }
                a.unit = i, a.start = s, a.end = o[1] ? s + (o[1] + 1) * n : n
            }
            return a
        }]
    };
    lt.Animation = lt.extend(F, {
        tweener: function (e, t) {
            lt.isFunction(e) ? (t = e, e = ["*"]) : e = e.split(" ");
            for (var n, i = 0, a = e.length; a > i; i++)n = e[i], oi[n] = oi[n] || [], oi[n].unshift(t)
        }, prefilter: function (e, t) {
            t ? ai.unshift(e) : ai.push(e)
        }
    }), lt.Tween = W, W.prototype = {
        constructor: W, init: function (e, t, n, i, a, o) {
            this.elem = e, this.prop = n, this.easing = a || "swing", this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = o || (lt.cssNumber[n] ? "" : "px")
        }, cur: function () {
            var e = W.propHooks[this.prop];
            return e && e.get ? e.get(this) : W.propHooks._default.get(this)
        }, run: function (e) {
            var t, n = W.propHooks[this.prop];
            return this.pos = t = this.options.duration ? lt.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : W.propHooks._default.set(this), this
        }
    }, W.prototype.init.prototype = W.prototype, W.propHooks = {
        _default: {
            get: function (e) {
                var t;
                return null == e.elem[e.prop] || e.elem.style && null != e.elem.style[e.prop] ? (t = lt.css(e.elem, e.prop, ""), t && "auto" !== t ? t : 0) : e.elem[e.prop]
            }, set: function (e) {
                lt.fx.step[e.prop] ? lt.fx.step[e.prop](e) : e.elem.style && (null != e.elem.style[lt.cssProps[e.prop]] || lt.cssHooks[e.prop]) ? lt.style(e.elem, e.prop, e.now + e.unit) : e.elem[e.prop] = e.now
            }
        }
    }, W.propHooks.scrollTop = W.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, lt.each(["toggle", "show", "hide"], function (e, t) {
        var n = lt.fn[t];
        lt.fn[t] = function (e, i, a) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(U(t, !0), e, i, a)
        }
    }), lt.fn.extend({
        fadeTo: function (e, t, n, i) {
            return this.filter(_).css("opacity", 0).show().end().animate({opacity: t}, e, n, i)
        }, animate: function (e, t, n, i) {
            var a = lt.isEmptyObject(e), o = lt.speed(t, n, i), r = function () {
                var t = F(this, lt.extend({}, e), o);
                r.finish = function () {
                    t.stop(!0)
                }, (a || lt._data(this, "finish")) && t.stop(!0)
            };
            return r.finish = r, a || o.queue === !1 ? this.each(r) : this.queue(o.queue, r)
        }, stop: function (e, n, i) {
            var a = function (e) {
                var t = e.stop;
                delete e.stop, t(i)
            };
            return "string" != typeof e && (i = n, n = e, e = t), n && e !== !1 && this.queue(e || "fx", []), this.each(function () {
                var t = !0, n = null != e && e + "queueHooks", o = lt.timers, r = lt._data(this);
                if (n)r[n] && r[n].stop && a(r[n]); else for (n in r)r[n] && r[n].stop && ii.test(n) && a(r[n]);
                for (n = o.length; n--;)o[n].elem !== this || null != e && o[n].queue !== e || (o[n].anim.stop(i), t = !1, o.splice(n, 1));
                (t || !i) && lt.dequeue(this, e)
            })
        }, finish: function (e) {
            return e !== !1 && (e = e || "fx"), this.each(function () {
                var t, n = lt._data(this), i = n[e + "queue"], a = n[e + "queueHooks"], o = lt.timers, r = i ? i.length : 0;
                for (n.finish = !0, lt.queue(this, e, []), a && a.cur && a.cur.finish && a.cur.finish.call(this), t = o.length; t--;)o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                for (t = 0; r > t; t++)i[t] && i[t].finish && i[t].finish.call(this);
                delete n.finish
            })
        }
    }), lt.each({
        slideDown: U("show"),
        slideUp: U("hide"),
        slideToggle: U("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (e, t) {
        lt.fn[e] = function (e, n, i) {
            return this.animate(t, e, n, i)
        }
    }), lt.speed = function (e, t, n) {
        var i = e && "object" == typeof e ? lt.extend({}, e) : {
            complete: n || !n && t || lt.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !lt.isFunction(t) && t
        };
        return i.duration = lt.fx.off ? 0 : "number" == typeof i.duration ? i.duration : i.duration in lt.fx.speeds ? lt.fx.speeds[i.duration] : lt.fx.speeds._default, (null == i.queue || i.queue === !0) && (i.queue = "fx"), i.old = i.complete, i.complete = function () {
            lt.isFunction(i.old) && i.old.call(this), i.queue && lt.dequeue(this, i.queue)
        }, i
    }, lt.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }
    }, lt.timers = [], lt.fx = W.prototype.init, lt.fx.tick = function () {
        var e, n = lt.timers, i = 0;
        for (Zn = lt.now(); n.length > i; i++)e = n[i], e() || n[i] !== e || n.splice(i--, 1);
        n.length || lt.fx.stop(), Zn = t
    }, lt.fx.timer = function (e) {
        e() && lt.timers.push(e) && lt.fx.start()
    }, lt.fx.interval = 13, lt.fx.start = function () {
        ei || (ei = setInterval(lt.fx.tick, lt.fx.interval))
    }, lt.fx.stop = function () {
        clearInterval(ei), ei = null
    }, lt.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, lt.fx.step = {}, lt.expr && lt.expr.filters && (lt.expr.filters.animated = function (e) {
        return lt.grep(lt.timers, function (t) {
            return e === t.elem
        }).length
    }), lt.fn.offset = function (e) {
        if (arguments.length)return e === t ? this : this.each(function (t) {
            lt.offset.setOffset(this, e, t)
        });
        var n, i, a = {top: 0, left: 0}, o = this[0], r = o && o.ownerDocument;
        if (r)return n = r.documentElement, lt.contains(n, o) ? (typeof o.getBoundingClientRect !== X && (a = o.getBoundingClientRect()), i = $(r), {
            top: a.top + (i.pageYOffset || n.scrollTop) - (n.clientTop || 0),
            left: a.left + (i.pageXOffset || n.scrollLeft) - (n.clientLeft || 0)
        }) : a
    }, lt.offset = {
        setOffset: function (e, t, n) {
            var i = lt.css(e, "position");
            "static" === i && (e.style.position = "relative");
            var a, o, r = lt(e), s = r.offset(), l = lt.css(e, "top"), c = lt.css(e, "left"), u = ("absolute" === i || "fixed" === i) && lt.inArray("auto", [l, c]) > -1, d = {}, p = {};
            u ? (p = r.position(), a = p.top, o = p.left) : (a = parseFloat(l) || 0, o = parseFloat(c) || 0), lt.isFunction(t) && (t = t.call(e, n, s)), null != t.top && (d.top = t.top - s.top + a), null != t.left && (d.left = t.left - s.left + o), "using"in t ? t.using.call(e, d) : r.css(d)
        }
    }, lt.fn.extend({
        position: function () {
            if (this[0]) {
                var e, t, n = {top: 0, left: 0}, i = this[0];
                return "fixed" === lt.css(i, "position") ? t = i.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), lt.nodeName(e[0], "html") || (n = e.offset()), n.top += lt.css(e[0], "borderTopWidth", !0), n.left += lt.css(e[0], "borderLeftWidth", !0)), {
                    top: t.top - n.top - lt.css(i, "marginTop", !0),
                    left: t.left - n.left - lt.css(i, "marginLeft", !0)
                }
            }
        }, offsetParent: function () {
            return this.map(function () {
                for (var e = this.offsetParent || Y.documentElement; e && !lt.nodeName(e, "html") && "static" === lt.css(e, "position");)e = e.offsetParent;
                return e || Y.documentElement
            })
        }
    }), lt.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (e, n) {
        var i = /Y/.test(n);
        lt.fn[e] = function (a) {
            return lt.access(this, function (e, a, o) {
                var r = $(e);
                return o === t ? r ? n in r ? r[n] : r.document.documentElement[a] : e[a] : (r ? r.scrollTo(i ? lt(r).scrollLeft() : o, i ? o : lt(r).scrollTop()) : e[a] = o, t)
            }, e, a, arguments.length, null)
        }
    }), lt.each({Height: "height", Width: "width"}, function (e, n) {
        lt.each({padding: "inner" + e, content: n, "": "outer" + e}, function (i, a) {
            lt.fn[a] = function (a, o) {
                var r = arguments.length && (i || "boolean" != typeof a), s = i || (a === !0 || o === !0 ? "margin" : "border");
                return lt.access(this, function (n, i, a) {
                    var o;
                    return lt.isWindow(n) ? n.document.documentElement["client" + e] : 9 === n.nodeType ? (o = n.documentElement, Math.max(n.body["scroll" + e], o["scroll" + e], n.body["offset" + e], o["offset" + e], o["client" + e])) : a === t ? lt.css(n, i, s) : lt.style(n, i, a, s)
                }, n, r ? a : t, r, null)
            }
        })
    }), e.jQuery = e.$ = lt, "function" == typeof define && define.amd && define.amd.jQuery && define("jquery", [], function () {
        return lt
    })
})(window), function () {
    function Deferred() {
        function e() {
            var e = this;
            e.success = function (n) {
                return "Resolved" == o ? n.call(e, t) : i.push(n), e
            }, e.fail = function (n) {
                return "Rejected" == o ? n.call(e, t) : a.push(n), e
            }, e.then = function (t, n) {
                return e.success(t).fail(n)
            }, e.always = function (t) {
                return e.success(t).fail(t)
            }
        }

        var t, n = this, i = [], a = [], o = "Pending";
        n.promise = new e, n.resolve = function (e, a) {
            if ("Pending" === o) {
                o = "Resolved", t = e;
                for (var r = 0; i.length > r; r++)(function () {
                    i[r].call(n.promise, e, a)
                })()
            }
        }, n.reject = function (e) {
            if ("Pending" === o) {
                o = "Rejected", t = e;
                for (var a = 0; i.length > a; a++)(function () {
                    i[a].call(n.promise, e)
                })()
            }
        }
    }

    function when(e, t) {
        for (var n = e instanceof Array ? e : [e], i = n.length, a = 0, o = new Deferred, r = 0; n.length > r; r++)(function () {
            var e = n[r];
            e.always(function (e) {
                a++, a === i && o.resolve(e, t)
            })
        })();
        return o.promise
    }

    function request(e) {
        var t = document.createElement("script");
        t.charset = config.charset, t.src = config.path + "/" + e.replace(/\./g, "/") + ".js" + (/msie/.test(navigator.userAgent.toLowerCase()) ? "?_=" + unique++ : ""), t.async = !0;
        var n = new PromiseA.Deferred;
        return t.onload = t.onreadystatechange = function () {
            if (/^(?:loaded|complete|undefined)$/.test(t.readyState))if (t.onload = t.onerror = t.onreadystatechange = null, moduleCache[e] && moduleCache[e].factory) {
                moduleCache[e].state = 1;
                for (var i = !0, a = 0; moduleCache[e].deps.length > a; a++) {
                    var o = moduleCache[moduleCache[e].deps[a]];
                    if (!o || 1 > o.state) {
                        i = !1;
                        break
                    }
                }
                if (i)return n.resolve(e), void 0;
                load(moduleCache[e], function () {
                    n.resolve(e)
                })
            } else setTimeout(arguments.callee, 0)
        }, t.onerror = function () {
            throw t.onload = t.onerror = t.onreadystatechange = null, Error("Module(" + e + ") requested error.")
        }, 0 == t.src.toLowerCase().indexOf("file:") && t.onload(), nodeCache = t, head.appendChild(t), nodeCache = null, n.promise
    }

    function getDeps(e) {
        var t = [];
        return ("" + e).replace(COMMENT_RE, "").replace(REQUIRE_RE, function (e, n, i) {
            var a = "," + t.join(",") + ",";
            0 > a.indexOf(i) && t.push(i)
        }), t
    }

    function unloaded(e) {
        e = "string" == typeof e ? moduleCache[e] : e;
        var t = [];
        if (e) {
            var n = e.deps;
            0 == n.length && (n = e.deps = getDeps(e.factory));
            for (var i = 0; n.length > i; i++)moduleCache[n[i]] && moduleCache[n[i]].factory || t.push(n[i])
        }
        return t
    }

    function execute(e, t) {
        function n(e) {
            return execute(moduleCache[e], e)
        }

        if (!e)throw Error("Can't find Module(" + t + "), is it exists or right name?");
        if (2 > e.state) {
            moduleCache[e.id].state = 2;
            var i = e.factory.call(e, n, e.exports, e);
            i && (e.exports = i)
        }
        return UNIQUE_RE.test(e.id) || panda.regist(e.id, e.exports), e.exports
    }

    function status(e, t) {
        for (var n = 0; e.deps.length > n; n++)moduleCache[e.deps[n]].state = t
    }

    function getModule(e, t, n) {
        return e && !moduleCache[e] ? moduleCache[e] = {
            id: e,
            deps: t,
            factory: n,
            state: 0,
            exports: null
        } : moduleCache[e]
    }

    function load(e, t) {
        function n(e, t) {
            var n = getModule(e);
            1 > n.state && (n.state = 1);
            for (var i = [], a = 0; n.deps.length > a; a++)i.concat(unloaded(n.deps[a]));
            if (i.length)n.deps = n.deps.concat(i), load(n, t); else {
                for (var o = [], a = 0; n.deps.length > a; a++) {
                    var r = getModule(n.deps[a]);
                    r.state > 0 && o.concat(getDeps(r.factory))
                }
                if (o.length) {
                    for (var s = [], a = 0; o.length > a; a++)s.push(request(o[a]));
                    PromiseA.when(s, t).then(load)
                } else t && t(n)
            }
        }

        var i = unloaded(e);
        if (!i.length)return t && t(e), void 0;
        for (var a = [], o = 0; i.length > o; o++)a.push(request(i[o]));
        PromiseA.when(a, t).then(n)
    }

    function onDOMContentLoaded(e) {
        function t() {
            document.attachEvent ? "complete" == document.readyState ? n() : null : n()
        }

        function n() {
            panda.isReady || (panda.isReady = !0, e())
        }

        if ("complete" === document.readyState)n(); else if (document.addEventListener)document.addEventListener("DOMContentLoaded", t, !1), window.addEventListener("load", n, !1); else if (document.attachEvent) {
            document.attachEvent("onreadystatechange", t), window.attachEvent("onload", n);
            var i = !1;
            try {
                i = null == window.frameElement
            } catch (a) {
            }
            document.documentElement.doScroll && i && function () {
                if (!panda.isReady) {
                    try {
                        document.documentElement.doScroll("left")
                    } catch (e) {
                        return setTimeout(arguments.callee, 0), void 0
                    }
                    n()
                }
            }()
        }
    }

    if ("function" != typeof window.panda) {
        var Stack = {
            list: [], extractStacktrace: function (e, t) {
                t = void 0 === t ? 3 : t;
                var n, i;
                if (this.list.push(e), e.stacktrace)return e.stacktrace.split("\n")[t + 3];
                if (e.stack)for (n = e.stack.split("\n"), i = t; n.length > i; i++)this.list.push(n[i])
            }, get: function () {
                return this.list.splice(0).join("\n")
            }
        }, config = {charset: "UTF-8", path: ""}, scriptNode = document.getElementById("panda");
        if (window && window.ued_config && window.ued_config.root ? config.path = window.ued_config.root + window.ued_config.require : scriptNode && (config.path = scriptNode.getAttribute ? scriptNode.getAttribute("base") : scriptNode.base), !config.path) {
            var splits = location.href.split("/");
            splits.pop(), config.path = splits.join("/")
        }
        var head = document.getElementsByTagName("head")[0], PromiseA = {};
        PromiseA.Deferred = Deferred, PromiseA.when = when;
        var REQUIRE_RE = /require\(('|")([^()<>\\\/|?*:]*)('|")\)/g, COMMENT_RE = /(\/\*(.|[\r\n])*?\*\/)|((\/\/.*))/g, moduleCache = {}, unique = (new Date).getTime(), timestamp = (new Date).getTime(), UNIQUE_RE = RegExp("PANDA:\\d{" + ("" + timestamp).length + "}");
        window.define = function (e, t, n) {
            "function" == typeof e && (n = e, e = "PANDA:" + timestamp++), "function" == typeof t && (n = t, t = []);
            var t = (t || []).concat(getDeps(n)), i = getModule(e, t, n);
            UNIQUE_RE.test(e) && load(i, function () {
                execute(i)
            })
        };
        var panda = function () {
            var e = arguments[0];
            return !e || "string" != typeof e && "panda.string" != e.__type__ ? e && "object" == typeof e ? panda.isArray(e) && "panda.dom" !== e.__type__ ? panda.array.createArray(e) : panda.query(e) : e && "function" == typeof e ? panda.ready(e) : panda.query() : panda.query(e, arguments[1])
        }, _rl_ = [];
        panda.ready = function (e) {
            if (e && "function" == typeof e && _rl_.push(e), this.isReady)for (var t = null; t = _rl_.shift();)define(t)
        }, panda.allReady = function () {
            panda.ready()
        }, panda.regist = function (id, func) {
            for (var name = id.replace(/^base\./, "").split("."), ns, last = panda, str = name.join('"]["'); ns = name.shift();)last[ns] = last[ns] || {}, last = last[ns];
            last !== panda && eval('panda["' + str + '"]=func')
        }, panda.use = panda.define = define, panda.EXTEND_OBJECT_POOL = {}, panda.isReady = !1, panda.Deferred = PromiseA.Deferred, panda.when = PromiseA.when, panda.stack = Stack, panda.__module_cache__ = moduleCache, window.panda = panda, window.hasOwnProperty = window.hasOwnProperty || Object.prototype.hasOwnProperty, onDOMContentLoaded(function () {
            define(function (e) {
                e("base.global")
            });
            var e = setInterval(function () {
                var t = moduleCache["base.global"];
                t && t.state >= 2 && (clearInterval(e), panda.allReady())
            }, 1)
        })
    }
}(), define("base.array", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class"), o = e("base.array.index"), r = e("base.array.indexOf"), s = e("base.array.lastIndexOf"), l = e("base.array.insert"), c = e("base.array.map"), u = e("base.array.some"), d = e("base.array.unique"), p = e("base.array.remove"), h = e("base.array.each");
    a.__type__ = "panda.array", a = i.merge(a, o), a = i.merge(a, r), a = i.merge(a, s), a = i.merge(a, l), a = i.merge(a, c), a = i.merge(a, h), a = i.merge(a, u), a = i.merge(a, d), a = i.merge(a, p), a.createArray = function (e) {
        var t = [];
        if ("object" == typeof e && "undefined" != e.length)for (var n = 0; e.length > n; n++)t.push(e[n]);
        return i.merge(t, a)
    }, panda = i.merge(panda, a), n.exports = a
}), define("base.dom", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.dom.class"), o = e("base.dom.style"), r = e("base.dom.size"), s = e("base.dom.attr"), l = e("base.dom.create"), c = e("base.dom.traversal"), u = e("base.dom.insertion"), d = e("base.dom.position"), p = e("base.event.event"), h = e("base.dom.data"), f = e("base.dom.animate"), g = {};
    g.__type__ = "panda.dom", g = i.merge(g, a), g = i.merge(g, r), g = i.merge(g, o), g = i.merge(g, s), g = i.merge(g, l), g = i.merge(g, c), g = i.merge(g, u), g = i.merge(g, p), g = i.merge(g, d), g = i.merge(g, h), g = i.merge(g, f), n.exports = g
}), define("base.global", [], function (e, t, n) {
    e("base.array"), e("base.dom"), e("base.object"), e("base.query"), e("base.string"), e("base.system"), e("base.util"), e("base.widget"), panda.__type__ = "panda.global", n.exports = {}
}), define("base.object", [], function (e, t, n) {
    function i(e) {
        return function (t) {
            return Object.prototype.toString.call(t) === "[object " + e + "]"
        }
    }

    function a() {
    }

    function o(e, t, n) {
        var i, a = 0, o = panda.isArray(e);
        if (n) {
            if (o)for (; e.length > a && (i = t.apply(e[a], n), i !== !1); a++); else for (a in e)if (i = t.apply(e[a], n), i === !1)break
        } else if (o)for (; e.length > a && (i = t.call(e[a], a, e[a]), i !== !1); a++); else for (a in e)if (i = t.call(e[a], a, e[a]), i === !1)break;
        return e
    }

    var r = {}, s = r.toString, l = Object.prototype.hasOwnProperty, c = i("Object"), u = i("Number"), d = i("String"), p = Array.isArray || i("Array"), h = i("Function"), f = {
        type: function (e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? r[s.call(e)] || "object" : typeof e
        }, create: function () {
            return function () {
                this.initialize !== void 0 && this.initialize.apply(this, arguments)
            }
        }, extend: function (e, t, n) {
            if (!t || !e)throw Error();
            var i = function () {
                t.apply && t.apply(this)
            };
            if (i.prototype = t.prototype, e.prototype = new i, e.prototype.constructor = e, e.superclass = t.prototype, n)for (var a in n)n.hasOwnProperty(a) && (e.prototype[a] = n[a]);
            return e
        }, copy: function (e) {
            return n.exports.extend(new a, e)
        }, parameter: function (e, t) {
            var n = e || {}, i = t || {};
            for (var a in i)n[a] = n.hasOwnProperty(a) ? n[a] : i[a];
            return n
        }, merge: function (e, t) {
            var n = e || {};
            if (p(e) && p(t))n = n.concat(t); else if ("object" == typeof n || "function" == typeof n)for (var i in t) {
                var a = t[i];
                n[i] = "object" == typeof a && "object" == typeof n[i] ? arguments.callee(n[i], a) : a
            }
            return n
        }, bind: function (e, t, n) {
            try {
                var i = e;
                return "array" != typeof n && (n = [n]), function () {
                    return i.apply(t, n)
                }
            } catch (a) {
            }
        }, _extend: function (e, t, n) {
            var i = e || [];
            for (var a in t)i[a] = t[a], i.prevObject = n;
            for (var a in panda.EXTEND_OBJECT_POOL)i[a] = panda.EXTEND_OBJECT_POOL[a];
            return i.each = function (e) {
                for (var t = 0; this.length > t; t++)e(this[t], t)
            }, i
        }, makeArray: function (e) {
            var t = [];
            if (!e)return t;
            for (var n = e.length, i = 0; n > i; i++)t.push(e[i]);
            return t
        }, isObject: c, isString: d, isNumber: u, isArray: p, isFunction: h, isPlainObject: function (e) {
            if (!e || this.isObject(e) || e.nodeType || this.isWindow(e))return !1;
            try {
                if (e.constructor && !l.call(e, "constructor") && !l.call(e.constructor.prototype, "isPrototypeOf"))return !1
            } catch (t) {
                return !1
            }
            var n;
            for (n in e);
            return void 0 === n || l.call(e, n)
        }, isWindow: function (e) {
            return null != e && e == e.window
        }, isEmptyObject: function (e) {
            for (var t in e)return !1;
            return !0
        }, interface_extend: function (e, t, n) {
            if (e && panda.isArray(t))for (var i = 0; t.length > i; i++)e[t[i]] = n()
        }, "interface": o
    };
    panda = f.merge(panda, f), n.exports = f
}), define("base.query", [], function (e) {
    function t(n, i, a, o) {
        var r, s, l, c, u, h, f, g, m, v, y = e("base.dom");
        if ("string" == typeof i && "" != i && (i = t(i)), (i ? i.ownerDocument || i : H) !== I && (i && "panda.dom" == i.__type__ && (i = i[0]), D(i)), i = i || I, a = a || [], null === n)return z._extend([], y);
        if ("function" == typeof n)return n.__INSTANCE__ ? n : (_event.EventDispacther.call(n), t(n()));
        if ("string" == typeof n && ("window" == n && (n = window), "body" == n && (n = I.body), "document" == n && (n = I)), "object" == typeof n)return n && "panda.dom" == n.__type__ ? n : n == window || n == I || I && n == I.body ? z._extend([n], y) : n.getAttribute ? z._extend([n], y) : z._extend("array" == typeof n ? n : [n], y);
        if (n === void 0)return z._extend([], y);
        if ("string" == typeof n && "<" == n.charAt(0) && ">" == n.charAt(n.length - 1) && n.length >= 3)return y.create(n);
        if (1 !== (c = i.nodeType) && 9 !== c)return z._extend([], y);
        if (L && !o) {
            if (r = yt.exec(n))if (l = r[1]) {
                if (9 === c) {
                    if (s = i.getElementById(l), !s || !s.parentNode)return z._extend(a, y);
                    if (s.id === l)return a.push(s), z._extend(a, y)
                } else if (i.ownerDocument && (s = i.ownerDocument.getElementById(l)) && O(i, s) && s.id === l)return a.push(s), z._extend(a, y)
            } else {
                if (r[2])return et.apply(a, i.getElementsByTagName(n)), z._extend(a, y);
                if ((l = r[3]) && _.getElementsByClassName && i.getElementsByClassName)return et.apply(a, i.getElementsByClassName(l)), z._extend(a, y)
            }
            if (_.qsa && (!M || !M.test(n))) {
                if (g = f = F, m = i, v = 9 === c && n, 1 === c && "object" !== i.nodeName.toLowerCase()) {
                    for (h = d(n), (f = i.getAttribute("id")) ? g = f.replace(xt, "\\$&") : i.setAttribute("id", g), g = "[id='" + g + "'] ", u = h.length; u--;)h[u] = g + p(h[u]);
                    m = pt.test(n) && i.parentNode || i, v = h.join(",")
                }
                if (v)try {
                    return et.apply(a, m.querySelectorAll(v)), z._extend(a, y)
                } catch (b) {
                } finally {
                    f || i.removeAttribute("id")
                }
            }
        }
        return z._extend(w(n.replace(ct, "$1"), i, a, o), y)
    }

    function n() {
        function e(n, i) {
            return t.push(n += " ") > T.cacheLength && delete e[t.shift()], e[n] = i
        }

        var t = [];
        return e
    }

    function i(e) {
        return e[F] = !0, e
    }

    function a(e) {
        var t = I.createElement("div");
        try {
            return !!e(t)
        } catch (n) {
            return !1
        } finally {
            t.parentNode && t.parentNode.removeChild(t), t = null
        }
    }

    function o(e, t) {
        for (var n = e.split("|"), i = e.length; i--;)T.attrHandle[n[i]] = t
    }

    function r(e, t) {
        var n = t && e, i = n && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || G) - (~e.sourceIndex || G);
        if (i)return i;
        if (n)for (; n = n.nextSibling;)if (n === t)return -1;
        return e ? 1 : -1
    }

    function s(e) {
        return function (t) {
            var n = t.nodeName.toLowerCase();
            return "input" === n && t.type === e
        }
    }

    function l(e) {
        return function (t) {
            var n = t.nodeName.toLowerCase();
            return ("input" === n || "button" === n) && t.type === e
        }
    }

    function c(e) {
        return i(function (t) {
            return t = +t, i(function (n, i) {
                for (var a, o = e([], n.length, t), r = o.length; r--;)n[a = o[r]] && (n[a] = !(i[a] = n[a]))
            })
        })
    }

    function u() {
    }

    function d(e, n) {
        var i, a, o, r, s, l, c, u = $[e + " "];
        if (u)return n ? 0 : u.slice(0);
        for (s = e, l = [], c = T.preFilter; s;) {
            (!i || (a = ut.exec(s))) && (a && (s = s.slice(a[0].length) || s), l.push(o = [])), i = !1, (a = dt.exec(s)) && (i = a.shift(), o.push({
                value: i,
                type: a[0].replace(ct, " ")
            }), s = s.slice(i.length));
            for (r in T.filter)!(a = mt[r].exec(s)) || c[r] && !(a = c[r](a)) || (i = a.shift(), o.push({
                value: i,
                type: r,
                matches: a
            }), s = s.slice(i.length));
            if (!i)break
        }
        return n ? s.length : s ? t.error(e) : $(e, l).slice(0)
    }

    function p(e) {
        for (var t = 0, n = e.length, i = ""; n > t; t++)i += e[t].value;
        return i
    }

    function h(e, t, n) {
        var i = t.dir, a = n && "parentNode" === i, o = W++;
        return t.first ? function (t, n, o) {
            for (; t = t[i];)if (1 === t.nodeType || a)return e(t, n, o)
        } : function (t, n, r) {
            var s, l, c, u = B + " " + o;
            if (r) {
                for (; t = t[i];)if ((1 === t.nodeType || a) && e(t, n, r))return !0
            } else for (; t = t[i];)if (1 === t.nodeType || a)if (c = t[F] || (t[F] = {}), (l = c[i]) && l[0] === u) {
                if ((s = l[1]) === !0 || s === k)return s === !0
            } else if (l = c[i] = [u], l[1] = e(t, n, r) || k, l[1] === !0)return !0
        }
    }

    function f(e) {
        return e.length > 1 ? function (t, n, i) {
            for (var a = e.length; a--;)if (!e[a](t, n, i))return !1;
            return !0
        } : e[0]
    }

    function g(e, t, n, i, a) {
        for (var o, r = [], s = 0, l = e.length, c = null != t; l > s; s++)(o = e[s]) && (!n || n(o, i, a)) && (r.push(o), c && t.push(s));
        return r
    }

    function m(e, t, n, a, o, r) {
        return a && !a[F] && (a = m(a)), o && !o[F] && (o = m(o, r)), i(function (i, r, s, l) {
            var c, u, d, p = [], h = [], f = r.length, m = i || b(t || "*", s.nodeType ? [s] : s, []), v = !e || !i && t ? m : g(m, p, e, s, l), y = n ? o || (i ? e : f || a) ? [] : r : v;
            if (n && n(v, y, s, l), a)for (c = g(y, h), a(c, [], s, l), u = c.length; u--;)(d = c[u]) && (y[h[u]] = !(v[h[u]] = d));
            if (i) {
                if (o || e) {
                    if (o) {
                        for (c = [], u = y.length; u--;)(d = y[u]) && c.push(v[u] = d);
                        o(null, y = [], c, l)
                    }
                    for (u = y.length; u--;)(d = y[u]) && (c = o ? nt.call(i, d) : p[u]) > -1 && (i[c] = !(r[c] = d))
                }
            } else y = g(y === r ? y.splice(f, y.length) : y), o ? o(null, r, y, l) : et.apply(r, y)
        })
    }

    function v(e) {
        for (var t, n, i, a = e.length, o = T.relative[e[0].type], r = o || T.relative[" "], s = o ? 1 : 0, l = h(function (e) {
            return e === t
        }, r, !0), c = h(function (e) {
            return nt.call(t, e) > -1
        }, r, !0), u = [function (e, n, i) {
            return !o && (i || n !== N) || ((t = n).nodeType ? l(e, n, i) : c(e, n, i))
        }]; a > s; s++)if (n = T.relative[e[s].type])u = [h(f(u), n)]; else {
            if (n = T.filter[e[s].type].apply(null, e[s].matches), n[F]) {
                for (i = ++s; a > i && !T.relative[e[i].type]; i++);
                return m(s > 1 && f(u), s > 1 && p(e.slice(0, s - 1).concat({value: " " === e[s - 2].type ? "*" : ""})).replace(ct, "$1"), n, i > s && v(e.slice(s, i)), a > i && v(e = e.slice(i)), a > i && p(e))
            }
            u.push(n)
        }
        return f(u)
    }

    function y(e, n) {
        var a = 0, o = n.length > 0, r = e.length > 0, s = function (i, s, l, c, u) {
            var d, p, h, f = [], m = 0, v = "0", y = i && [], b = null != u, w = N, x = i || r && T.find.TAG("*", u && s.parentNode || s), _ = B += null == w ? 1 : Math.random() || .1, C = x.length;
            for (b && (N = s !== I && s, k = a); v !== C && null != (d = x[v]); v++) {
                if (r && d) {
                    for (p = 0; h = e[p++];)if (h(d, s, l)) {
                        c.push(d);
                        break
                    }
                    b && (B = _, k = ++a)
                }
                o && ((d = !h && d) && m--, i && y.push(d))
            }
            if (m += v, o && v !== m) {
                for (p = 0; h = n[p++];)h(y, f, s, l);
                if (i) {
                    if (m > 0)for (; v--;)y[v] || f[v] || (f[v] = J.call(c));
                    f = g(f)
                }
                et.apply(c, f), b && !i && f.length > 0 && m + n.length > 1 && t.uniqueSort(c)
            }
            return b && (B = _, N = w), y
        };
        return o ? i(s) : s
    }

    function b(e, n, i) {
        for (var a = 0, o = n.length; o > a; a++)t(e, n[a], i);
        return i
    }

    function w(e, t, n, i) {
        var a, o, r, s, l, c = d(e);
        if (!i && 1 === c.length) {
            if (o = c[0] = c[0].slice(0), o.length > 2 && "ID" === (r = o[0]).type && _.getById && 9 === t.nodeType && L && T.relative[o[1].type]) {
                if (t = (T.find.ID(r.matches[0].replace(_t, kt), t) || [])[0], !t)return n;
                e = e.slice(o.shift().value.length)
            }
            for (a = mt.needsContext.test(e) ? 0 : o.length; a-- && (r = o[a], !T.relative[s = r.type]);)if ((l = T.find[s]) && (i = l(r.matches[0].replace(_t, kt), pt.test(o[0].type) && t.parentNode || t))) {
                if (o.splice(a, 1), e = i.length && p(o), !e)return et.apply(n, i), n;
                break
            }
        }
        return E(e, c)(i, t, !L, n, pt.test(e)), n
    }

    var x, _, k, T, C, S, E, N, j, D, I, A, L, M, P, R, O, z = e("base.object"), F = "sizzle" + -new Date, H = window.document, B = 0, W = 0, U = n(), $ = n(), q = n(), V = !1, X = function (e, t) {
        return e === t ? (V = !0, 0) : 0
    }, Y = "undefined", G = 1 << 31, K = {}.hasOwnProperty, Q = [], J = Q.pop, Z = Q.push, et = Q.push, tt = Q.slice, nt = Q.indexOf || function (e) {
            for (var t = 0, n = this.length; n > t; t++)if (this[t] === e)return t;
            return -1
        }, it = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped", at = "[\\x20\\t\\r\\n\\f]", ot = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+", rt = ot.replace("w", "w#"), st = "\\[" + at + "*(" + ot + ")" + at + "*(?:([*^$|!~]?=)" + at + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + rt + ")|)|)" + at + "*\\]", lt = ":(" + ot + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + st.replace(3, 8) + ")*)|.*)\\)|)", ct = RegExp("^" + at + "+|((?:^|[^\\\\])(?:\\\\.)*)" + at + "+$", "g"), ut = RegExp("^" + at + "*," + at + "*"), dt = RegExp("^" + at + "*([>+~]|" + at + ")" + at + "*"), pt = RegExp(at + "*[+~]"), ht = RegExp("=" + at + "*([^\\]'\"]*)" + at + "*\\]", "g"), ft = RegExp(lt), gt = RegExp("^" + rt + "$"), mt = {
        ID: RegExp("^#(" + ot + ")"),
        CLASS: RegExp("^\\.(" + ot + ")"),
        TAG: RegExp("^(" + ot.replace("w", "w*") + ")"),
        ATTR: RegExp("^" + st),
        PSEUDO: RegExp("^" + lt),
        CHILD: RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + at + "*(even|odd|(([+-]|)(\\d*)n|)" + at + "*(?:([+-]|)" + at + "*(\\d+)|))" + at + "*\\)|)", "i"),
        bool: RegExp("^(?:" + it + ")$", "i"),
        needsContext: RegExp("^" + at + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + at + "*((?:-\\d)?\\d*)" + at + "*\\)|)(?=[^-]|$)", "i")
    }, vt = /^[^{]+\{\s*\[native \w/, yt = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, bt = /^(?:input|select|textarea|button)$/i, wt = /^h\d$/i, xt = /'|\\/g, _t = RegExp("\\\\([\\da-f]{1,6}" + at + "?|(" + at + ")|.)", "ig"), kt = function (e, t, n) {
        var i = "0x" + t - 65536;
        return i !== i || n ? t : 0 > i ? String.fromCharCode(i + 65536) : String.fromCharCode(55296 | i >> 10, 56320 | 1023 & i)
    };
    try {
        et.apply(Q = tt.call(H.childNodes), H.childNodes), Q[H.childNodes.length].nodeType
    } catch (Tt) {
        et = {
            apply: Q.length ? function (e, t) {
                Z.apply(e, tt.call(t))
            } : function (e, t) {
                for (var n = e.length, i = 0; e[n++] = t[i++];);
                e.length = n - 1
            }
        }
    }
    S = t.isXML = function (e) {
        var t = e && (e.ownerDocument || e).documentElement;
        return t ? "HTML" !== t.nodeName : !1
    }, _ = t.support = {}, D = t.setDocument = function (e) {
        var t = e ? e.ownerDocument || e : H, n = t.defaultView;
        return t !== I && 9 === t.nodeType && t.documentElement ? (I = t, A = t.documentElement, L = !S(t), n && n.attachEvent && n !== n.top && n.attachEvent("onbeforeunload", function () {
            D()
        }), _.attributes = a(function (e) {
            return e.className = "i", !e.getAttribute("className")
        }), _.getElementsByTagName = a(function (e) {
            return e.appendChild(t.createComment("")), !e.getElementsByTagName("*").length
        }), _.getElementsByClassName = a(function (e) {
            return e.innerHTML = "<div class='a'></div><div class='a i'></div>", e.firstChild.className = "i", 2 === e.getElementsByClassName("i").length
        }), _.getById = a(function (e) {
            return A.appendChild(e).id = F, !t.getElementsByName || !t.getElementsByName(F).length
        }), _.getById ? (T.find.ID = function (e, t) {
            if (typeof t.getElementById !== Y && L) {
                var n = t.getElementById(e);
                return n && n.parentNode ? [n] : []
            }
        }, T.filter.ID = function (e) {
            var t = e.replace(_t, kt);
            return function (e) {
                return e.getAttribute("id") === t
            }
        }) : (delete T.find.ID, T.filter.ID = function (e) {
            var t = e.replace(_t, kt);
            return function (e) {
                var n = typeof e.getAttributeNode !== Y && e.getAttributeNode("id");
                return n && n.value === t
            }
        }), T.find.TAG = _.getElementsByTagName ? function (e, t) {
            return typeof t.getElementsByTagName !== Y ? t.getElementsByTagName(e) : void 0
        } : function (e, t) {
            var n, i = [], a = 0, o = t.getElementsByTagName(e);
            if ("*" === e) {
                for (; n = o[a++];)1 === n.nodeType && i.push(n);
                return i
            }
            return o
        }, T.find.CLASS = _.getElementsByClassName && function (e, t) {
            return typeof t.getElementsByClassName !== Y && L ? t.getElementsByClassName(e) : void 0
        }, P = [], M = [], (_.qsa = vt.test(t.querySelectorAll)) && (a(function (e) {
            e.innerHTML = "<select><option selected=''></option></select>", e.querySelectorAll("[selected]").length || M.push("\\[" + at + "*(?:value|" + it + ")"), e.querySelectorAll(":checked").length || M.push(":checked")
        }), a(function (e) {
            var n = t.createElement("input");
            n.setAttribute("type", "hidden"), e.appendChild(n).setAttribute("t", ""), e.querySelectorAll("[t^='']").length && M.push("[*^$]=" + at + "*(?:''|\"\")"), e.querySelectorAll(":enabled").length || M.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), M.push(",.*:")
        })), (_.matchesSelector = vt.test(R = A.webkitMatchesSelector || A.mozMatchesSelector || A.oMatchesSelector || A.msMatchesSelector)) && a(function (e) {
            _.disconnectedMatch = R.call(e, "div"), R.call(e, "[s!='']:x"), P.push("!=", lt)
        }), M = M.length && RegExp(M.join("|")), P = P.length && RegExp(P.join("|")), O = vt.test(A.contains) || A.compareDocumentPosition ? function (e, t) {
            var n = 9 === e.nodeType ? e.documentElement : e, i = t && t.parentNode;
            return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
        } : function (e, t) {
            if (t)for (; t = t.parentNode;)if (t === e)return !0;
            return !1
        }, X = A.compareDocumentPosition ? function (e, n) {
            if (e === n)return V = !0, 0;
            var i = n.compareDocumentPosition && e.compareDocumentPosition && e.compareDocumentPosition(n);
            return i ? 1 & i || !_.sortDetached && n.compareDocumentPosition(e) === i ? e === t || O(H, e) ? -1 : n === t || O(H, n) ? 1 : j ? nt.call(j, e) - nt.call(j, n) : 0 : 4 & i ? -1 : 1 : e.compareDocumentPosition ? -1 : 1
        } : function (e, n) {
            var i, a = 0, o = e.parentNode, s = n.parentNode, l = [e], c = [n];
            if (e === n)return V = !0, 0;
            if (!o || !s)return e === t ? -1 : n === t ? 1 : o ? -1 : s ? 1 : j ? nt.call(j, e) - nt.call(j, n) : 0;
            if (o === s)return r(e, n);
            for (i = e; i = i.parentNode;)l.unshift(i);
            for (i = n; i = i.parentNode;)c.unshift(i);
            for (; l[a] === c[a];)a++;
            return a ? r(l[a], c[a]) : l[a] === H ? -1 : c[a] === H ? 1 : 0
        }, t) : I
    }, t.matches = function (e, n) {
        return t(e, null, null, n)
    }, t.matchesSelector = function (e, n) {
        if ((e.ownerDocument || e) !== I && D(e), n = n.replace(ht, "='$1']"), !(!_.matchesSelector || !L || P && P.test(n) || M && M.test(n)))try {
            var i = R.call(e, n);
            if (i || _.disconnectedMatch || e.document && 11 !== e.document.nodeType)return i
        } catch (a) {
        }
        return t(n, I, null, [e]).length > 0
    }, t.contains = function (e, t) {
        return (e.ownerDocument || e) !== I && D(e), O(e, t)
    }, t.attr = function (e, t) {
        (e.ownerDocument || e) !== I && D(e);
        var n = T.attrHandle[t.toLowerCase()], i = n && K.call(T.attrHandle, t.toLowerCase()) ? n(e, t, !L) : void 0;
        return void 0 === i ? _.attributes || !L ? e.getAttribute(t) : (i = e.getAttributeNode(t)) && i.specified ? i.value : null : i
    }, t.error = function (e) {
        throw Error("Syntax error, unrecognized expression: " + e)
    }, t.uniqueSort = function (e) {
        var t, n = [], i = 0, a = 0;
        if (V = !_.detectDuplicates, j = !_.sortStable && e.slice(0), e.sort(X), V) {
            for (; t = e[a++];)t === e[a] && (i = n.push(a));
            for (; i--;)e.splice(n[i], 1)
        }
        return e
    }, C = t.getText = function (e) {
        var t, n = "", i = 0, a = e.nodeType;
        if (a) {
            if (1 === a || 9 === a || 11 === a) {
                if ("string" == typeof e.textContent)return e.textContent;
                for (e = e.firstChild; e; e = e.nextSibling)n += C(e)
            } else if (3 === a || 4 === a)return e.nodeValue
        } else for (; t = e[i]; i++)n += C(t);
        return n
    }, T = t.selectors = {
        cacheLength: 50,
        createPseudo: i,
        match: mt,
        attrHandle: {},
        find: {},
        relative: {
            ">": {dir: "parentNode", first: !0},
            " ": {dir: "parentNode"},
            "+": {dir: "previousSibling", first: !0},
            "~": {dir: "previousSibling"}
        },
        preFilter: {
            ATTR: function (e) {
                return e[1] = e[1].replace(_t, kt), e[3] = (e[4] || e[5] || "").replace(_t, kt), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
            }, CHILD: function (e) {
                return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || t.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && t.error(e[0]), e
            }, PSEUDO: function (e) {
                var t, n = !e[5] && e[2];
                return mt.CHILD.test(e[0]) ? null : (e[3] && void 0 !== e[4] ? e[2] = e[4] : n && ft.test(n) && (t = d(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
            }
        },
        filter: {
            TAG: function (e) {
                var t = e.replace(_t, kt).toLowerCase();
                return "*" === e ? function () {
                    return !0
                } : function (e) {
                    return e.nodeName && e.nodeName.toLowerCase() === t
                }
            }, CLASS: function (e) {
                var t = U[e + " "];
                return t || (t = RegExp("(^|" + at + ")" + e + "(" + at + "|$)")) && U(e, function (e) {
                        return t.test("string" == typeof e.className && e.className || typeof e.getAttribute !== Y && e.getAttribute("class") || "")
                    })
            }, ATTR: function (e, n, i) {
                return function (a) {
                    var o = t.attr(a, e);
                    return null == o ? "!=" === n : n ? (o += "", "=" === n ? o === i : "!=" === n ? o !== i : "^=" === n ? i && 0 === o.indexOf(i) : "*=" === n ? i && o.indexOf(i) > -1 : "$=" === n ? i && o.slice(-i.length) === i : "~=" === n ? (" " + o + " ").indexOf(i) > -1 : "|=" === n ? o === i || o.slice(0, i.length + 1) === i + "-" : !1) : !0
                }
            }, CHILD: function (e, t, n, i, a) {
                var o = "nth" !== e.slice(0, 3), r = "last" !== e.slice(-4), s = "of-type" === t;
                return 1 === i && 0 === a ? function (e) {
                    return !!e.parentNode
                } : function (t, n, l) {
                    var c, u, d, p, h, f, g = o !== r ? "nextSibling" : "previousSibling", m = t.parentNode, v = s && t.nodeName.toLowerCase(), y = !l && !s;
                    if (m) {
                        if (o) {
                            for (; g;) {
                                for (d = t; d = d[g];)if (s ? d.nodeName.toLowerCase() === v : 1 === d.nodeType)return !1;
                                f = g = "only" === e && !f && "nextSibling"
                            }
                            return !0
                        }
                        if (f = [r ? m.firstChild : m.lastChild], r && y) {
                            for (u = m[F] || (m[F] = {}), c = u[e] || [], h = c[0] === B && c[1], p = c[0] === B && c[2], d = h && m.childNodes[h]; d = ++h && d && d[g] || (p = h = 0) || f.pop();)if (1 === d.nodeType && ++p && d === t) {
                                u[e] = [B, h, p];
                                break
                            }
                        } else if (y && (c = (t[F] || (t[F] = {}))[e]) && c[0] === B)p = c[1]; else for (; (d = ++h && d && d[g] || (p = h = 0) || f.pop()) && ((s ? d.nodeName.toLowerCase() !== v : 1 !== d.nodeType) || !++p || (y && ((d[F] || (d[F] = {}))[e] = [B, p]), d !== t)););
                        return p -= a, p === i || 0 === p % i && p / i >= 0
                    }
                }
            }, PSEUDO: function (e, n) {
                var a, o = T.pseudos[e] || T.setFilters[e.toLowerCase()] || t.error("unsupported pseudo: " + e);
                return o[F] ? o(n) : o.length > 1 ? (a = [e, e, "", n], T.setFilters.hasOwnProperty(e.toLowerCase()) ? i(function (e, t) {
                    for (var i, a = o(e, n), r = a.length; r--;)i = nt.call(e, a[r]), e[i] = !(t[i] = a[r])
                }) : function (e) {
                    return o(e, 0, a)
                }) : o
            }
        },
        pseudos: {
            not: i(function (e) {
                var t = [], n = [], a = E(e.replace(ct, "$1"));
                return a[F] ? i(function (e, t, n, i) {
                    for (var o, r = a(e, null, i, []), s = e.length; s--;)(o = r[s]) && (e[s] = !(t[s] = o))
                }) : function (e, i, o) {
                    return t[0] = e, a(t, null, o, n), !n.pop()
                }
            }), has: i(function (e) {
                return function (n) {
                    return t(e, n).length > 0
                }
            }), contains: i(function (e) {
                return function (t) {
                    return (t.textContent || t.innerText || C(t)).indexOf(e) > -1
                }
            }), lang: i(function (e) {
                return gt.test(e || "") || t.error("unsupported lang: " + e), e = e.replace(_t, kt).toLowerCase(), function (t) {
                    var n;
                    do if (n = L ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang"))return n = n.toLowerCase(), n === e || 0 === n.indexOf(e + "-"); while ((t = t.parentNode) && 1 === t.nodeType);
                    return !1
                }
            }), target: function (e) {
                var t = window.location && window.location.hash;
                return t && t.slice(1) === e.id
            }, root: function (e) {
                return e === A
            }, focus: function (e) {
                return e === I.activeElement && (!I.hasFocus || I.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
            }, enabled: function (e) {
                return e.disabled === !1
            }, disabled: function (e) {
                return e.disabled === !0
            }, checked: function (e) {
                var t = e.nodeName.toLowerCase();
                return "input" === t && !!e.checked || "option" === t && !!e.selected
            }, selected: function (e) {
                return e.parentNode && e.parentNode.selectedIndex, e.selected === !0
            }, empty: function (e) {
                for (e = e.firstChild; e; e = e.nextSibling)if (e.nodeName > "@" || 3 === e.nodeType || 4 === e.nodeType)return !1;
                return !0
            }, parent: function (e) {
                return !T.pseudos.empty(e)
            }, header: function (e) {
                return wt.test(e.nodeName)
            }, input: function (e) {
                return bt.test(e.nodeName)
            }, button: function (e) {
                var t = e.nodeName.toLowerCase();
                return "input" === t && "button" === e.type || "button" === t
            }, text: function (e) {
                var t;
                return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || t.toLowerCase() === e.type)
            }, first: c(function () {
                return [0]
            }), last: c(function (e, t) {
                return [t - 1]
            }), eq: c(function (e, t, n) {
                return [0 > n ? n + t : n]
            }), even: c(function (e, t) {
                for (var n = 0; t > n; n += 2)e.push(n);
                return e
            }), odd: c(function (e, t) {
                for (var n = 1; t > n; n += 2)e.push(n);
                return e
            }), lt: c(function (e, t, n) {
                for (var i = 0 > n ? n + t : n; --i >= 0;)e.push(i);
                return e
            }), gt: c(function (e, t, n) {
                for (var i = 0 > n ? n + t : n; t > ++i;)e.push(i);
                return e
            })
        }
    }, T.pseudos.nth = T.pseudos.eq;
    for (x in{radio: !0, checkbox: !0, file: !0, password: !0, image: !0})T.pseudos[x] = s(x);
    for (x in{submit: !0, reset: !0})T.pseudos[x] = l(x);
    return u.prototype = T.filters = T.pseudos, T.setFilters = new u, E = t.compile = function (e, t) {
        var n, i = [], a = [], o = q[e + " "];
        if (!o) {
            for (t || (t = d(e)), n = t.length; n--;)o = v(t[n]), o[F] ? i.push(o) : a.push(o);
            o = q(e, y(a, i))
        }
        return o
    }, _.sortStable = F.split("").sort(X).join("") === F, _.detectDuplicates = V, D(), _.sortDetached = a(function (e) {
        return 1 & e.compareDocumentPosition(I.createElement("div"))
    }), a(function (e) {
        return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
    }) || o("type|href|height|width", function (e, t, n) {
        return n ? void 0 : e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
    }), _.attributes && a(function (e) {
        return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
    }) || o("value", function (e, t, n) {
        return n || "input" !== e.nodeName.toLowerCase() ? void 0 : e.defaultValue
    }), a(function (e) {
        return null == e.getAttribute("disabled")
    }) || o(it, function (e, t, n) {
        var i;
        return n ? void 0 : (i = e.getAttributeNode(t)) && i.specified ? i.value : e[t] === !0 ? t.toLowerCase() : null
    }), t
}), define("base.string", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.string.class"), o = e("base.string.cut"), r = e("base.string.bytesLength"), s = e("base.string.leftBytes"), l = e("base.string.dbcToSbc"), c = e("base.string.trim");
    a.__type__ = "panda.string", a = i.merge(a, o), a = i.merge(a, r), a = i.merge(a, s), a = i.merge(a, l), a = i.merge(a, c), a.create = function (e) {
        return (null == e || void 0 == e) && (e = ""), i.merge(new String(e + ""), a)
    }, n.exports = i.merge(a, new String("")), panda = i.merge(panda, a)
}), define("base.system", [], function (e, t, n) {
    var i = e("base.object"), a = {}, o = e("base.system.browser"), r = e("base.system.cookie"), s = e("base.system.storage"), l = e("base.system.screen"), c = e("base.system.scroll");
    a.__type__ = "panda.system", a = i.merge(a, {browser: o}), a = i.merge(a, {cookie: r}), a = i.merge(a, {storage: s}), a = i.merge(a, {screen: l}), a = i.merge(a, {scroll: c}), panda = i.merge(panda, a), n.exports = a
}), define("base.util", [], function (e, t, n) {
    var i = e("base.object"), a = {}, o = e("base.util.DateFormatter"), r = e("base.util.Reg"), s = e("base.util.URL"), l = e("base.util.guid"), c = e("base.util.SWF"), u = e("base.util.Timer"), d = e("base.util.Tweener"), p = e("base.util.io"), h = e("base.util.lang"), f = e("base.util.template");
    a.__type__ = "panda.util", a = i.merge(a, {Reg: r}), a = i.merge(a, {URL: s}), a = i.merge(a, {guid: l}), a = i.merge(a, {DateFormatter: o}), a = i.merge(a, {swf: c}), a = i.merge(a, {Timer: u}), a = i.merge(a, {Tweener: d}), a = i.merge(a, {Color: e("base.util.Color")}), a = i.merge(a, p), a = i.merge(a, h), a = i.merge(a, {template: f}), panda = i.merge(panda, a), n.exports = a
}), define("base.widget", [], function (e, t, n) {
    var i = e("base.object"), a = {};
    a.__type__ = "panda.widget", a = i.merge(a, {
        manager: e("base.widget.WidgetManager"),
        base: e("base.widget.Widget")
    }), a.get = a.manager.get, n.exports = a
}), define("base.array.class", [], function (e, t, n) {
    var i = e("base.object"), a = i.create();
    a.prototype = {
        index: function () {
        }, unique: function () {
        }, insert: function () {
        }, remove: function () {
        }, indexOf: function () {
        }, lastIndexOf: function () {
        }, map: function () {
        }, each: function () {
        }, some: function () {
        }
    }, a = i._extend(a, []), n.exports = a
}), define("base.array.each", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        each: function () {
            var e = arguments[0], t = e;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this), "object" == typeof e && arguments[1] !== void 0 && (t = i.merge(e, a), e = arguments[1]);
            var n = t.length;
            if ("function" == typeof e)for (var o = 0; n > o; o++)o in t && e.call(null, t[o], o, t);
            return t
        }
    }
}), define("base.array.index", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        index: function () {
            var e = arguments[0], t = e;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this), "object" == typeof e && arguments[1] !== void 0 && (t = i.merge(e, a), e = arguments[1]);
            for (var n = 0, o = t.length; o > n; n++)if (t[n] == e)return n;
            return -1
        }
    }
}), define("base.array.indexOf", [], function (e, t, n) {
    var a = e("base.object"), o = e("base.array.class");
    n.exports = {
        indexOf: function () {
            var e = arguments[0], t = e, n = null;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this, n = arguments[0], e = arguments[1]), "object" == typeof e && arguments[1] !== void 0 && (t = a.merge(e, o), n = arguments[1], e = arguments[2]), e || (e = 0);
            var r = t.length;
            for (0 > e && (e = r + i); r > e; e++)if (t[e] === n)return e;
            return -1
        }
    }
}), define("base.array.insert", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        insert: function () {
            var e = arguments[0], t = e, n = 0;
            return "object" == typeof this && "panda.array" == this.__type__ && (t = this, n = arguments[1]), "object" == typeof e && arguments[1] !== void 0 && (t = i.merge(e, a), e = arguments[1], n = arguments[2]), n = isNaN(n) ? t.length : n, t.slice(0, n).concat(e, t.slice(n))
        }
    }
}), define("base.array.lastIndexOf", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        lastIndexOf: function () {
            var e = arguments[0], t = e, n = null;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this, e = arguments[1], n = arguments[0]), "object" == typeof value && arguments[1] !== void 0 && (t = i.merge(e, a), e = arguments[2], n = arguments[1]), e = isNaN(e) ? t.length : (0 > e ? t.length + e : e) + 1;
            var o = t.slice(0, e).reverse(), r = -1;
            if (o.indexOf)r = t.slice(0, e).reverse().indexOf(n); else for (var s = 0, l = o.length; l > s; s++)if (o[s] == n) {
                r = s;
                break
            }
            return 0 > r ? r : e - r - 1
        }
    }
}), define("base.array.map", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        map: function () {
            var e = arguments[0], t = e;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this), "object" == typeof e && arguments[1] !== void 0 && (t = i.merge(e, a), e = arguments[1]);
            var n = t.length, o = [];
            if ("function" == typeof e) {
                if ("function" == typeof[].map) {
                    var r = Array.apply(null, t);
                    return r.map(e)
                }
                for (var s = 0; n > s; s++)s in t && (o[s] = e.call(null, t[s], s, t))
            }
            return i.merge(o, a)
        }
    }
}), define("base.array.remove", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        remove: function () {
            var e = arguments[0], t = e;
            for ("object" == typeof this && "panda.array" == this.__type__ && (t = this), "object" == typeof e && arguments[1] !== void 0 && (t = i.merge([], a), e = arguments[1]); 0 > e;)e += t.length;
            var n = t.slice(0, e), o = t.slice(e + 1);
            return n.concat(o)
        }
    }
}), define("base.array.some", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        some: function () {
            var e = arguments[0], t = e;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this), "object" == typeof e && arguments[1] !== void 0 && (t = i.merge(e, a), e = arguments[1]);
            var n = t.length;
            if ("function" == typeof e) {
                if ("function" == typeof[].some) {
                    var o = Array.apply(null, t);
                    return o.some(e)
                }
                for (var r = 0; n > r; r++)if (r in t && e.call(null, t[r], r, t))return !0
            }
            return !1
        }
    }
}), define("base.array.unique", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.array.class");
    n.exports = {
        unique: function () {
            var e = arguments[0], t = e;
            "object" == typeof this && "panda.array" == this.__type__ && (t = this), "object" == typeof e && (t = i.merge(e, a));
            for (var n = 0; t.length > n; n++)for (var o = t[n], r = t.length - 1; r > n; r--)t[r] == o && t.splice(r, 1);
            return t
        }
    }
}), define("base.dom.animate", [], function (e, t, n) {
    function i(e, t, n) {
        var i = {};
        return e && !a.isObject(e) ? (a.isString(e) && isNaN(e) ? r[e] && (i.time = r[e]) : isNaN(e) || (i.time = parseFloat(e)), (n && t || t && a.isString(e)) && a.isFunction(o[t]) && (i.type = n && t || t && a.isString(e) && t), (n || !n && t || a.isFunction(e) && e) && (i.onEnd = n || !n && t || a.isFunction(e) && e)) : a.isObject(e) && (i = e), i
    }

    var a = e("base.object"), o = e("base.util.tweens"), r = {fast: 200, slow: 600}, s = {
        animate: function (e, t, n, o) {
            var r = this, s = {};
            return a.isEmptyObject(e) ? r : (s = a.parameter(s, i(t, n, o)), s.to = e, e.hasOwnProperty("autoComplete") && (s.autoComplete = e.autoComplete), panda(r).each(function (e) {
                e = panda(e);
                var t = e.data("__animate__");
                t ? t.isPlay && t.stop() : (e.data("__animate__", {}), t = {}), s.target = e;
                var n = new panda.Tweener(s);
                t = n, panda.isFunction(t.start) && t.start(), e.data("__animate__", t)
            }), r)
        }, stop: function () {
            return panda(this).each(function (e) {
                e = panda(e);
                var t = panda(e).data("__animate__");
                t || (e.data("__animate__", {}), t = {}), panda.isFunction(t.stop) && t.stop()
            }), this
        }, slideDown: function (e, t) {
            var n = this;
            void 0 == n.data("__slideNum__") && n.data("__slideNum__", n.height()), "none" == n.css("display") && (n.show(), n.height(0)), n.animate({height: n.data("__slideNum__")}, e || 350, t)
        }, slideUp: function (e, t) {
            var n = this;
            return void 0 == n.data("__slideNum__") && n.data("__slideNum__", n.height()), n.animate({height: 0}, e || 350, t), n
        }, slideToggle: function (e, t) {
            var n = this;
            return void 0 == n.data("__slideNum__") && n.data("__slideNum__", n.height()), n.data("__animate__") && n.data("__animate__").stop(), "none" == n.css("display") && (n.show(), n.height(0)), 0 >= n.height() ? n.slideDown(e, t) : n.slideUp(e, t), n
        }, fadeIn: function (e, t) {
            return this.css("opacity", 0).show().animate({opacity: 1}, e || 400, t)
        }, fadeOut: function (e, t) {
            return this.show().animate({opacity: 0}, e || 400, "easing", function () {
                panda.isFunction(t) && t(), this.target && this.target.hide()
            })
        }, fadeTo: function (e, t, n, i) {
            return this.css("opacity", 0).show().animate({opacity: t}, e, n, i)
        }, scrollTo: function (t, n) {
            n || (n = 300);
            var i = e("base.query")("body").height() - e("base.system.screen")().height + 20;
            t > i && (t = i);
            var a = 10, o = n / a, r = t - e("base.system.scroll").scrollTop();
            r /= o;
            var s = e("base.util.Timer"), l = new s({
                duration: a, delay: 0, repeat: o, callback: function () {
                    var t = e("base.system.scroll"), n = t.scrollTop();
                    t.scrollTop(n + r), n + 1 >= i && l.stop()
                }
            });
            return l.start(), this
        }
    };
    n.exports = s
}), define("base.dom.attr", [], function (e, t, n) {
    function i(e, t, n) {
        switch (t) {
            case"class":
                e.className = n;
                break;
            case"style":
                e.style.cssText = n;
                break;
            default:
                e && e.setAttribute ? e.setAttribute(t, n) : e[t] = n
        }
    }

    function a(e, t) {
        switch (t) {
            case"class":
                return e.className;
            case"style":
                return e.style.cssText;
            default:
                var n = e && e.getAttribute ? e.getAttribute(t) : e[t];
                return null == n ? void 0 : n
        }
    }

    function o(e, t) {
        try {
            e[t] = null
        } catch (n) {
        }
        try {
            delete e[t]
        } catch (n) {
        }
        try {
            e.removeAttribute(t)
        } catch (n) {
        }
    }

    var r = e("base.object"), s = {
        attr: function (e, t) {
            var n = this;
            return r.isObject(e) ? (n.each(function (t) {
                for (var n in e)i(t, n, e[n])
            }), n) : r.isString(e) && t !== void 0 ? (n.each(function (n) {
                i(n, e, t)
            }), n) : r.isString(e) ? a(this && this.length ? this[0] : {}, e) : void 0
        }, removeAttr: function (e) {
            if (!e)return this;
            var t = this;
            return t.each(function (t) {
                o(t, e)
            }), this
        }, scrollTop: function () {
            return this.length ? arguments.length ? (this[0] === window || this[0] === document ? window.scrollTo(0, arguments[0]) : "scrollTop"in this[0] ? this[0].scrollTop = arguments[0] : this[0].scrollY = arguments[0], this) : this[0] === window || this[0] === document ? panda.isNumber(window.pageYOffset) ? window.pageYOffset : document.documentElement.scrollTop || document.body.scrollTop : "scrollTop"in this[0] ? this[0].scrollTop : this[0].scrollY : arguments.length ? this : 0
        }
    };
    n.exports = s
}), define("base.dom.class", [], function (e, t, n) {
    var i = e("base.string"), a = e("base.object");
    e("base.array");
    var o = {
        addClass: function (e) {
            e = i.create(e).trim();
            var t = a.isString(e) && e;
            return t && this.each(function (t) {
                t = panda(t), t.hasClass(e) || (t[0].className += " " + e)
            }), this
        }, removeClass: function (e) {
            return e = i.create(e).trim(), proceed = a.isString(e) && e, proceed && this.each(function (t) {
                if (t = panda(t), t.hasClass(e)) {
                    var n = RegExp("(^" + e + "\\s*)|(\\s+" + e + ")");
                    t[0].className = t[0].className.replace(n, "")
                }
            }), this
        }, hasClass: function (e) {
            e = i.create(e).trim();
            var t = RegExp("(^" + e + "\\s+)|(\\s+" + e + "\\s)|(\\s+" + e + "$)|(^" + e + "$)"), n = this && this.length ? this[0] : null;
            return n && n.className && n.className.match(t) ? !0 : !1
        }, toggleClass: function (e) {
            var t = this;
            return t && t.length > 0 && (t.hasClass(e) ? t.removeClass(e) : t.addClass(e)), t
        }
    };
    n.exports = o
}), define("base.dom.create", [], function (e, t, n) {
    var i = e("base.system.browser"), a = {
        html: function () {
            var e = this, t = arguments;
            return e && e[0] ? 0 === t.length ? e[0].innerHTML : t.length > 0 ? (e.each(function (e) {
                if (i.ie && "tbody" == e.tagName.toLowerCase()) {
                    var n = e.ownerDocument.createElement("div");
                    n.innerHTML = "<table>" + t[0] + "</table>", e.parentNode.replaceChild(n.firstChild.firstChild, e)
                } else e.innerHTML = t[0]
            }), this) : void 0 : this
        }, text: function () {
            var e = this, t = arguments, n = t[0];
            if (!e || !e[0])return this;
            if (e && e.length > 0) {
                if (0 === t.length)return this[0].innerText || this[0].textContent;
                if (t.length > 0)return e.each(function (e) {
                    e.innerText ? e.innerText = n : e.textContent = n
                }), this
            }
        }, val: function (e) {
            if (e !== void 0)return this && this.length && this.each(function (t) {
                var n = t;
                if ("select" == n.tagName.toLowerCase())for (var i = n.options.length, a = 0; i > a; a++)n.options[a].value == e && (n.options[a].selected = !0); else n.value = e
            }), this;
            if (!this || !this.length)return null;
            var t = this[0];
            if ("select" != t.tagName.toLowerCase())return t.value;
            var n = t.selectedIndex, i = t.options.length;
            return i > 0 ? t.options[n > -1 ? n : 0].value : void 0
        }
    };
    n.exports = a
}), define("base.dom.data", [], function (e, t, n) {
    function i(e) {
        var t = "";
        return t = e.__guid__ ? e.__guid__ : e.__guid__ = s(), r[t] || (r[t] = {}), t
    }

    function a(e, t) {
        if (!this)return null;
        var n = null, a = !1;
        return this.each(function (o) {
            if (!n) {
                var s = i(o);
                if ("object" == typeof e)for (var l in e)r[s][l] = e[l];
                "string" == typeof e && t && (r[s][e] = t), t === void 0 && (a = !0, n = r[s][e])
            }
        }), a ? n : this
    }

    function o(e) {
        return this && this.length ? (this.each(function (t) {
            var n = i(t);
            r[n][e] = null, delete r[n][e]
        }), this) : this
    }

    var r = {}, s = e("base.util.guid");
    n.exports = {data: a, removeData: o}
}), define("base.dom.insertion", [], function (e, t, n) {
    function i(e, t) {
        if (o.ie) {
            var n = document.createElement("div");
            if ("TR" == e.tagName) {
                n.innerHTML = "<table><tbody><tr>" + t + "</tr></tbody></table>";
                var i = n.firstChild.firstChild.firstChild.childNodes, a = [];
                for (i && i.length > 0 && (a = panda.makeArray(i)); a.length > 0;) {
                    var r = a.shift();
                    e.appendChild(r)
                }
            } else {
                if (n.innerHTML = "<table><tbody>" + t + "</tbody></table>", "TR" != e.tagName && 0 == e.tBodies.length) {
                    var s = document.createElement("tbody");
                    e.appendChild(s)
                }
                e.replaceChild(n.firstChild.firstChild, e.tBodies[0])
            }
        } else e.innerHTML = t
    }

    var a = e("base.object"), o = e("base.system.browser"), r = e("base.string"), s = {
        insertBefore: function (e) {
            var t = this, n = 0;
            return e = panda(e), e.length && e.each(function (e) {
                if (e.parentNode)for (; t.length > n;)e.parentNode.insertBefore(t[n], e), n++
            }), t
        }, before: function (e) {
            return panda(e).insertBefore(this)
        }, insertAfter: function (e) {
            var t = this, n = 0;
            return e = panda(e), e.length && e.each(function (e) {
                if (e && e.parentNode)for (; t.length > n;)e.nextSibling ? e.parentNode.insertBefore(t[n], e.nextSibling) : e.parentNode && e.parentNode.appendChild(t[n]), n++
            }), t
        }, after: function (e) {
            return panda(e).insertAfter(this)
        }, appendTo: function (e) {
            var t = this;
            if (t.length) {
                var n = [];
                t.each(function (t) {
                    var i = panda(e);
                    !i[0] || 1 !== i[0].nodeType && 9 !== i[0].nodeType && 11 !== i[0].nodeType || n.push(i.append(t))
                })
            }
            return t
        }, append: function (e) {
            var t = this;
            return t.length && t.each(function (t) {
                var n = panda(e);
                (1 === t.nodeType || 9 === t.nodeType || 11 === t.nodeType) && n.each(function (e) {
                    t.appendChild(e)
                })
            }), t
        }, prependTo: function (e) {
            var t = this;
            return t.length && t.each(function (t) {
                if (t.parentNode) {
                    var n = panda(e);
                    !n[0] || 1 !== t.nodeType && 11 !== t.nodeType && 9 !== t.nodeType || n[0].insertBefore(t, n[0].firstChild)
                }
            }), t
        }, create: function (t) {
            var n = null;
            t = r.create(t).trim(), 0 == t.indexOf("<tr") ? n = document.createElement("table") : 0 == t.indexOf("<td") || 0 == t.indexOf("<th") ? (n = document.createElement("table"), n.appendChild(document.createElement("tr")), n = n.childNodes[0]) : n = document.createElement("div"), t.match(/^\<t(r|h|d)/) && o.ie ? i(n, t) : n.innerHTML = t;
            var s = e("base.dom");
            return a._extend(a.makeArray(n.childNodes), s)
        }, remove: function () {
            var e = this;
            return e.length && (e.each(function (e) {
                e.parentNode && e.parentNode.removeChild(e)
            }), e && e.splice(0, e.length)), e
        }, empty: function () {
            return this.each(function (e) {
                panda(e).html("")
            }), this
        }
    };
    n.exports = s
}), define("base.dom.position", [], function (e, t, n) {
    var i = {
        position: function (e) {
            var t = navigator.userAgent.toLowerCase(), n = -1 != t.indexOf("opera");
            -1 != t.indexOf("msie") && !n;
            var i = e ? e : this[0];
            if (i && (i === window || i === document))return {x: 0, y: 0, left: 0, top: 0};
            if (!i || null === i.parentNode || "none" == i.style.display)return {x: 0, y: 0, left: 0, top: 0};
            var a, o = null, r = [];
            if (i.getBoundingClientRect) {
                a = i.getBoundingClientRect();
                var s = Math.max(document.documentElement.scrollTop, document.body.scrollTop), l = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
                return {x: a.left + l, y: a.top + s}
            }
            if (document.getBoxObjectFor) {
                a = document.getBoxObjectFor(i);
                var c = i.style.borderLeftWidth ? parseInt(i.style.borderLeftWidth) : 0, u = i.style.borderTopWidth ? parseInt(i.style.borderTopWidth) : 0;
                r = [a.x - c, a.y - u]
            } else {
                if (r = [i.offsetLeft, i.offsetTop], o = i.offsetParent, o != i)for (; o;)r[0] += o.offsetLeft, r[1] += o.offsetTop, o = o.offsetParent;
                (-1 != t.indexOf("opera") || -1 != t.indexOf("safari") && "absolute" == i.style.position) && (r[0] -= document.body.offsetLeft, r[1] -= document.body.offsetTop)
            }
            for (o = i.parentNode ? i.parentNode : null; o && "BODY" != o.tagName && "HTML" != o.tagName;)r[0] -= o.scrollLeft, r[1] -= o.scrollTop, o = o.parentNode ? o.parentNode : null;
            return {x: r[0], y: r[1], left: r[0], top: r[1]}
        }
    };
    n.exports = i
}), define("base.dom.size", [], function (e, t, n) {
    function i(e, t) {
        var n = 0;
        switch (t) {
            case s:
            case l:
                n = parseInt(a(e, t));
                break;
            default:
                isNaN(parseInt(d._getStyle(e, t))) || (n = parseInt(d._getStyle(e, t)))
        }
        return n
    }

    function a(e, t) {
        var n = 0, i = t.toLocaleLowerCase() || null;
        return panda.isWindow(e) ? (i = r(i), e.document.documentElement["client" + i]) : e && 9 === e.nodeType ? (doc = e.documentElement, i = r(i), Math.max(e.body["scroll" + i], doc["scroll" + i], e.body["offset" + i], doc["offset" + i], doc["client" + i])) : (n = "width" === i ? e.offsetWidth : e.offsetHeight, (0 >= n || null == n) && (n = u.test(panda(e).css("display")) ? o(e, c, function () {
            return d._getStyle(e, i)
        }) : d._getStyle(e, i)), n)
    }

    function o(e, t, n, i) {
        var a, o, r = {};
        for (o in t)r[o] = e.style[o], e.style[o] = t[o];
        a = n.apply(e, i || []);
        for (o in t)e.style[o] = r[o];
        return a
    }

    function r(e) {
        return e.replace(/(^|\s+)\w/g, function (e) {
            return e.toUpperCase()
        })
    }

    var s = "width", l = "height", c = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
    }, u = /^(none|table(?!-c[ea]).+)/, d = e("base.dom.style"), p = {
        width: function (e) {
            return 0 >= this.length ? null : void 0 == e ? i(this[0], s) : this.css("width", e)
        }, height: function (e) {
            return 0 >= this.length ? null : e === void 0 ? i(this[0], l) : this.css("height", e)
        }, innerWidth: function () {
            if (0 >= this.length)return null;
            if (0 == arguments.length)return this.width() - i(this[0], "borderLeftWidth") - i(this[0], "borderRightWidth");
            if (arguments.length > 0) {
                var e = parseFloat(arguments[0]);
                return this.width(e), this
            }
        }, innerHeight: function () {
            if (0 >= this.length)return null;
            if (0 == arguments.length)return this.height() - i(this[0], "borderTopWidth") - i(this[0], "borderBottomWidth");
            if (arguments.length > 0) {
                var e = parseFloat(arguments[0]);
                return this.height(e), this
            }
        }, outerWidth: function () {
            if (0 >= this.length)return null;
            if (arguments.length > 0) {
                var e = parseFloat(arguments[0]);
                return this.width(e), this
            }
            return this.width() + i(this[0], "margin-left") + i(this[0], "margin-right")
        }, outerHeight: function () {
            if (0 >= this.length)return null;
            if (arguments.length > 0) {
                var e = parseFloat(arguments[0]);
                return this.height(e), this
            }
            return this.height() + i(this[0], "margin-top") + i(this[0], "margin-bottom")
        }, size: function () {
            return this.length
        }
    };
    panda = panda.merge(panda, p), n.exports = p
}), define("base.dom.style", [], function (e, t, n) {
    function i(e, t) {
        return t.toUpperCase()
    }

    function a(e, t) {
        var n = t || {};
        for (var i in n) {
            var a = n[i];
            if ("opacity" == i)c.ie && 9 > parseInt(c.version, 10) ? e.style.filter = "Alpha(Opacity=" + 100 * a + ");" : e.style.opacity = 1 == a ? "1" : a; else try {
                e.style[i] = "width" == i || "height" == i ? o(a) : a
            } catch (r) {
            }
        }
    }

    function o(e, t) {
        var n = m.exec(e);
        return n ? Math.max(0, n[1] - (t || 0)) + (n[2] || "px") : e
    }

    function r(e, t) {
        function n(e) {
            return e.replace(/[A-Z]/g, function (e) {
                return "-" + e.toLowerCase()
            })
        }

        if ("opacity" == t) {
            if (c.ie) {
                var i = e.style.filter, a = i.toLowerCase();
                return i && a.indexOf("opacity=") >= 0 ? parseFloat(a.match(/opacity=([^)]*)/)[1]) / 100 : 1
            }
            return e.style.opacity ? parseFloat(e.style.opacity) : 1
        }
        if (window && window.getComputedStyle)return window.getComputedStyle(e, null) && window.getComputedStyle(e, null).getPropertyValue(n(t));
        if (document.defaultView && document.defaultView.getComputedStyle) {
            var o = document.defaultView.getComputedStyle(e, null);
            if (o)return o.getPropertyValue(n(t));
            if ("display" == t)return "none"
        }
        return e.currentStyle ? e.currentStyle[t] : e.style[t]
    }

    function s(e) {
        var t = {};
        for (var n in e) {
            var i = e[n];
            "opacity" != n && !isNaN(new Number(i)) && y.isStyle(n) && (i += u), "float" == n.toLowerCase() && (n = c.ie ? "styleFloat" : "cssFloat"), null !== i && (t[l(n)] = i)
        }
        return t
    }

    function l(e) {
        return e.replace(h, "ms-").replace(f, i)
    }

    var c = e("base.system.browser"), u = "px", d = /width|height|top|left|right|bottom|margin|padding|marginTop|marginLeft|marginRight|marginBottom|paddingTop|paddingLeft|paddingRight|paddingBottom|fontSize|opacity/i, p = {}, h = /^-ms-/, f = /-([\da-z])/gi, g = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, m = RegExp("^(" + g + ")(.*)$", "i"), v = RegExp("^([+-])=(" + g + ")", "i"), y = {
        css: function (e, t) {
            if (0 == this.length)return this;
            var n = arguments;
            if (1 == n.length) {
                var i = n[0];
                if (panda.object.isArray(i)) {
                    for (var o = {}, l = 0, c = i.length; c > l; l++)o[i[l]] = r(this[0], i[l]);
                    return o
                }
                if ("object" == typeof i)p = s(i); else if ("string" == typeof i)return r(this[0], e)
            } else if (2 === n.length) {
                if ("string" != typeof n[0])throw Error("参数类型错误！！！！");
                var d = {};
                null !== t && (d[e] = t), p = s(d)
            }
            return this.each(function (e) {
                for (var t in p) {
                    var n = p[t];
                    "string" == typeof n && (ret = v.exec(n)) && (n = (ret[1] + 1) * ret[2] + parseFloat(panda.query(e).css(t)), "opacity" !== t && (n += u), p[t] = n)
                }
                a(e, p)
            }), this
        }, show: function () {
            return this.each(function (e) {
                var t = panda(e);
                "none" == t.css("display") && t.css("display", (t.data("__oldDisplay__") ? !1 : t.data("__oldDisplay__")) || "block")
            }), this
        }, hide: function () {
            return this.each(function (e) {
                var t = panda(e);
                t.data("__oldDisplay__", "none" == t.css("display") ? "" : t.css("display")), t.css("display", "none")
            }), this
        }, toggle: function () {
            return this.each(function (e) {
                "none" !== r(e, "display") ? a(e, {display: "none"}) : a(e, {display: "block"})
            }), this
        }, isStyle: function (e) {
            return d.test(e)
        }
    };
    n.exports = {
        css: y.css,
        hide: y.hide,
        show: y.show,
        toggle: y.toggle,
        isStyle: y.isStyle,
        _getStyle: r,
        _setStyle: a,
        _transformStyle: s
    }
}), define("base.dom.traversal", [], function (e, t, n) {
    function i(e, t) {
        for (var n = [], i = e[t]; i && i != document;)1 == i.nodeType && n.push(i), i = i[t];
        return n
    }

    function a(e, t) {
        var n = e.length, i = +t + (0 > t ? n : 0);
        return e[i]
    }

    function o(e, t) {
        do e = e[t]; while (e && 1 !== e.nodeType);
        return e
    }

    function r(e, t) {
        for (var n = []; e; e = e.nextSibling)1 === e.nodeType && e !== t && n.push(e);
        return n
    }

    function s(e, t) {
        var n, i = 0, a = e.length, o = [];
        if (panda.object.isArray(e))for (; a > i; i++)n = t(e[i], i), null != n && (o[o.length] = n);
        return panda.query.uniqueSort(c.apply([], o))
    }

    function l(t, n, i) {
        var a = e("base.query");
        return i && (t = ":not(" + t + ")"), a.matches(t, n)
    }

    var c = [].concat, u = e("base.object");
    e("base.array");
    var d = {
        first: function () {
            var t = this, n = e("base.dom");
            return u._extend([a(t, 0)], n)
        }, last: function () {
            var t = this, n = e("base.dom");
            return u._extend([a(t, -1)], n)
        }, parent: function () {
            var t = e("base.dom");
            return this[0] && this[0].parentNode ? u._extend([this[0].parentNode], t, this) : u._extend([], t, this)
        }, parents: function (t) {
            var n = e("base.dom"), a = [];
            return this.each(function (e) {
                a = a.concat(i(e, "parentNode"))
            }), a = panda(a).unique(), t && "string" == typeof t && a.length > 0 && (a = l(t, a)), u._extend(a, n)
        }, next: function () {
            var t = this[0], n = e("base.dom"), i = [];
            if (t) {
                var a = o(t, "nextSibling");
                a && i.push(a)
            }
            return u._extend(i, n)
        }, prev: function () {
            var t = this[0], n = e("base.dom"), i = [];
            if (t) {
                var a = o(t, "previousSibling");
                a && i.push(a)
            }
            return u._extend(i, n)
        }, siblings: function () {
            var t = this, n = s(t, function (e) {
                return r((e.parentNode || {}).firstChild, e)
            }), i = e("base.dom");
            return u._extend(n, i)
        }, end: function () {
            return this.prevObject || this.constructor(null)
        }, index: function () {
            return this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, prevAll: function () {
            return i(this[0], "previousSibling")
        }, find: function () {
            var t = arguments[0];
            if (this && !this.length)return this;
            var n = [];
            this.each(function (e) {
                n = n.concat(panda.query(t, e))
            });
            var i = e("base.dom");
            return u._extend(n, i)
        }, eq: function (t) {
            if (!this.length)return this;
            for (; 0 > t;)t += this.length;
            t > this.length && (t = this.length - 1);
            var n = this.__last_link__ ? this.__last_link__ : this.__last_link__ = this, i = n[t], a = e("base.dom"), o = u._extend([i], a);
            return o.__last_link__ = n, o
        }, is: function (e) {
            var t = this, n = panda.isFunction(e) ? e() : e, i = 0;
            if (!t.length || !n)return !1;
            for (; this.length > i; i++)if (this[i].nodeName == n.toLocaleUpperCase())return !0;
            return !1
        }, childrens: function () {
            return this.find("*")
        }, children: function () {
            var t = [];
            this.each(function (e) {
                t = t.concat(r(e.firstChild))
            });
            var n = e("base.dom");
            return u._extend(t, n)
        }
    };
    n.exports = d
}), define("base.event.event", [], function (e, t, n) {
    function i(e) {
        if (e) {
            for (var t = [], n = e.length, i = 0; n > i; i++)t.push(e[i]);
            return t
        }
    }

    function a(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }

    function o(e) {
        var t;
        for (t in e)if (("data" !== t || !D.isEmptyObject(e[t])) && "toJSON" !== t)return !1;
        return !0
    }

    function r(e, t, n, i) {
        if (c(e)) {
            var a, o, r = panda.expandO, s = "string" == typeof t, l = e.nodeType, u = l ? M.cache : e, p = l ? e[r] : e[r] && r;
            return (!p || !u[p] || !i && !u[p].data) && s && void 0 === n, p || (l ? e[r] = p = k.pop() || m() : p = r), u[p] || (u[p] = {}, !l && p && (u[p].toJSON = function () {
            })), ("object" == typeof t || "function" == typeof t) && (i ? u[p] = panda.object.merge(u[p], t) : u[p].data = panda.object.merge(u[p].data, t)), a = u[p], i || (a.data || (a.data = {}), a = a.data), void 0 !== n && (a[d(t)] = n), s ? (o = a[t], null == o && (o = a[d(t)])) : o = a, o
        }
    }

    function s(e, t, n) {
        if (c(e)) {
            var i, a, r, s = e.nodeType, l = s ? M.cache : e, p = s ? e[panda.expandO] : panda.expandO;
            if (t && (r = n ? l[p] : l[p].data)) {
                D.isArray(t) || (t in r ? t = [t] : (t = d(t), t = t in r ? [t] : t.split(" ")));
                for (i = 0, a = t.length; a > i; i++)delete r[t[i]];
                if (!(n ? o : D.isEmptyObject)(r))return
            }
            (n || (delete l[p].data, o(l[p]))) && (s ? u([e], !0) : I || l != l.window ? delete l[p] : l[p] = null)
        }
    }

    function l(e, t) {
        return s(e, t, !0)
    }

    function c(e) {
        if (e.nodeType && 1 !== e.nodeType && 9 !== e.nodeType)return !1;
        var t = e.nodeName && A[e.nodeName.toLowerCase()];
        return !t || t !== !0 && e.getAttribute("classid") === t
    }

    function u(e, t) {
        for (var n, i, a, o, r = 0, s = panda.expandO, l = M.cache, c = !0, u = M.special; null != (n = e[r]); r++)if ((t || t(n)) && (a = n[s], o = a && l[a])) {
            if (o.events)for (i in o.events)u[i] ? M.remove(n, i) : L(n, i, o.handle);
            if (l[a]) {
                if (delete l[a], c)try {
                    delete n[s]
                } catch (d) {
                    n[s] = null
                } else typeof n.removeAttribute !== T ? n.removeAttribute(s) : n[s] = null;
                k.push(a)
            }
        }
    }

    function d(e) {
        return e.replace(E, "ms-").replace(N, j)
    }

    function a(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }

    function p() {
        return !1
    }

    function h() {
        return !0
    }

    function f(e, t) {
        return this instanceof f ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || e.returnValue === !1 || e.getPreventDefault && e.getPreventDefault() ? h : p) : this.type = e, t && panda.object.merge(this, t), this.timeStamp = e && e.timeStamp || (new Date).getTime(), this[panda.expandO] = !0, void 0) : new f(e, t)
    }

    function g(e, t, n, i) {
        var a;
        if ("object" == typeof t) {
            for (a in t)g(a, n, t[a]);
            return this
        }
        (n === !1 || "function" == typeof n) && (i = n, n = void 0), i === !1 && (i = p), M.remove(e, t, i, n)
    }

    var m = e("base.util.guid"), v = /\S+/g, y = /^key/, b = /^(?:mouse|contextmenu)|click/, w = /^(?:focusinfocus|focusoutblur)$/, x = /^([^.]*)(?:\.(.+)|)$/, _ = {}, k = [], T = "undefined", C = (k.concat, k.push, k.slice), S = (k.indexOf, _.toString, _.hasOwnProperty), E = /^-ms-/, N = /-([\da-z])/gi, j = function (e, t) {
        return t.toUpperCase()
    }, D = e("base.object"), I = !0, A = {embed: !0, object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000", applet: !0};
    panda.expandO = panda.version + "-" + m();
    var L = document.removeEventListener ? function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n, !1)
    } : function (e, t, n) {
        var i = "on" + t;
        e.detachEvent && (typeof e[i] === T && (e[i] = null), e.detachEvent(i, n))
    }, M = {
        cache: {},
        global: {},
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixEventType: function (e) {
            var t = (e || "").match(v) || [""];
            return t.join(" ").indexOf("mousewheel") >= 0 && t.push("DOMMouseScroll"), t
        },
        add: function (e, t, n, i, a) {
            var o, s, l, c, u, d, p, h, f, g, v, t, y = r(e, void 0, void 0, !0);
            for (n.guid || (n.guid = m()), y || (y = {}), (s = y.events) || (s = y.events = {}), (d = y.handle) || (y.handle = d = function (e) {
                if (!window || !window.ued_config || "online" != window.ued_config.development)return typeof panda === T || e && panda.event.triggered === e.type ? void 0 : M.dispatch.apply(d.elem, arguments);
                try {
                    return typeof panda === T || e && panda.event.triggered === e.type ? void 0 : M.dispatch.apply(d.elem, arguments)
                } catch (e) {
                    panda.stack.extractStacktrace(e, 1)
                }
            }, d.elem = e), t = M.fixEventType(t), l = t.length; l--;)o = x.exec(t[l]) || [], f = v = o[1], g = (o[2] || "").split(".").sort(), u = M.special[f] || {}, f = (a ? u.delegateType : u.bindType) || f, "mouseleave" == f && (f = "mouseout"), "mouseenter" == f && (f = "mouseover"), p = panda.object.merge({
                type: f,
                origType: v,
                data: i,
                handler: n,
                guid: n.guid,
                selector: a,
                needsContext: a && panda.query.selectors.match.needsContext.test(a),
                namespace: g.join(".")
            }, c), (h = s[f]) || (h = s[f] = [], h.delegateCount = 0, e.addEventListener ? e.addEventListener(f, d, !1) : e.attachEvent && e.attachEvent("on" + f, d)), a ? h.splice(h.delegateCount++, 0, p) : h.push(p), M.global[f] = !0;
            e = null
        },
        remove: function (e, t, n, i, a) {
            var o, s, c, u, d, p, h, f, g, m, y, b = r(e, void 0, void 0, !0);
            if (b && (p = b.events)) {
                for (t = (t || "").match(v) || [""], d = t.length; d--;)if (c = x.exec(t[d]) || [], g = y = c[1], m = (c[2] || "").split(".").sort(), g) {
                    for (h = M.special[g] || {}, g = (i ? h.delegateType : h.bindType) || g, f = p[g] || [], c = c[2] && RegExp("(^|\\.)" + m.join("\\.(?:.*\\.|)") + "(\\.|$)"), u = o = f.length; o--;)s = f[o], !a && y !== s.origType || n && n.guid !== s.guid || c && !c.test(s.namespace) || i && i !== s.selector && ("**" !== i || !s.selector) || (f.splice(o, 1), s.selector && f.delegateCount--, h.remove && h.remove.call(e, s));
                    u && !f.length && (h.teardown && h.teardown.call(e, m, b.handle) !== !1 || L(e, g, b.handle), delete p[g])
                } else for (g in p)M.remove(e, g + t[d], n, i, !0);
                D.isEmptyObject(p) && (delete b.handle, l(e, "events"))
            }
        },
        trigger: function (e, t, n, o) {
            var s, l, u, d, p, h, g, m = [n || document], v = S.call(e, "type") ? e.type : e, y = S.call(e, "namespace") ? e.namespace.split(".") : [];
            if (u = h = n = n || document, 3 !== n.nodeType && 8 !== n.nodeType && !w.test(v + panda.event.triggered) && (v.indexOf(".") >= 0 && (y = v.split("."), v = y.shift(), y.sort()), l = 0 > v.indexOf(":") && "on" + v, e = e[panda.expandO] ? e : new f(v, "object" == typeof e && e), e.isTrigger = !0, e.namespace = y.join("."), e.namespace_re = e.namespace ? RegExp("(^|\\.)" + y.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), t = null == t ? [e] : i(t, [e]), p = M.special[v] || {}, o || !p.trigger || p.trigger.apply(n, t) !== !1)) {
                if (!o && !p.noBubble && !D.isWindow(n)) {
                    for (d = p.delegateType || v, w.test(d + v) || (u = u.parentNode); u; u = u.parentNode)m.push(u), h = u;
                    h === (n.ownerDocument || document) && m.push(h.defaultView || h.parentWindow || window)
                }
                for (g = 0; (u = m[g++]) && !e.isPropagationStopped();)e.type = g > 1 ? d : p.bindType || v, s = (r(u, "events", void 0, !0) || {})[e.type] && r(u, "handle", void 0, !0), s && s.apply(u, t), s = l && u[l], s && c(u) && s.apply && s.apply(u, t) === !1 && e.preventDefault();
                if (e.type = v, !(o || e.isDefaultPrevented() || p._default && p._default.apply(n.ownerDocument, t) !== !1 || "click" === v && a(n, "a") || !c(n) || !l || !n[v] || D.isWindow(n))) {
                    h = n[l], h && (n[l] = null), panda.event.triggered = v;
                    try {
                        n[v]()
                    } catch (b) {
                    }
                    panda.event.triggered = void 0, h && (n[l] = h)
                }
                return e.result
            }
        },
        dispatch: function (e) {
            if (!e)return void 0;
            e = M.fix(e);
            var t, n, i, a, o, s = [], l = C.call(arguments), c = (r(this, "events", void 0, !0) || {})[e.type] || [], u = M.special[e.type] || {};
            if (l[0] = e, e.delegateTarget = this, !u.preDispatch || u.preDispatch.call(this, e) !== !1) {
                for (s = M.handlers.call(this, e, c), t = 0; (a = s[t++]) && !e.isPropagationStopped();)for (e.currentTarget = a.elem, o = 0; (i = a.handlers[o++]) && !e.isImmediatePropagationStopped();)(!e.namespace_re || e.namespace_re.test(i.namespace)) && (e.handleObj = i, e.data = i.data, i.selector ? panda(i.selector, this).each(function (t) {
                    "mouseleave" == i.origType || "mouseenter" == i.origType ? "mouseenter" == i.origType ? (t === e.target || panda.query.contains(t, e.target)) && (n = ((M.special[i.origType] || {}).handle || i.handler).apply(a.elem, l)) : panda.query.contains(t, e.relatedTarget) || (n = ((M.special[i.origType] || {}).handle || i.handler).apply(a.elem, l)) : t === a.elem && (n = ((M.special[i.origType] || {}).handle || i.handler).apply(a.elem, l))
                }) : "mouseleave" == i.origType || "mouseenter" == i.origType ? "mouseenter" == i.origType ? (a.elem === e.target || panda.query.contains(a.elem, e.target)) && (n = ((M.special[i.origType] || {}).handle || i.handler).apply(a.elem, l)) : panda.query.contains(a.elem, e.relatedTarget) || (n = ((M.special[i.origType] || {}).handle || i.handler).apply(a.elem, l)) : n = ((M.special[i.origType] || {}).handle || i.handler).apply(a.elem, l), void 0 !== n && (e.result = n) === !1 && (e.preventDefault(), e.stopPropagation()));
                return u.postDispatch && u.postDispatch.call(this, e), e.result
            }
        },
        fix: function (e) {
            if (e[panda.expand])return e;
            var t, n, i, a = e, o = e.type, r = M.fixHooks[o];
            for (r || (M.fixHooks[o] = r = b.test(o) ? M.mouseHooks : y.test(o) ? M.keyHooks : {}), i = r.props ? M.props.concat(r.props) : M.props, e = new f(a), t = i.length; t--;)n = i[t], e[n] = a[n];
            return e.target || (e.target = a.srcElement || document), 3 === e.target.nodeType && (e.target = e.target.parentNode), e.metaKey = !!e.metaKey, r.filter ? r.filter(e, a) : e
        },
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (e, t) {
                var n, i, a, o = t.button, r = t.fromElement;
                return null == e.pageX && null != t.clientX && (i = e.target.ownerDocument || document, a = i.documentElement, n = i.body, e.pageX = t.clientX + (a && a.scrollLeft || n && n.scrollLeft || 0) - (a && a.clientLeft || n && n.clientLeft || 0), e.pageY = t.clientY + (a && a.scrollTop || n && n.scrollTop || 0) - (a && a.clientTop || n && n.clientTop || 0)), !e.relatedTarget && r && (e.relatedTarget = r === e.target ? t.toElement : r), e.which || void 0 === o || (e.which = 1 & o ? 1 : 2 & o ? 3 : 4 & o ? 2 : 0), e
            }
        },
        special: {
            load: {noBubble: !0}, click: {
                trigger: function () {
                    return a(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : void 0
                }
            }, focus: {
                trigger: function () {
                    if (this !== document.activeElement && this.focus)try {
                        return this.focus(), !1
                    } catch (e) {
                    }
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === document.activeElement && this.blur ? (this.blur(), !1) : void 0
                }, delegateType: "focusout"
            }, beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && (e.originalEvent.returnValue = e.result)
                }
            }
        },
        handlers: function (e, t) {
            var n, i, a, o, r = [], s = t.delegateCount, l = e.target;
            if (s && l.nodeType && (!e.button || "click" !== e.type))for (; l != this; l = l.parentNode || this)if (1 === l.nodeType && (l.disabled !== !0 || "click" !== e.type)) {
                for (a = [], o = 0; s > o; o++)i = t[o], n = i.selector + " ", void 0 === a[n] && (a[n] = i.needsContext ? panda(n, this).index(l) >= 0 : panda(this).find(n).length), a[n] && a.push(i);
                a.length && r.push({elem: l, handlers: a})
            }
            return t.length > s && r.push({elem: this, handlers: t.slice(s)}), r
        }
    };
    f.prototype = {
        isDefaultPrevented: p,
        isPropagationStopped: p,
        isImmediatePropagationStopped: p,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = h, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1)
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = h, e && (e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0)
        }
    };
    for (var t = {
        on: function (e, t, n, i) {
            var a;
            if ("object" == typeof e) {
                for (a in e)this.on(a, t, e[a], one);
                return this
            }
            if (null == t && null == n || null == n && (n = t), n === !1); else if (!n)return this;
            return this.each(function (a) {
                M.add(a, e, n, t, i)
            }), this
        }, delegate: function (e, t, n, i) {
            return this.on(t, n, i, e)
        }, bind: function (e, t, n) {
            return this.on(e, t, n)
        }, un: function (e, t) {
            return this.each(function (n) {
                g(n, e, null, t)
            }), this
        }, undelegate: function (e, t, n) {
            return this.un(t, n, e)
        }, unbind: function (e, t) {
            return this.each(function (n) {
                g(n, e, null, t)
            }), this
        }, fire: function (e, t) {
            return this.each(function (n) {
                M.trigger(e, t, n)
            })
        }, trigger: function (e, t) {
            return this.each(function (n) {
                "mousewheel" == e && void 0 !== document.mozHidden && (e = "DOMMouseScroll"), M.trigger(e, t, n)
            })
        }, Event: f
    }, P = "blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), R = 0; P.length > R; R++)(function (e) {
        t[e] = function (t, n) {
            return arguments.length > 0 ? this.on(e, t, n) : this.trigger(e)
        }
    })(P[R]);
    n.exports = t
}), define("base.string.bytesLength", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.string.class");
    n.exports = {
        bytesLength: function () {
            var e = arguments[0], t = e;
            if ("object" == typeof this && "panda.string" == this.__type__ && (t = this), ("string" == typeof e || !isNaN(e) && "number" == typeof e) && (t = i.merge(new String(e), a)), !t || !t.length)return 0;
            var n = t.match(/[^\x00-\xff]/g);
            return t.length + (n ? n.length : 0)
        }
    }
}), define("base.string.class", [], function (e, t) {
    function n() {
    }

    function i() {
    }

    function a() {
    }

    function o() {
    }

    function r() {
    }

    var s = e("base.object"), l = {cut: n, bytesLength: i, leftBytes: a, dbcToSbc: o, trim: r};
    return t = s._extend(new String(""), l)
}), define("base.string.cut", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.string.class");
    n.exports = {
        cut: function () {
            var e = arguments[0], t = 0, n = -1;
            "string" == typeof e ? (e = i.merge(new String(e), a), t = 1 * arguments[1] || 0, n = arguments[2] !== void 0 ? 1 * arguments[2] : e.bytesLength()) : "object" == typeof this && "panda.string" == this.__type__ && (e = this, t = 1 * arguments[0] || 0, n = arguments[1] !== void 0 ? 1 * arguments[1] : e.bytesLength());
            var o = 0, r = 0, s = "", l = e.length, c = e.bytesLength();
            for (0 > t && (t = c + t); 0 > n && c > 0;)n = c + n;
            for (var u = 0; l > u && !(o >= t); u++)r = e.charCodeAt(u), o += 127 > r ? 1 : 2;
            for (; l > u && !(o >= n); u++)r = e.charCodeAt(u), o += 127 > r ? 1 : 2, s += e.charAt(u);
            return i.merge(new String(s), a)
        }
    }
}), define("base.string.dbcToSbc", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.string.class");
    n.exports = {
        dbcToSbc: function () {
            var e = arguments[0], t = e;
            if ("object" == typeof this && "panda.string" == this.__type__ && (t = this), ("string" == typeof e || !isNaN(e) && "number" == typeof e) && (t = i.merge(new String(e), a)), !t)return "";
            var n = t.replace(/[\uff01-\uff5e]/g, function (e) {
                return String.fromCharCode(e.charCodeAt(0) - 65248)
            }).replace(/\u3000/g, " ");
            return i.merge(new String(n), a)
        }
    }
}), define("base.string.leftBytes", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.string.class");
    n.exports = {
        leftBytes: function () {
            var e = arguments[0], t = 0;
            if ("string" == typeof e ? (e = i.merge(new String(e), a), t = arguments[1] === void 0 ? e.bytesLength() : 1 * arguments[1] || 0) : "object" == typeof this && "panda.string" == this.__type__ && (e = this, t = arguments[0] === void 0 ? e.bytesLength() : 1 * arguments[0] || 0), !e)return "";
            for (; 0 > t && e.length > 0;)t += e.bytesLength();
            var n = e.replace(/\*/g, " ").replace(/[^\x00-\xff]/g, "**"), o = e.slice(0, n.slice(0, t).replace(/\*\*/g, " ").replace(/\*/g, "").length);
            return a.bytesLength(o) > t && (o = o.slice(0, o.length - 1)), i.merge(new String(o), a)
        }
    }
}), define("base.string.trim", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.string.class");
    n.exports = {
        trim: function (e, t) {
            if ("string" != typeof e && (e = this), !e.length)return "";
            var n = e.replace(/(^(\u3000|\s|\t|\u00A0)*)|((\u3000|\s|\t|\u00A0)*$)/g, "");
            return t && (n = n.replace(/(\u3000|\s|\t|\u00A0){1,9999}/g, " ")), i.merge(new String(n), a)
        }
    }
}), define("base.system.browser", [], function (e, t, n) {
    var i = navigator.userAgent.toLowerCase(), a = {
        version: (i.match(/.+(?:rv|chrome|ra|ie)[\/: ]([\d.]+)/) || [])[1],
        ie: /msie/.test(i),
        moz: /gecko/.test(i),
        safari: /safari/.test(i),
        ff: /firefox/i.test(i),
        chrome: /chrome/i.test(i)
    };
    a.isIE6 = a.ie && "6.0" === a.version, a.platform = {};
    var o = navigator.userAgent, r = "Android iPad iPhone Linux Macintosh Windows X11 Touch".split(" ");
    for (var s in r)if (r.hasOwnProperty(s)) {
        var l = r[s], c = l.charAt(0).toUpperCase() + l.toLowerCase().substr(1);
        a.platform["is" + c] = !!~o.indexOf(l)
    }
    a.isMobile = a.platform.isAndroid || a.platform.isIpad || a.platform.isIphone || a.platform.isTouch ? !0 : !1, n.exports = a
}), define("base.system.cookie", [], function (e, t, n) {
    n.exports = {
        get: function (e) {
            e = e.replace(/([\.\[\]\$])/g, "\\$1");
            var t = RegExp(e + "=([^;]*)?;", "i"), n = document.cookie + ";", i = n.match(t);
            return i ? unescape(i[1]) || "" : ""
        }, set: function (e, t, n, i, a, o) {
            var r = [];
            if (r.push(e + "=" + escape(t)), n) {
                var s = new Date, l = s.getTime() + 36e5 * n;
                s.setTime(l), r.push("expires=" + s.toGMTString())
            }
            i && r.push("path=" + i), a && r.push("domain=" + a), o && r.push(o), document.cookie = r.join(";")
        }
    }
}), define("base.system.screen", [], function () {
    return function (e) {
        var t, n, i;
        i = e ? e.document : document, self.innerHeight ? (i = e ? e.self : self, t = i.innerWidth, n = i.innerHeight) : i.documentElement && i.documentElement.clientHeight ? (t = i.documentElement.clientWidth, n = i.documentElement.clientHeight) : i.body && (t = i.body.clientWidth, n = i.body.clientHeight);
        var a = 0, o = 0;
        return window && window.screen && (a = window.screen.availWidth, o = window.screen.availHeight), {
            width: t,
            height: n,
            visibleWidth: a,
            visibleHeight: o
        }
    }
}), define("base.system.scroll", [], function (e, t, n) {
    n.exports = {
        scrollTop: function (e) {
            var t = document, n = t.documentElement, i = t.body;
            return void 0 === e ? Math.max(window.pageYOffset || 0, n.scrollTop, i.scrollTop) : (window ? window.scrollTo(window.pageXOffset, e) : t.scrollLeft = e, void 0)
        }, scrollLeft: function (e) {
            var t = document, n = t.documentElement, i = t.body;
            return void 0 === e ? Math.max(window.pageXOffset || 0, n.scrollLeft, i.scrollLeft) : (window ? window.scrollTo(e, window.pageYOffset) : t.scrollLeft = e, void 0)
        }
    }
}), define("base.system.storage", [], function (e, t, n) {
    var i = function () {
        var e = this;
        return e._host = "", e._isLocal = !1, e._container = null, e.initialize = function () {
            e._host = location.hostname ? location.hostname : "localStatus", e._isLocal = window.localStorage ? !0 : !1
        }, e.getContainer = function () {
            if (!e._container)try {
                e._container = document.createElement("input"), e._container.type = "hidden", e._container.style.display = "none", e._container.addBehavior("#default#userData"), panda("body").append(e._container);
                var t = new Date;
                t.setDate(t.getDate() + 30), e._container.expires = t.toUTCString()
            } catch (n) {
                e._container = null
            }
            return e._container
        }, e.set = function (t, n) {
            e._isLocal ? window.localStorage.setItem(t, n) : e.getContainer() && (e.getContainer().load(e._host), panda(e.getContainer()).attr(t, n), e.getContainer().save(e._host))
        }, e.get = function (t) {
            return e._isLocal ? window.localStorage.getItem(t) : e.getContainer() ? (e.getContainer().load(e._host), panda(e.getContainer()).attr(t)) : null
        }, e.remove = function (t) {
            e._isLocal ? window.localStorage.removeItem(t) : e.getContainer() && (e.getContainer().load(e._host), panda(e.getContainer()).removeAttr(t), e.getContainer().save(e._host))
        }, e.initialize()
    };
    n.exports = new i
}), define("base.util.Color", [], function (e, t, n) {
    var i = /\s*rgba?\s*\(\s*([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\s*(?:,\s*(\d+))?\)\s*/, a = /\s*#([0-9a-fA-F][0-9a-fA-F]?)([0-9a-fA-F][0-9a-fA-F]?)([0-9a-fA-F][0-9a-fA-F]?)\s*/, o = function () {
        var e, t, n;
        if (this.hslValue = function () {
                var e = this.getHSL();
                return "hsl(" + Math.round(e.h || 0) + "," + this.percentage(e.s) + "," + this.percentage(e.l) + ")"
            }, this.hslaValue = function () {
                var e = this.getHSL();
                return "hsla(" + Math.round(e.h || 0) + "," + this.percentage(e.s) + "," + this.percentage(e.l) + "," + this.a + ")"
            }, this.hsvValue = function () {
                var e = this.getHSV();
                return "hsv(" + Math.round(e.h || 0) + "," + this.percentage(e.s) + "," + this.percentage(e.v) + ")"
            }, this.hsvaValue = function () {
                var e = this.getHSV();
                return "hsva(" + Math.round(e.h || 0) + "," + this.percentage(e.s) + "," + this.percentage(e.v) + "," + this.a + ")"
            }, this.rgbValue = function () {
                var e = this;
                return "rgb(" + Math.round(e.r) + "," + Math.round(e.g) + "," + Math.round(e.b) + ")"
            }, this.rgbaValue = function () {
                var e = this;
                return "rgba(" + e.r + "," + e.g + "," + e.b + "," + e.a + ")"
            }, this.hexValue = function () {
                var e = this;
                return "#" + this.padding2(Number(e.r).toString(16)) + this.padding2(Number(e.g).toString(16)) + this.padding2(Number(e.b).toString(16))
            }, this.getHSL = function () {
                var e, t = this, n = t.r / 255, i = t.g / 255, a = t.b / 255, o = Math.max(n, i, a), r = Math.min(n, i, a), s = o - r, l = 0, c = .5 * (o + r);
                return r != o && (l = .5 > c ? s / (o + r) : s / (2 - o - r), e = n == o ? 60 * (i - a) / s : i == o ? 120 + 60 * (a - n) / s : 240 + 60 * (n - i) / s, e = (e + 360) % 360), {
                    h: e,
                    s: l,
                    l: c
                }
            }, this.getHSV = function () {
                return this.rgb2hsv({r: this.r, g: this.g, b: this.b})
            }, this.setHSL = function (e) {
                var t, n = this;
                return "h"in e && "s"in e && "l"in e || (t = n.getHSL(), S.each(["h", "s", "l"], function (n) {
                    n in e && (t[n] = e[n])
                }), e = t), n.colorTransfrom({hsl: e.h + "," + e.s + "," + e.l}), this
            }, this.to255 = function (e) {
                return 255 * e
            }, this.hsv2rgb = function (e) {
                var t, n, i, a = Math.min(Math.round(e.h), 359), o = Math.max(0, Math.min(1, e.s)), r = Math.max(0, Math.min(1, e.v)), s = Math.floor(a / 60 % 6), l = a / 60 - s, c = r * (1 - o), u = r * (1 - l * o), d = r * (1 - (1 - l) * o);
                switch (s) {
                    case 0:
                        t = r, n = d, i = c;
                        break;
                    case 1:
                        t = u, n = r, i = c;
                        break;
                    case 2:
                        t = c, n = r, i = d;
                        break;
                    case 3:
                        t = c, n = u, i = r;
                        break;
                    case 4:
                        t = d, n = c, i = r;
                        break;
                    case 5:
                        t = r, n = c, i = u
                }
                return {
                    r: this.constrain255(this.to255(t)),
                    g: this.constrain255(this.to255(n)),
                    b: this.constrain255(this.to255(i))
                }
            }, this.rgb2hsv = function (e) {
                var t, n, i, a = e.r / 255, o = e.g / 255, r = e.b / 255, s = Math.min(Math.min(a, o), r), l = Math.max(Math.max(a, o), r), c = l - s;
                switch (l) {
                    case s:
                        t = 0;
                        break;
                    case a:
                        t = 60 * (o - r) / c, r > o && (t += 360);
                        break;
                    case o:
                        t = 60 * (r - a) / c + 120;
                        break;
                    case r:
                        t = 60 * (a - o) / c + 240
                }
                return n = 0 === l ? 0 : 1 - s / l, i = {h: Math.round(t), s: n, v: l}
            }, this.hsl2rgb = function (e) {
                var t, n, i, a = Math.min(Math.round(e.h), 359), o = Math.max(0, Math.min(1, e.s)), r = Math.max(0, Math.min(1, e.l)), s = [], l = Math.abs, c = Math.floor;
                if (0 == o || null == a)s = [r, r, r]; else {
                    switch (a /= 60, t = o * (1 - l(2 * r - 1)), n = t * (1 - l(a - 2 * c(a / 2) - 1)), i = r - t / 2, c(a)) {
                        case 0:
                            s = [t, n, 0];
                            break;
                        case 1:
                            s = [n, t, 0];
                            break;
                        case 2:
                            s = [0, t, n];
                            break;
                        case 3:
                            s = [0, n, t];
                            break;
                        case 4:
                            s = [n, 0, t];
                            break;
                        case 5:
                            s = [t, 0, n]
                    }
                    s = [s[0] + i, s[1] + i, s[2] + i]
                }
                for (var u in s)s[u] = this.to255(s[u]);
                return {r: s[0], g: s[1], b: s[2]}
            }, this.parseHex = function (e) {
                return parseInt(e, 16)
            }, this.paddingHex = function (e) {
                return e + 16 * e
            }, this.padding2 = function (e) {
                return 2 != e.length && (e = "0" + e), e
            }, this.percentage = function (e) {
                return Math.round(100 * e) + "%"
            }, this.constrain255 = function (e) {
                return Math.max(0, Math.min(e, 255))
            }, this.parse = function (o) {
                4 != o.length && 7 != o.length || "#" !== o.substr(0, 1) ? (values = ("" + o).match(i), values && (this.r = values[1], this.g = values[2], this.b = values[3], this.a = values[4])) : (values = o.match(a), values && (this.r = this.parseHex(values[1]), this.g = this.parseHex(values[2]), this.b = this.parseHex(values[3]), 4 == o.length && (this.r = this.paddingHex(e), this.g = this.paddingHex(t), this.b = this.paddingHex(n))))
            }, 1 == arguments.length)if (this.a = 1, arguments[0].toLowerCase().indexOf("rgb") >= 0) {
            var o = arguments[0].match(/\d{1,3}/g);
            o && (this.r = o[0] || 0, this.g = o[1] || 0, this.b = o[2] || 0, this.a = o[3] || 1)
        } else this.parse(arguments[0]); else arguments.length > 1 && (this.r = arguments[0], this.g = arguments[1], this.b = arguments[2], this.a = arguments[3] || 1);
        this.colorTransfrom = function (e) {
            for (var t in e) {
                var n = e[t].split(",");
                switch (t) {
                    case"hex":
                        this.parse(n[0]);
                        break;
                    case"rgb":
                        this.r = n[0], this.g = n[1], this.b = n[2];
                        break;
                    case"rgba":
                        this.r = n[0], this.g = n[1], this.b = n[2], this.a = n[3] || 1;
                        break;
                    case"hsl":
                        var i = this.hsl2rgb({h: n[0], s: n[1], l: n[2]});
                        this.r = i.r, this.g = i.g, this.b = i.b;
                        break;
                    case"hsla":
                        this.hsl2rgb({
                            h: n[0],
                            s: n[1],
                            l: n[2]
                        }), this.r = i.r, this.g = i.g, this.b = i.b, this.a = n[3];
                        break;
                    case"hsv":
                        var a = this.hsv2rgb({h: n[0], s: n[1], v: n[2]});
                        this.r = a.r, this.g = a.g, this.b = a.b;
                        break;
                    case"hsva":
                        var o = this.hsv2rgb({h: n[0], s: n[1], v: n[2]});
                        this.r = o.r, this.g = o.g, this.b = o.b, this.a = n[3]
                }
                return
            }
        }
    };
    n.exports = o
}), define("base.util.DateFormatter", [], function (require, exports, module) {
    var DateFormatter = function (time, pattern) {
        var self = this;
        return self._source = null, self._result = "", self._pattern = "Y-m-d H:i:s", self._key = {
            y: "getYear",
            Y: "getFullYear",
            m: "getMonth",
            d: "getDate",
            D: "getDay",
            H: "getHours",
            i: "getMinutes",
            s: "getSeconds"
        }, self.initialize = function (e, t) {
            return self._source = new Date, t && self.setPattern(t), "number" == typeof e ? self.setTime(e) : "string" == typeof e || "object" == typeof e ? self.setSource(e) : self.setTime((new Date).getTime()), self
        }, self.setSource = function (value) {
            if (value || (value = ""), "object" == typeof value) {
                var date = new Date;
                date.setTime(value.getTime()), self._source = date
            }
            if ("string" == typeof value) {
                var data = value, reCat = /(\d{1,4})/gm, t = data.match(reCat);
                if (t && t.length > 1 && (t[1] = t[1] - 1), t && 6 > t.length)for (var i = t.length; 6 > i; i++)2 == i ? t.push(1) : t.push(0);
                t ? eval("self._source = new Date(" + t.join(",") + ");") : self._source = new Date
            }
            return self.parse(), self
        }, self.getSource = function () {
            return self._source || (self._source = new Date), self._source
        }, self.setTime = function (e) {
            return self.getSource().setTime(e), self.parse(), self
        }, self.getTime = function () {
            return self.getSource().getTime()
        }, self.setPattern = function (e) {
            return self._pattern = e, self.parse(), self
        }, self.parse = function () {
            self._result = "";
            for (var i = 0; self._pattern.length > i; i++) {
                var ch = self._pattern.charAt(i);
                92 != self._pattern.charCodeAt(i) ? null != self._key[ch] ? "m" == ch ? (eval("var re = self.getSource()." + self._key[ch] + "()+1;"), 10 > parseInt(re, 10) && (re = "0" + re), self._result += re) : (eval("var re = self.getSource()." + self._key[ch] + "();"), 10 > parseInt(re, 10) && (re = "0" + re), self._result += re) : self._result += ch : (i++, self._result += self._pattern.charAt(i))
            }
            return self
        }, self.dateTo = function (e, t) {
            var n = 0;
            switch (e) {
                case"y":
                    n += 31536e6 * t;
                    break;
                case"m":
                    n += 2592e6 * t;
                    break;
                case"d":
                    n += 864e5 * t;
                    break;
                case"H":
                    n += 36e5 * t;
                    break;
                case"i":
                    n += 6e4 * t;
                    break;
                case"s":
                    n += 1e3 * t
            }
            return self.setTime(self.getTime() + n), self
        }, self.compare = function (e) {
            return self.getTime() - (e.getTime() || self.getTime())
        }, self.isLeapYear = function () {
            return 0 == self.getSource().getFullYear() % 4 && (0 != self.getSource().getFullYear() % 100 || 0 == self.getSource().getFullYear() % 400)
        }, self.toString = function () {
            return self._result
        }, self.initialize(time, pattern)
    };
    module.exports = DateFormatter
}), define("base.util.Reg", [], function (e, t, n) {
    var i = function (e, t) {
        var n = this;
        return n._quene = [], n._regexp = null, n._source = null, n._pattern = "", n.initialize = function (e, t) {
            return n._pattern = t, n._parse(e), n
        }, n._parse = function (e) {
            n._source = e;
            var t = e.source, i = /\#<.*?\)>/gi;
            i = t.match(i);
            var a = /\#<([a-zA-Z0-9_-]+)=(\(.*\))>/;
            n._quene = [];
            for (var o = 0; i.length > o; o++) {
                var r = i[o].match(a), s = {key: r[1], reg: r[2], source: r[0]};
                n._quene.push(s)
            }
            n._buildRegExp()
        }, n._buildRegExp = function () {
            n._regexp = n._source.source;
            for (var e = 0; n._quene.length > e; e++)n._regexp = n._regexp.replace(n._quene[e].source, n._quene[e].reg);
            n._regexp = RegExp(n._regexp, n._pattern)
        }, n.exec = function (e) {
            var t = e.match(n._regexp), i = {};
            if (t)for (var a = 0; n._quene.length > a; a++)t[a + 1] && (i[n._quene[a].key] = t[a + 1]);
            return i
        }, n.test = function (e) {
            return n._regexp.test(e)
        }, n.initialize(e, t)
    };
    n.exports = i
}), define("base.util.SWF", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.util.guid"), o = e("base.system"), r = function (e, t) {
        var n = i.parameter(t, {
            id: a(),
            width: 1,
            height: 1,
            attrs: {},
            params: {},
            vars: {},
            html: ""
        }), r = [], s = [];
        for (var l in n.attrs)r.push(l + '="' + n.attrs[l] + '"');
        for (l in n.vars)s.push(l + "=" + n.vars[l]);
        n.params.flashvars = s.join("&");
        var c = [];
        if (o.browser.ie) {
            c.push('<object id="' + n.id + '" width="' + n.width + '" height="' + n.height + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" '), c.push(r.join(" ")), c.push('><param name="movie" value="' + e + '" />');
            for (l in n.params)c.push('<param name="' + l + '" value="' + n.params[l] + '" />');
            c.push("</object>")
        } else {
            c.push('<embed id="' + n.id + '" width="' + n.width + '" height="' + n.height + '" type="application/x-shockwave-flash" src="' + e + '" '), c.push(r.join(" "));
            for (l in n.params)c.push(" " + l + '="' + n.params[l] + '" ');
            c.push(" />")
        }
        return n.html = c.join(""), n
    };
    n.exports = {
        create: function (e, t, n) {
            var i = r(t, n);
            return e.innerHTML = i.html, i.id
        }, version: function () {
            if (o.browser.ie)try {
                for (var e = 1; 12 > e; e++) {
                    var t = new ActiveXObject("ShockwaveFlash.ShockwaveFlash." + e);
                    if (t) {
                        var n = t.GetVariable("$version");
                        return n.replace(/WIN/g, "").replace(/,/g, ".")
                    }
                }
            } catch (i) {
            } else try {
                var a = navigator.plugins["Shockwave Flash"];
                return a.description.replace(/([a-zA-Z]|\s)+/, "").replace(/(\s)+r/, ".") + ".0"
            } catch (i) {
            }
            return null
        }
    }
}), define("base.util.Timer", [], function (e, t, n) {
    var i = e("base.object");
    e("base.util.guid");
    var a = function () {
        return function (e) {
            return window.setTimeout(e, self.FAST)
        }
    }(), o = function () {
        return function (e) {
            window.clearTimeout(e)
        }
    }(), r = function (e) {
        var t = this;
        return t._option = null, t._cid = 0, t._count = 0, t.startTime = 0, t.running = 0, t.FAST = 16, t.initialize = function (e) {
            var n = i.parameter(e, {
                duration: t.FAST,
                delay: 0,
                repeat: 0,
                callback: i.bind(t.empty, t),
                complete: i.bind(t.empty, t)
            });
            return t._option = n, t._option.delay = panda.isNumber(t._option.delay) ? 0 > t._option.delay ? 0 : t._option.delay : 0, t._enterFrame = a, t._cancelFrame = o, t
        }, t.setOption = function (e) {
            return t._option = i.parameter(e, t._option), t
        }, t.start = function () {
            return t.startTime = (new Date).getTime(), t.running = 0, t.lastrunning = 0, t._cid && (t.stop(t._cid), t._cid = 0), t._cid = t._enterFrame.call(window, i.bind(t.step, t)), t._signal = !0, t
        }, t.step = function () {
            if (t._signal) {
                t._cid = t._enterFrame.call(window, i.bind(t.step, t));
                var e = (new Date).getTime();
                if (t._option.delay && e - t.startTime < t._option.delay)return;
                t.running = e - t.startTime - t._option.delay;
                try {
                    if (t.running - t.lastrunning >= t._option.duration) {
                        if (t._option.repeat && (t._count++, t._count > t._option.repeat)) {
                            try {
                                t._option.complete && t._option.complete.call()
                            } catch (n) {
                                panda.stack.extractStacktrace(n, 1)
                            }
                            return t.stop()
                        }
                        t.lastrunning = t.running, t._option.callback && t._option.callback.call()
                    }
                } catch (n) {
                    panda.stack.extractStacktrace(n, 1)
                }
            }
        }, t.stop = function () {
            return t._count = 0, t._signal = !1, t._cancelFrame.call(window, t._cid), t._cid = 0, t
        }, t.reset = function () {
            return t.stop(), t.start(), t
        }, t.isPlay = function () {
            return t._cid ? !0 : !1
        }, t._empty = function () {
        }, t.initialize(e)
    };
    n.exports = r
}), define("base.util.Tweener", [], function (e, t, n) {
    var i = e("base.object"), a = e("base.query"), o = e("base.util.tweens"), r = e("base.util.Timer"), s = function (e) {
        var t = this;
        return t.target = null, t.options = null, t.timer = null, t.current = 0, t.delay = 0, t.isPlay = !1, t.initialize = function (e) {
            if (t.options = i.parameter(e, {
                    from: null,
                    to: {},
                    target: null,
                    time: 100,
                    delay: 0,
                    autoComplete: !0,
                    onStart: t._empty,
                    onEnd: t._empty,
                    onStep: t._empty,
                    onPause: t._empty,
                    onResume: t._empty,
                    type: "easeOutQuad"
                }), "string" == typeof t.options.type && ("function" != typeof o[t.options.type] && (t.options.type = "linear"), t.options.type = o[t.options.type]), null == t.options.target)throw Error("Tweener have a non-null Object to the Target");
            return null == e.from && (t.options.from = t._getFrom(t.options.target, t.options.to)), t.delay = t.options.delay, t.target = t.options.target, t
        }, t.start = function () {
            return t.holding ? t.resume() : (t.options.onStart && t.options.onStart(), null == t.timer && (t.timer = new r({
                duration: 28,
                delay: t.delay,
                callback: i.bind(t.step, t)
            })), t.timer.start(), t.isPlay = !0), t
        }, t.step = function () {
            var e = t.timer.running;
            if (t.options.time > e) {
                var n = t.options.from, i = t.options.to;
                for (var o in n)if (n.hasOwnProperty(o)) {
                    var r = i[o].charAt && "%" == i[o].charAt(i[o].length - 1) ? "%" : "", s = t.options.type(e, t._toInt(n[o], o), t._toInt(i[o]) - t._toInt(n[o], o), t.options.time);
                    s = Math.round(100 * s) / 100, panda.dom.isStyle(o) ? a(t.target).css(o, s + r) : t.target && t.target.setAttribute ? a(t.target).attr(o, s + r) : t.target[o] = s + r
                }
                t.options.onStep && t.options.onStep(t.target, e, t.options.time)
            } else t.stop()
        }, t.stop = function () {
            if (t.timer.stop(), t.isPlay = !1, t.options.autoComplete) {
                var e = t.options.to;
                for (var n in e)e.hasOwnProperty(n) && a(t.target).css(n, e[n]);
                t.options.onEnd && t.options.onEnd()
            }
            return t
        }, t.pause = function () {
            return t.timer && (t.timer.options.delay = 2592e6), t.options.onPause && t.options.onPause(), t
        }, t.resume = function () {
            return t.timer && (t.timer.options.delay = t.delay), t.options.onResume && t.options.onResume(), t
        }, t._getFrom = function (e, n) {
            var i = {};
            for (var o in n) {
                var r = a(e).css(o);
                "auto" === r && ("absolute" == a(t.target).css("position") ? "top" == o ? r = a(t.target).position().y : "left" == o && (r = a(t.target).position().x) : r = 0), i[o] = panda.dom.isStyle(o) ? r : a(e).attr(o) || 0
            }
            for (var o in i)return i;
            return null
        }, t._empty = function () {
        }, t._toInt = function (e) {
            return "string" == typeof e ? parseFloat(e) : e
        }, t.initialize(e)
    };
    n.exports = s
}), define("base.util.URL", [], function (e, t, n) {
    var i = function (e) {
        var t = this;
        return t._source = "", t._url = "", t._query = {}, t._anchor = null, t.initialize = function (e) {
            return e = e || "", t._source = e, t._url = e, t._query = {}, t.parse(), t
        }, t.parse = function (e) {
            return e && (t._source = e, t._url = e), t.parseAnchor(), t.parseParam(), t
        }, t.parseAnchor = function () {
            var e = t._url.match(/\#(.*)/);
            return e = e ? e[1] : null, t._anchor = e, null != e && (t._anchor = t.getNameValuePair(e), t._url = t._url.replace(/\#.*/, "")), t
        }, t.parseParam = function () {
            var e = t._url.match(/\?([^\?]*)/);
            return e = e ? e[1] : null, null != e && (t._url = t._url.replace(/\?([^\?]*)/, ""), t._query = t.getNameValuePair(e)), t
        }, t.getNameValuePair = function (e) {
            var t = {};
            return e.replace(/([^&=]*)(?:\=([^&]*))?/gim, function (e, n, i) {
                "" != n && (t[n] = i || "")
            }), t
        }, t.getSource = function () {
            return t._source
        }, t.getParam = function (e) {
            return t._query[e] || ""
        }, t.setParam = function (e, n) {
            if (null == e || "" == e || "string" != typeof e)throw Error("URL.setParam invalidate param.");
            return t._query = t._query || {}, t._query[e] = n, t
        }, t.clearParam = function () {
            return t._query = {}, t
        }, t.setQuery = function (e) {
            return "string" == typeof e ? (t.parse(), t._source = t._url = t._url + "?" + e, t.parse(), t) : (t._query = e, t)
        }, t.getQuery = function () {
            return t._query
        }, t.getAnchor = function () {
            return t.serialize(t._anchor)
        }, t.serialize = function (e) {
            var t = [];
            for (var n in e)null == e[n] || "" == e[n] ? t.push(n + "") : t.push(n + "=" + e[n]);
            return t.join("&")
        }, t.toString = function () {
            var e = t.serialize(t.getQuery());
            return t._url + (e.length > 0 ? "?" + e : "") + (t._anchor ? "#" + t.serialize(t._anchor) : "")
        }, t.initialize(e)
    };
    n.exports = i
}), define("base.util.guid", [], function () {
    function e(t) {
        function n(e, t) {
            if (t = t.replace(/\{|\(|\)|\}|-/g, ""), t = t.toLowerCase(), 32 != t.length || -1 != t.search(/[^0-9,a-f]/i))i(e); else for (var n = 0; t.length > n; n++)e.push(t.charAt(n))
        }

        function i(e) {
            for (var t = 32; t--;)e.push("0")
        }

        function a(t, n) {
            switch (n) {
                case"N":
                    return ("" + t).replace(/,/g, "");
                case"D":
                    var i = t.slice(0, 8) + "-" + t.slice(8, 12) + "-" + t.slice(12, 16) + "-" + t.slice(16, 20) + "-" + t.slice(20, 32);
                    return i = i.replace(/,/g, "");
                case"B":
                    var i = a(t, "D");
                    return i = "{" + i + "}";
                case"P":
                    var i = a(t, "D");
                    return i = "(" + i + ")";
                default:
                    return new e
            }
        }

        var o = [];
        "string" == typeof t ? n(o, t) : i(o), this.toString = function (e) {
            return "string" == typeof e ? "N" == e || "D" == e || "B" == e || "P" == e ? a(o, e) : a(o, "D") : a(o, "D")
        }
    }

    return function (t) {
        var n = "", i = 32;
        for (t || (t = "N"); i--;)n += Math.floor(16 * Math.random()).toString(16);
        return new e(n).toString(t)
    }
}), define("base.util.io", [], function (require, exports, module) {
    function IO(opts) {
        function _onReadyStateChange() {
            switch (self.core.readyState) {
                case 1:
                case 2:
                case 3:
                    break;
                case 4:
                    if (window && window.ued_config && "online" == window.ued_config.development)try {
                        _onResponse()
                    } catch (e) {
                        panda.stack.extractStacktrace(e, 1)
                    } else _onResponse();
                    break;
                default:
            }
        }

        function _onResponse() {
            self.options.timeoutTimer && clearTimeout(self.options.timeoutTimer);
            var _responseText = self.core.responseText;
            if (200 == self.core.status) {
                if (self.options.dataType && "json" == self.options.dataType)try {
                    eval("var response =" + (self.core.response || _responseText))
                } catch (e) {
                    var response = ""
                } else var response = self.core.response || _responseText;
                self.options.success(response)
            } else self.options.error(_responseText, self.core.statusText, self.core);
            self.options.complete(self.core.response), self.timeoutTimer && clearTimeout(self.timeoutTimer)
        }

        var self = this, _defaultCallback = function () {
        }, defaultOpts = {
            url: window.location.href,
            type: "GET",
            async: !0,
            useGzip: !1,
            noCache: !0,
            dataType: "",
            requestHeaders: {},
            core: null,
            data: {},
            timeout: 6e4,
            tId: null,
            success: _defaultCallback,
            error: _defaultCallback,
            complete: _defaultCallback,
            crossDomain: !1
        };
        return this.options = PObj.parameter(opts, defaultOpts), "script" == this.options.dataType ? (new JSONPRequest)._init(this.options) : "jsonp" == this.options.dataType ? (this.options.callbackParameter = this.options.callbackParameter || "callback", this.options.callback = this.options.callback || "_" + Guid(), (new JSONPRequest)._init(this.options)) : (this.urlObj = new PUrl(this.options.url), this.setHeader = function (e, t) {
            this.options.requestHeaders[e] = t
        }, this.parameterData = function () {
            var e = [], t = this.urlObj._query;
            for (var n in t)e.push(n + "=" + encodeURIComponent(decodeURIComponent(t[n])));
            if ("object" == typeof self.options.data)for (var i in self.options.data)self.options.data.hasOwnProperty(i) && e.push(i + "=" + self.options.data[i]); else self.options.data && e.push("" + self.options.data);
            return e.join("&")
        }, this.getNoCacheableURL = function (e, t) {
            if (t) {
                var n = e.indexOf("?") > 0 ? e + "&t=" : e + "?";
                return n + Math.round(1e4 * Math.random())
            }
            return e
        }, this.fixed = function () {
            if ("POST" == self.options.type.toUpperCase())self.options.requestHeaders.contentType ? self.setHeader("CONTENT-TYPE", self.requestHeaders.contentType) : self.setHeader("CONTENT-TYPE", "application/x-www-form-urlencoded"); else {
                var e = self.parameterData();
                e && e.length > 0 && (self.urlObj.url += "?" + self.parameterData())
            }
            self.options.useGzip && self.setHeader("Accept-Encoding", "gzip, deflate")
        }, this.done = function () {
            var e = self.urlObj._url;
            "GET" == self.options.type.toUpperCase() && (e = e + "?" + self.parameterData()), e = self.getNoCacheableURL(e, !0), self.core = this._createCore();
            try {
                self.core.id = Guid()
            } catch (t) {
            }
            self.core.onreadystatechange = _onReadyStateChange, self.core.open(self.options.type.toUpperCase(), e, !!self.options.async);
            try {
                for (var n in self.options.requestHeaders)self.core.setRequestHeader(n, self.options.requestHeaders[n])
            } catch (t) {
            }
            self.core.send("POST" == self.options.type.toUpperCase() ? self.parameterData() || null : null), self.options.async && self.options.timeout > 0 && (self.timeoutTimer = setTimeout(function () {
                self.core.abort(), self.options.error("", "timeout", self.core)
            }, self.options.timeout))
        }, this._createCore = function () {
            var e = null;
            if (window.ActiveXObject)try {
                e = new ActiveXObject("microsoft.xmlhttp")
            } catch (t) {
                e = new ActiveXObject("msxml2.xmlhttp")
            } else e = new XMLHttpRequest;
            return e
        }, this.urlObj.parse(), this.fixed(), this.done(), self)
    }

    var PObj = require("base.object"), Guid = require("base.util.guid"), JSONPRequest = require("base.util.jsonp"), PUrl = require("base.util.URL");
    module.exports = {
        ajax: function () {
            return new IO(arguments[0])
        }, jsonp: function () {
            var e = new JSONPRequest;
            e._init(arguments[0])
        }, getScript: function (e, t) {
            return this.ajax({url: e, dataType: "script", success: t})
        }
    }
}), define("base.util.jsonp", [], function (e, t, n) {
    function i() {
        this._configs = {
            STR_ASYNC: "async",
            STR_CHARSET: "charset",
            STR_CED_JSONP: "cedJsonp",
            STR_ON: "on",
            STR_ON_ERROR: "onerror",
            STR_ON_LOAD: "onload",
            STR_ON_READY_STATE_CHANGE: "onreadystatechange",
            STR_READY_STATE: "readyState",
            STR_REMOVE_CHILD: "removeChild",
            STR_SCRIPT_TAG: "<script>",
            STR_SUCCESS: "success",
            STR_ERROR: "error",
            STR_TIMEOUT: "timeout",
            STR_ID: "cedJsonp"
        }, this.lastValue = null, this.done = 0, this.stamp = 0, this._header = s.getElementsByTagName("head")[0], this._script = s.createElement("script"), this._defaultOpts = {
            success: l,
            error: l,
            complete: l,
            callback: "jsonp" + o(),
            callbackParameter: "callback"
        }
    }

    var a = e("base.object"), o = e("base.util.guid"), r = a.isWindow(window) ? window : null, s = a.isWindow(window) ? r.document : null, l = function () {
    }, c = function (e, t) {
        var n = e;
        return function () {
            return n.apply(t, arguments)
        }
    };
    i.prototype = {
        _qMarkOrAmp: function (e) {
            return /\?/.test(e) ? "&" : "?"
        }, _init: function (e) {
            this._configs.STR_ID += o(), this.options = a.parameter(e, this._defaultOpts), this.stamp = (new Date).valueOf(), this._open(), this._send()
        }, genericCallback: function (e) {
            this.lastValue = [e]
        }, _open: function () {
            var e = this;
            r.hasOwnProperty(e.options.callback) && panda.object.isFunction(r[e.options.callback]) || (r[e.options.callback] = c(e.genericCallback, e)), e._script[e._configs.STR_ON_LOAD] = e._script[e._configs.STR_ON_ERROR] = e._script[e._configs.STR_ON_READY_STATE_CHANGE] = function (t) {
                e._script[e._configs.STR_READY_STATE] && /i/.test(e._script[e._configs.STR_READY_STATE]) || (t = e.lastValue, "script" == e.options.dataType && t ? e.options.success && e.options.success() : t ? e.notifySuccess(t[0]) : e.notifyError(e._configs.STR_ERROR), e.lastValue = null, e._script[e._configs.STR_ON_LOAD] = e._script[e._configs.STR_ON_ERROR] = e._script[e._configs.STR_ON_READY_STATE_CHANGE] = null)
            }, this.options.url += panda.isEmptyObject(this.options.data) ? "" : this._qMarkOrAmp(this.options.url) + e._paramtoString(this.options.data), this.options.callbackParameter && (this.options.url += this._qMarkOrAmp(this.options.url) + encodeURIComponent(this.options.callbackParameter) + "=?"), !this.options.cache && !this.options.pageCache && (this.options.url += this._qMarkOrAmp(this.options.url) + "_" + this.stamp + "="), this.options.url = this.options.url.replace(/=\?(&|$)/, "=" + this.options.callback + "$1")
        }, _paramtoString: function (e) {
            var t = [], n = e;
            if (panda.isEmptyObject(n))return "";
            for (var i in n)t.push(i + "=" + n[i]);
            return t.join("&")
        }, _send: function () {
            this._script.src = this.options.url || "", this._script.id = this._configs.STR_ID, this._script.charset = this.options.charset || "utf-8", this._header.appendChild(this._script)
        }, notifySuccess: function (e) {
            this.done++ || (this.options.success(e), this.clearUp())
        }, notifyError: function (e) {
            this.done++ || (this.options.error(e), this.clearUp())
        }, startClientTime: function () {
            var e = this;
            this.tId = this.options.timeout > 0 && setTimeout(function () {
                e.notifyError(e.options.STR_TIMEOUT)
            }, this.options.timeout)
        }, clearUp: function () {
            this.tId && clearTimeout(this.tId), this._script[this._configs.STR_ON_READY_STATE_CHANGE] = this._script[this._configs.STR_ON_LOAD] = this._script[this._configs.STR_ON_ERROR] = null, s.getElementById(this._configs.STR_ID).parentNode && s.getElementById(this._configs.STR_ID).parentNode.removeChild(s.getElementById(this._configs.STR_ID))
        }
    }, n.exports = i
}), define("base.util.lang", [], function (e, t, n) {
    e("base.object"), e("base.string.class");
    var i = "zh-cn", a = {"zh-cn": {}};
    n.exports = {
        lang: function () {
            var e = arguments, t = i;
            return 3 == e.length && (t = e[2]), 1 == e.length ? a[t] ? a[t][e[0]] : "" : (e.length >= 2 && (this.setLangType(t), a[t][e[0]] = e[1]), void 0)
        }, setLangType: function (e) {
            i = e, a[i] === void 0 && (a[i] = {})
        }
    }
}), define("base.util.template", [], function () {
    var e = function (e) {
        var t = this;
        return t.html = "", t.initialize = function (e) {
            return e === void 0 && (e = ""), e instanceof Array && (e = e.join("")), t.html = e, t
        }, t.expand = function (e) {
            var t = !0, n = this.html;
            if (!e)return "" + n;
            var i = /\{([^\s{}]+?)\}/gi;
            return n = n.replace(i, function (n, i) {
                return e.hasOwnProperty(i) ? e[i] : t ? n : ""
            })
        }, t.initialize(e)
    };
    return {
        create: function (t) {
            return new e(t)
        }
    }
}), define("base.util.tweens", [], function (e, t, n) {
    n.exports = {
        linear: function (e, t, n, i) {
            return n * e / i + t
        }, easeInQuad: function (e, t, n, i) {
            return n * (e /= i) * e + t
        }, easeOutQuad: function (e, t, n, i) {
            return -n * (e /= i) * (e - 2) + t
        }, easeInOutQuad: function (e, t, n, i) {
            return 1 > (e /= i / 2) ? n / 2 * e * e + t : -n / 2 * (--e * (e - 2) - 1) + t
        }, easeInCubic: function (e, t, n, i) {
            return n * (e /= i) * e * e + t
        }, easeOutCubic: function (e, t, n, i) {
            return n * ((e = e / i - 1) * e * e + 1) + t
        }, easeInOutCubic: function (e, t, n, i) {
            return 1 > (e /= i / 2) ? n / 2 * e * e * e + t : n / 2 * ((e -= 2) * e * e + 2) + t
        }, easeInQuart: function (e, t, n, i) {
            return n * (e /= i) * e * e * e + t
        }, easeOutQuart: function (e, t, n, i) {
            return -n * ((e = e / i - 1) * e * e * e - 1) + t
        }, easeInOutQuart: function (e, t, n, i) {
            return 1 > (e /= i / 2) ? n / 2 * e * e * e * e + t : -n / 2 * ((e -= 2) * e * e * e - 2) + t
        }, easeInQuint: function (e, t, n, i) {
            return n * (e /= i) * e * e * e * e + t
        }, easeOutQuint: function (e, t, n, i) {
            return n * ((e = e / i - 1) * e * e * e * e + 1) + t
        }, easeInOutQuint: function (e, t, n, i) {
            return 1 > (e /= i / 2) ? n / 2 * e * e * e * e * e + t : n / 2 * ((e -= 2) * e * e * e * e + 2) + t
        }, easeInSine: function (e, t, n, i) {
            return -n * Math.cos(e / i * (Math.PI / 2)) + n + t
        }, easeOutSine: function (e, t, n, i) {
            return n * Math.sin(e / i * (Math.PI / 2)) + t
        }, easeInOutSine: function (e, t, n, i) {
            return -n / 2 * (Math.cos(Math.PI * e / i) - 1) + t
        }
    }
}), define("base.widget.Widget", [], function (e, t, n) {
    var i = e("base.util.guid"), a = function () {
        var t = this;
        return t.manager = e("base.widget.WidgetManager"), t.name = "Widget_" + i(), t.publishList = [], t.notifyList = [], t.uiType = null, t.initialize = function () {
            return t.manager.add({
                name: t.name,
                publishList: t.publishList,
                notifyList: t.notifyList,
                type: t.uiType,
                target: t
            }), t
        }, t.init = function () {
        }, t.render = function () {
        }, t.destroy = function () {
        }, t.notify = function () {
        }, t.publish = function (e, n) {
            t.manager && t.manager.publish(t, e, n)
        }, t.initialize()
    };
    n.exports = a
}), define("base.widget.WidgetManager", [], function (e, t, n) {
    var i = function () {
        var e = this;
        return e._types = {}, e._list = {}, e._dispatcher = {}, e.add = function (e) {
            if (!e || !e.target)throw Error("Can't added a null Object to WidgetManager");
            "array" != typeof this._types[e.type] && (this._types[e.type] = []), this._types[e.type].push(e), this._list[e.name] = e;
            for (var t = 0; e.notifyList.length > t; t++)"array" != typeof this._dispatcher[e.notifyList[t]] && (this._dispatcher[e.notifyList[t]] = []), this._dispatcher[e.notifyList[t]].push(e.name);
            return e.target
        }, e.remove = function (e) {
            var t = null;
            "string" == typeof e && (t = this._list[ui]), "object" == typeof e && (t = this._list[ui.name]);
            for (var n = 0; this._types[t.type].length > n; n++)if (this._types[t.type][n] && this._types[t.type][n].name == t.name) {
                this._types[t.type].splice(n, 1);
                break
            }
            for (var i in this._list)if (this._list[i] && this._list[i].name == t.name) {
                delete this._list[i];
                break
            }
            return t.target && t.target.destroy && t.target.destroy(), t
        }, e.get = function (e, t) {
            var n = null;
            return n = new e, n.init(t), n
        }, e.getByName = function (e) {
            return this._list[e].target
        }, e.getByType = function (e) {
            return this._types[e]
        }, e.publish = function (e, t, n) {
            panda(e.publishList).index(t) > -1 && this.dispatch(t, n)
        }, e.dispatch = function (e, t) {
            if (this._dispatcher[e] && this._dispatcher[e]instanceof Array)for (var n = 0; this._dispatcher[e].length > n; n++) {
                var i = this.getByName(this._dispatcher[e][n]);
                i && i.notify.call(i, e, t)
            }
        }, e
    };
    n.exports = new i
}), function (e) {
    window.cube = window.cube || {}, cube.follow = function (t) {
        this.options = e.parameter(t, {
            sid: "",
            shopId: "",
            host: "http://easy.jd.com/",
            loginUrl: "http://m.jd.com/user/login.action"
        })
    }, cube.follow.prototype = {
        constructor: cube.follow, getSID: function () {
            return this.options.sid
        }, login: function () {
            var t = e.dom.create("<form action='" + this.options.loginUrl + "' method='get'></form>");
            e("body").append(t), t.submit()
        }, getFollowCount: function (t, n) {
            var i = {shopId: this.options.shopId, sid: this.options.sid};
            e.ajax({
                url: this.options.host + "/follow/getFollowCount.html",
                type: "GET",
                dataType: "jsonp",
                data: i,
                success: function (n) {
                    n && t && e.isFunction(t) && t(n.count)
                },
                error: function (t) {
                    n && e.isFunction(n) && n(t)
                }
            })
        }, isFollow: function (t, n) {
            var i = {shopId: this.options.shopId, sid: this.options.sid};
            e.ajax({
                url: this.options.host + "/follow/isFollow.html",
                type: "GET",
                dataType: "jsonp",
                data: i,
                success: function (n) {
                    n && n.success && e.isFunction(t) && t(n.state)
                },
                error: function (t) {
                    n && e.isFunction(n) && n(t)
                }
            })
        }, join: function (t, n) {
            var i = this;
            if (this.options.sid) {
                var a = {shopId: this.options.shopId, sid: this.options.sid};
                e.ajax({
                    url: this.options.host + "/follow/doFollow.html",
                    type: "GET",
                    dataType: "jsonp",
                    data: a,
                    success: function (a) {
                        a && 0 == a.state && a.success ? i.getFollowCount(t, function () {
                            e.isFunction(n) && n("��ע�ɹ�����ȡ��ǰ�̼ҹ�ע��ʧ�ܣ�")
                        }) : a && 1 == a.state ? i.login() : e.isFunction(n) && n(a)
                    },
                    error: function (t) {
                        n && e.isFunction(n) && n(t)
                    }
                })
            } else this.login()
        }, quite: function (t, n) {
            var i = this;
            if (this.options.sid) {
                var a = {shopId: this.options.shopId, sid: this.options.sid};
                e.ajax({
                    url: this.options.host + "/follow/unfollow.html",
                    type: "GET",
                    dataType: "jsonp",
                    data: a,
                    success: function (a) {
                        a && 0 == a.state && a.success ? e.isFunction(t) && t() : a && 1 == a.state ? i.login() : e.isFunction(n) && n(a)
                    },
                    error: function (t) {
                        n && e.isFunction(n) && n(t)
                    }
                })
            } else this.login()
        }
    }
}(panda), panda(function () {
    panda("[data-url]").each(function (e) {
        panda(e).attr("data-url") && panda(e).on("click", function () {
            var e = decodeURIComponent(panda(this).attr("data-url"));
            e && 0 != e.indexOf("http://") && (e = "http://" + e), window.location.href = e
        })
    });
    try {
        top.page_data = top.page_data || {}
    } catch (e) {
    }
    var t = function () {
        for (var e = document.cookie, t = e.split(";"), n = null, i = 0, a = t.length; a > i; i++)if (n = t[i].split("="), " sid" === n[0])return n[1];
        return ""
    }, n = "";
    if (t())n = t(); else {
        var i = panda.util.URL(window.location.href);
        n = i.getParam("sid")
    }
    var a = panda("a i.icon-follow68").parent(), o = "";
    try {
        o = top.page_data.shopId || ""
    } catch (e) {
        page_data && page_data.shopId && (o = page_data.shopId)
    }
    var r = new cube.follow({shopId: o || 0, sid: n || 0});
    a.length && (r.isFollow(function (e) {
        "0" == e ? (a.addClass("active"), r.getFollowCount(function (e) {
            a.find("span").html(e || 0)
        }, function () {
            a.find("span").html("关注")
        })) : (a.removeClass("active"), a.find("span").html("关注"))
    }), a.on("click", function () {
        var e = this;
        panda(this).hasClass("active") ? r.quite(function () {
            panda(e).toggleClass("active"), a.find("span").html("关注")
        }) : r.join(function (t) {
            panda(e).toggleClass("active"), a.find("span").html(t || 0)
        })
    }))
}), panda(function () {
    function e() {
        try {
            var e = 0;
            panda("#content_dom").children().each(function (t) {
                var n = panda(t);
                if (n.hasClass("row") && !n.hasClass("c-category-list")) {
                    e += panda(t).height();
                    var i = parseInt(panda(t).css("margin-top"), 10);
                    i && (e += i);
                    var a = parseInt(panda(t).css("margin-bottom"), 10);
                    a && (e += a)
                }
            }), e && HTMLOUT.getContentHeight(e)
        } catch (t) {
        }
    }

    window.HTMLOUT && (setInterval(e, 800), e())
}), panda(function () {
    function e() {
        window.history.back()
    }

    var t = panda(".icon-return"), n = panda(".c-error .return");
    n.un("click").on("click", function () {
        e()
    }), t.on("click", function () {
        e()
    });
    var i = panda(".c-activity-rule .icon-down"), a = panda(".c-activity-rule .txt");
    a.find("span").width() > a.width() ? (i.css({display: "block"}), i.on("click", function () {
        panda(".c-activity-rule .txt").toggleClass("active")
    })) : i.css({display: "none"})
}), function (e, t) {
    function n(e) {
        if (e) {
            var t = "暂无报价";
            JD_pirce.setJdPrice(e, t)
        }
    }

    function i(e) {
        if (!e.size())throw Error("priceUnique:arguments error.");
        var n = {}, i = [], a = [];
        return e.each(function (e, o) {
            if ("undefined" != typeof jQuery) {
                var r = e;
                e = o, o = r
            }
            var s = t(e), l = s.attr("jdprice") || s.attr("jsprice") || s.attr("jskuprice");
            void 0 == n[l] ? (i.push(e), n[l] = s.position().top, a.push(l)) : n[l] > s.position().top && (i[panda(a).indexOf(l)] = e, n[l] = s.position().top)
        }), i
    }

    function a() {
        var e = (document.documentElement.scrollTop || document.body.scrollTop) + t(window).height();
        if (0 !== u.length) {
            for (var n = [], i = 0, a = u.length; a > i; i++) {
                var r = t(u[i]);
                if (e > r.position().top) {
                    var s = r.attr("jdprice") || r.attr("jsprice") || r.attr("jskuprice");
                    s && (f += "J_" + s + ",", h++, h === g && o())
                } else n.push(r)
            }
            f && o(), u = n, delete n, u.length || t(window).unbind("click,reseize", arguments.callee)
        }
    }

    function o() {
        var e = f.substr(f, f.length - 1);
        e && r(e), h = 0, f = ""
    }

    function r(e) {
        var t = document.createElement("script");
        t.setAttribute("src", d + e + p), document.getElementsByTagName("head")[0].appendChild(t)
    }

    function s() {
        t(window).on("scroll", a), t(window).on("resize", a)
    }

    function l(e) {
        e.length > 0 && (u = i(e), a(), s())
    }

    function c() {
        var e = t('span[jshop="price"]');
        l(e)
    }

    JD_pirce = {
        setJdPrice: function (e, n) {
            var i = e.p >= 0 ? e.p : n;
            t('[jdprice="' + e.id + '"]').each(function (e, n) {
                if ("undefined" != typeof jQuery) {
                    var a = e;
                    e = n, n = a
                }
                "暂无报价" == i ? t(e).html(i) : t(e).html("￥" + i)
            })
        }
    }, e.callBackPriceService = function (e) {
        var i = 0;
        t(e).each(function (e, t) {
            if ("undefined" != typeof jQuery) {
                var a = e;
                e = t, t = a
            }
            i = e.id.substr(2), e.id = i, n(e)
        })
    };
    var u = [], d = "http://p.3.cn/prices/mgets?skuids=", p = "&type=2&callback=callBackPriceService", h = 0, f = "", g = 20;
    t(function () {
        c()
    }), window.ShopPrice = {init: c, run: l}
}(window, $ || panda), function (e, t) {
    function n() {
        function e(e) {
            a.shopId && setTimeout(function () {
                switch (e) {
                    case 0:
                        alert("非常抱歉，此商家暂未开通在线客服功能！");
                        break;
                    case 1:
                        window.location.href = "http://im.m.jd.com/shop/index?v=t&shopId" + a.shopId + "&sid" + i.common.getSid();
                        break;
                    case 2:
                        alert("商家客服不在线哦，稍后再来咨询吧！");
                        break;
                    case 3:
                        alert("商家客服不在线，您可以点击留言！");
                        break;
                    default:
                        alert("手机IM网络异常，请稍后再来咨询吧！")
                }
            }, 600)
        }

        function n() {
            var n = null;
            a.shopId ? n = "shopId=" + a.shopId : a.brandName ? (n = "brandName" + encodeURIComponent(encodeURIComponent(a.brandName)), a.rank3 && (n = "rank3=" + a.rank3 + "&" + n)) : a.pid ? n = "pid=" + a.pid : a.groupId && (n = "virtualId=" + a.groupId), a.form && (n = "form=" + a.form + "&" + n), n && t.ajax({
                url: "http://" + o + "/api/checkChat?" + n + (a.charset ? "&returnCharset=" + a.charset : ""),
                dataType: "jsonp",
                success: function (t) {
                    if (t) {
                        var n = t.code, i = t.seller;
                        i && (i = i.replace("&qt;", "'").replace("&dt;", '"')), 1 === n || 2 === n ? (a.onlineCall(i), a.iconObj.on("click", function () {
                            e(n, t)
                        })) : 3 === n || 9 === n ? (a.leaveMessageCall(i), a.iconObj.on("click", function () {
                            e(3, t)
                        })) : a.iconObj.on("click", function () {
                            e(0, t)
                        })
                    }
                }
            })
        }

        var a = null, o = "chat1.jd.com";
        this.show = function (e) {
            a = e, n()
        }
    }

    var i = i || {};
    i.common = {
        getSid: function () {
            for (var e = document.cookie, t = e.split(";"), n = null, i = 0, a = t.length; a > i; i++)if (n = t[i].split("="), " sid" === n[0])return n[1];
            return ""
        }
    }, window.template = i, i.common.im = new n, t(function () {
        var e = t(".j-m-im");
        try {
            if (!top.page_data || !top.page_data.shopId)return;
            var n = top.page_data.shopId
        } catch (a) {
            return
        }
        i.common.im.show({
            iconObj: e, shopId: n, onlineCall: function () {
                e.find("a").removeClass("disable"), e.attr("title", "点击我向商家咨询相关问题！")
            }, offlineCall: function () {
                e.find("a").addClass("disable"), e.attr("title", "商家客服不在线哦，稍后再来咨询吧！")
            }, leaveMessageCall: function () {
            }
        })
    })
}(window, panda), function (e, t) {
    var n = function (e) {
        function n() {
            e && (l = t(e), l.size() && (i(), a(), s(!0)))
        }

        function i() {
            l.each(function (e) {
                e = t(e), e.data("lly_pos", e.position()).attr("loaded", "no");
                var n = e.attr("srcset");
                if (n = n ? n.split(/\s*,\s*/) : "", e.data("lly_imgs", {}), n.length) {
                    for (var i = {}, a = 0, o = n.length; o > a; a++) {
                        var r = [];
                        r = n[a].split(/\s+/), i[parseInt(r[1], 10)] = r[0]
                    }
                    e.data("lly_imgs", i)
                }
            })
        }

        function a() {
            t(window).on("scroll", o), t(window).on("resize", r)
        }

        function o() {
            var e = (t(window), (document.documentElement.scrollTop || document.body.scrollTop) + document.documentElement.clientHeight);
            e > c && (c = e, s(!1))
        }

        function r() {
            var e = window.innerWidth;
            e != u && (u = e, s(!0)), t(window).trigger("scroll")
        }

        function s(e) {
            l.each(function (n) {
                if (n = t(n), e) {
                    n.attr("loaded", "no");
                    var i = n.data("lly_imgs"), a = [];
                    for (var o in i)a.push(parseInt(o, 10));
                    a.sort(function (e, t) {
                        return e - t
                    });
                    for (var r = !1, s = 0, l = a.length; l > s; s++)if (a[s] >= u) {
                        n.attr("srcd", i[a[s]] + ""), r = !0;
                        break
                    }
                    r === !1 && n.attr("srcd", i[a[a.length - 1] + ""])
                }
                var d = n.data("lly_pos").top || n.data("lly_pos").y;
                n.attr("loaded") && c + 160 >= d && n.attr("src") !== n.attr("srcd") && (n.attr("srcd") ? n.attr("src", n.attr("srcd")).removeAttr("loaded") : n.removeAttr("loaded"))
            })
        }

        var l = null, c = (document.documentElement.scrollTop || document.body.scrollTop) + document.documentElement.clientHeight, u = t(window).width();
        n()
    };
    t(function () {
        n("img[srcset]")
    })
}(window, panda), function (e) {
    var t = {
        cdnMap: ["img10", "img11", "img12", "img13", "img14", "img20", "img30"], maxtry: 0, init: function () {
            function t(e) {
                e.on("error", function (e) {
                    panda.object.bind(n.loadErrorHandler, n, e)()
                }).on("load", function (e) {
                    panda.object.bind(n.loadComplete, n, e)()
                })
            }

            var n = this;
            n.maxtry = n.cdnMap.length, t(e("img[srcset]"));
            try {
                document.addEventListener("DOMNodeInserted", function (n) {
                    "img" == n.target.nodeName.toLowerCase() && t(e(n.target))
                })
            } catch (i) {
            }
        }, loadComplete: function (t) {
            "img" == t.target.nodeName.toLowerCase() && this.dispose(e(t.target))
        }, loadErrorHandler: function (t) {
            var n = this;
            if ("img" == t.target.nodeName.toLowerCase()) {
                var i = e(t.target);
                if (0 == i.length)return;
                var a = i.data("loadError"), o = !1, r = i.attr("src");
                if (!r)return;
                if (a) {
                    var s = a.count;
                    s + 1 > this.maxtry ? n.dispose(i) : (a.count = a.count + 1, o = !0)
                } else i.data("loadError", {
                    count: 1,
                    url: "http://$staticcdn" + r.substring(r.indexOf("."), r.length)
                }), a = i.data("loadError"), o = !0;
                o && setTimeout(function () {
                    i.attr("src", a.url.replace("$staticcdn", n.cdnMap[a.count - 1]))
                }, 1500)
            }
        }, dispose: function (e) {
            e.removeData("loadError")
        }
    };
    e(function () {
        t.init()
    })
}(panda);