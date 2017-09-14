/*! Intimidatetime - v0.2.0 - 2014-07-08
* http://trentrichardson.com/examples/Intimidatetime
* Copyright (c) 2014 Trent Richardson; Licensed MIT */
(function(e) {
  "use strict";
  e.intimidatetime = function(e, t) {
    return this.constructor(e, t)
  },
  e.extend(e.intimidatetime.prototype, {
    constructor: function(t, i) {
      var n, a, s = new Date;
      this.settings = e.intimidatetime.extend({},
      e.intimidatetime.i18n[""], e.intimidatetime.defaults, i),
      a = this.settings,
      null !== a.mode && void 0 !== e.intimidatetime.modes[a.mode] && e.intimidatetime.extend(a, e.intimidatetime.modes[a.mode]),
      a.previewFormat = a.previewFormat || a.format,
      a.support = e.intimidatetime.detectSupport(a.format + " " + a.previewFormat);
      for (n in a.units) void 0 === a.units[n].show && (a.units[n].show = a.support[n]);
      if (this.$el = t, this.$p = null, this.$w = e(window), this.$d = e(document), n = this.$el.val(), void 0 !== n && "" !== n && (a.value = e.intimidatetime.dateRangeParse(n, a.format, a.rangeDelimiter, a)), null === a.value && (a.value = [new Date(s.getTime())]), e.isArray(a.value) || (a.value = [a.value]), a.ranges > a.value.length - 1) for (n = 0; a.ranges > n; n += 1) s.setDate(s.getDate() + 1),
      a.value.push(new Date(s.getTime()));
      return this.enable(),
      this
    },
    enable: function() {
      var e, t = this,
      i = t.settings;
      for (e in t.settings.events) t.$el.on("intimidatetime:" + e, i.events[e]);
      return t.refresh(),
      t.settings.inline ? t.open() : (t.$el.on("keyup.intimidatetime paste.intimidatetime",
      function(e) {
        setTimeout(function() {
          t._inputChange(e)
        },
        0)
      }), t.$el.on("focus.intimidatetime",
      function() {
        t.open()
      }), t.$d.on("click.intimidatetime",
      function(e) {
        var i = e.target;
        t.$el[0] !== i && t.$p[0] !== i && 0 === t.$p.has(i).length && t.close()
      }), t.$w.on("resize.intimidatetime",
      function() {
        t._reposition()
      })),
      t.$el
    },
    disable: function() {
      return this.$el.off(".intimidatetime"),
      this.$d.off(".intimidatetime"),
      this.$w.off(".intimidatetime"),
      this.$el
    },
    destroy: function() {
      return this.disable(),
      this.$el.removeData("intimidatetime"),
      this.$p.remove(),
      this.$el
    },
    open: function() {
      var t = this,
      i = new e.Event("intimidatetime:open"),
      n = t.$el.trigger(i, [t]);
      return void 0 !== n.isDefaultPrevented && n.isDefaultPrevented() || t.$p.show(),
      t.$el
    },
    close: function() {
      var t = this,
      i = new e.Event("intimidatetime:close"),
      n = t.$el.trigger(i, [t]);
      return void 0 !== n.isDefaultPrevented && n.isDefaultPrevented() || t.$p.hide(),
      t.$el
    },
    option: function(e, t) {
      var i = this.settings;
      return void 0 !== t ? (i[e] = t, this.$el) : i[e]
    },
    value: function(t) {
      var i = this,
      n = i.settings;
      return void 0 !== t ? (n.value = e.isArray(t) ? t: [t], i._validateRanges(), i.$el.val(e.intimidatetime.dateRangeFormat(n.value, n.format, n.rangeDelimiter, n)), i._updatePickerRanges(), i.$el) : 1 === n.value.length ? n.value[0] : n.value
    },
    refresh: function() {
      var t, i, n, a, s, r, o, l, m, u, d, c, p = this,
      h = p.settings;
      for (null === p.$p && (t = [h.theme, h.theme + "-mode-" + h.mode], h.rtl && t.push(h.theme + "-rtl"), h.support.date && t.push(h.theme + "-hasDate"), h.support.time && t.push(h.theme + "-hasTime"), p.$p = e('<div class="' + t.join(" ") + '"></div>'), h.inline ? (p.$p.addClass(h.theme + "-inline"), p.$el.append(p.$p)) : (p.$p.css("display", "none"), p.$el.after(p.$p))), p.$p.empty(), n = 0; h.ranges >= n; n += 1) for (i = e('<div class="' + h.theme + "-range " + h.theme + "-range-" + n + '"><div class="' + h.theme + '-preview">' + e.intimidatetime.dateFormat(h.value[n], h.previewFormat, h) + "</div></div>").appendTo(p.$p), a = 0, s = h.groups.length; s > a; a += 1) {
        for (r = h.groups[a], c = 0, u = e('<div class="' + h.theme + "-group " + h.theme + "-group-" + r.name + '"></div>').appendTo(i), o = 0, l = r.units.length; l > o; o += 1) m = r.units[o],
        h.support[m] && (c++, d = e('<div class="' + h.theme + "-unit " + h.theme + "-unit-" + h.units[m].type + " " + h.theme + "-unit-" + m + '" data-range="' + n + '" data-unit="' + m + '"></div>').appendTo(u), e.intimidatetime.types[h.units[m].type].create(p, d, h.value[n]));
        0 === c && u.remove()
      }
      if (l = h.buttons.length, l > 0) for (u = e('<div class="' + h.theme + '-buttons"></div>').appendTo(p.$p), o = 0; l > o; o += 1) m = h.buttons[o],
      m.tag = m.tag || "button",
      m.classes = m.classes || "",
      e("<" + m.tag + ' href="javascript:void();" class="' + h.theme + "-button-" + o + " " + m.classes + '">' + m.text + "</" + m.tag + ">").on("click.intimidatetime", m.action).appendTo(u);
      return h.inline || p._reposition(),
      p.$el.trigger("intimidatetime:refresh", [p]),
      p.$el
    },
    _reposition: function() {
      var t = this,
      i = t.$el.position(),
      n = function(e) {
        var t = {
          w: e.width(),
          h: e.height()
        },
        i = function(t) {
          var i = e.css(t);
          return i ? 1 * i.replace("px", "") : 0
        };
        return t.w += i("padding-left") + i("padding-right") + i("border-left-width") + i("border-right-width"),
        t.h += i("padding-top") + i("padding-bottom") + i("border-top-width") + i("border-bottom-width"),
        t
      },
      a = n(t.$el),
      s = n(t.$p),
      r = n(e(document.body)),
      o = i.top + a.h,
      l = i.left;
      return o + s.h > r.h && i.top - s.h > 0 && (o = i.top - s.h),
      l + s.w > r.w && (l = r.w - s.w),
      t.$p.css({
        top: o,
        left: l
      }),
      t.$el
    },
    _inputChange: function(t) {
      var i, n, a = this,
      s = a.settings,
      r = e.intimidatetime.dateRangeParse(a.$el.val(), s.format, s.rangeDelimiter, s);
      if (r && r.length === s.ranges + 1) {
        if (i = new e.Event("intimidatetime:change"), n = a.$el.trigger(i, [a, r]), n.isDefaultPrevented && n.isDefaultPrevented()) return t.preventDefault(),
        !1;
        s.value = r,
        a.refresh()
      }
      return this.$el
    },
    _change: function(t) {
      var i = this,
      n = (i.settings, i._collectPickerRanges()),
      a = new e.Event("intimidatetime:change"),
      s = i.$el.trigger(a, [i, n]);
      return s.isDefaultPrevented && s.isDefaultPrevented() ? (t.preventDefault(), !1) : (i.value(n), i.$el)
    },
    _validateRanges: function() {
      var t, i, n, a, s = this,
      r = s.settings,
      o = e.isArray(r.value) ? r.value.length: 0;
      if (o > 0) for (t = "string" == typeof r.min ? e.intimidatetime.dateRelative(new Date, r.min) : r.min, i = "string" == typeof r.max ? e.intimidatetime.dateRelative(new Date, r.max) : r.max, n = 0; o > n; n++) t && t > r.value[n] ? r.value[n] = t: i && r.value[n] > i && (r.value[n] = i),
      n > 0 && ("string" == typeof r.rangeIntervalMin && (a = e.intimidatetime.dateRelative(r.value[n - 1], r.rangeIntervalMin), a > r.value[n] && (r.value[n] = a)), "string" == typeof r.rangeIntervalMax && (a = e.intimidatetime.dateRelative(r.value[n - 1], r.rangeIntervalMax), r.value[n] > a && (r.value[n] = a)));
      return s
    },
    _collectPickerRanges: function() {
      var t = this,
      i = t.settings,
      n = [],
      a = {
        year: 0,
        month: 0,
        day: 0,
        hour: 0,
        minute: 0,
        second: 0,
        millisecond: 0,
        microsecond: 0
      };
      return t.$p.children("." + i.theme + "-range").each(function(s, r) {
        var o, l = e(r),
        m = e.intimidatetime.extend({},
        a);
        l.find("." + i.theme + "-unit").each(function(n, a) {
          var s = e(a),
          r = s.data("unit");
          m[r] = e.intimidatetime.types[i.units[r].type].value(t, s)
        }),
        o = new Date(m.year, m.month, m.day, m.hour, m.minute, m.second, m.millisecond),
        o.setMicroseconds(m.microsecond),
        void 0 !== m.timezone && o.setTimezone(m.timezone),
        n[s] = o
      }),
      n
    },
    _updatePickerRanges: function() {
      var t = this,
      i = t.settings;
      return t.$p.children("." + i.theme + "-range").each(function(n, a) {
        var s = e(a),
        r = i.value[n];
        s.find("." + i.theme + "-unit").each(function(n, a) {
          var s = e(a),
          o = s.data("unit");
          e.intimidatetime.types[i.units[o].type].value(t, s, r["get" + i.units[o].map]())
        }),
        s.children("." + i.theme + "-preview").text(e.intimidatetime.dateFormat(r, i.previewFormat, i))
      }),
      t.$el
    }
  }),
  e.extend(e.intimidatetime, {
    i18n: {
      "": {
        format: "yyyy-MM-dd HH:mm",
        units: {
          year: {
            format: "yyyy",
            label: "Year"
          },
          month: {
            format: "MMM",
            label: "Month",
            names: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            namesAbbr: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
          },
          day: {
            format: "d",
            label: "Day",
            names: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            namesAbbr: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            namesHead: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
          },
          hour: {
            format: "HH",
            label: "Hour",
            am: ["AM", "A"],
            pm: ["PM", "P"]
          },
          minute: {
            format: "mm",
            label: "Minute"
          },
          second: {
            format: "ss",
            label: "Second"
          },
          millisecond: {
            format: "l",
            label: "Millisecond"
          },
          microsecond: {
            format: "c",
            label: "Microsecond"
          },
          timezone: {
            format: "z",
            label: "Timezone"
          }
        },
        rtl: !1
      }
    },
    defaults: {
      value: null,
      previewFormat: null,
      altFormat: null,
      alt: null,
      min: null,
      max: null,
      ranges: 0,
      rangeDelimiter: " - ",
      rangeIntervalMin: "+0l",
      rangeIntervalMax: null,
      months: 1,
      startOfWeek: 0,
      inline: !1,
      theme: "intimidatetime",
      mode: "basic",
      units: {
        year: {
          map: "FullYear",
          type: "select",
          range: 20,
          step: 1,
          format: "yyyy",
          value: null
        },
        month: {
          map: "Month",
          type: "select",
          min: 0,
          max: 11,
          step: 1,
          format: "MMM",
          value: null
        },
        day: {
          map: "Date",
          type: "select",
          min: 1,
          max: 31,
          step: 1,
          value: null
        },
        hour: {
          map: "Hours",
          type: "select",
          min: 0,
          max: 23,
          step: 1,
          value: null
        },
        minute: {
          map: "Minutes",
          type: "select",
          min: 0,
          max: 59,
          step: 1,
          value: null
        },
        second: {
          map: "Seconds",
          type: "select",
          min: 0,
          max: 59,
          step: 1,
          value: null
        },
        milli: {
          map: "Milliseconds",
          type: "select",
          min: 0,
          max: 999,
          step: 10,
          value: null
        },
        micro: {
          map: "Microseconds",
          type: "select",
          min: 0,
          max: 999,
          step: 10,
          value: null
        },
        timezone: {
          map: "Timezone",
          type: "select",
          value: null,
          options: [720, 660, 600, 570, 540, 480, 420, 360, 300, 270, 240, 210, 180, 120, 60, 0, -60, -120, -180, -210, -240, -270, -300, -330, -345, -360, -390, -420, -480, -525, -540, -570, -600, -630, -660, -690, -720, -765, -780, -840],
          names: {}
        }
      },
      groups: [{
        name: "date",
        units: ["year", "month", "day"]
      },
      {
        name: "time",
        units: ["hour", "minute", "second", "millisecond", "microsecond", "timezone"]
      }],
      buttons: [],
      events: {
        change: function() {},
        refresh: function() {},
        enableDay: function() {},
        open: function() {},
        close: function() {}
      }
    },
    setDefaults: function(t) {
      return e.intimidatetime.extend(e.intimidatetime.defaults, t || {}),
      this
    },
    modes: {
      basic: {},
      horizontal: {},
      vertical: {}
    },
    types: {
      label: {
        create: function(t, i, n) {
          var a = t.settings,
          s = i.data("unit"),
          r = a.units[s],
          o = '<label class="unit-label unit-label-' + s + '">';
          "" !== r.label && r.label !== !1 && (o += "<span>" + r.label + "</span>"),
          o += e.intimidatetime.dateFormat(n, r.format, a),
          o += "</label>",
          i.html(o)
        },
        option: function() {},
        value: function() {}
      },
      list: {
        create: function(t, i, n) {
          n = void 0 === n || "Invalid Date" == "" + n ? new Date: n;
          var a, s, r, o = t.settings,
          l = i.data("unit"),
          m = o.units[l],
          u = e('<label class="unit-label unit-label-' + l + '"></label>'),
          d = e('<input type="hidden" class="unit-input unit-input-' + l + '" value="" />'),
          c = e('<ul class="unit-list unit-list-' + l + '"></ul>'),
          p = n["get" + m.map](),
          h = e.intimidatetime.dateClone(n),
          f = m.max,
          g = m.min,
          v = "";
          if (("year" === l || "month" === l) && (n.setDate(1), h.setDate(1), p = n["get" + m.map]()), "day" === l && (a = e.intimidatetime.daysInMonth(n.getMonth(), n.getFullYear()), f > a && (f = a)), void 0 !== m.range && (void 0 === g && (g = n.getFullYear() - m.range), void 0 === f && (f = n.getFullYear() + m.range)), m.options) for (s = 0, r = m.options.length; r > s; s += 1) h["set" + m.map](m.options[s]),
          v += '<li><a href="#" data-value="' + m.options[s] + '" class="' + (m.options[s] === p ? "selected": "") + '">' + e.intimidatetime.dateFormat(h, m.format, o) + "</a></li>";
          else for (s = g; f >= s; s += m.step) h["set" + m.map](s),
          v += '<li><a href="#" data-value="' + s + '" class="' + (s === p ? "selected": "") + '">' + e.intimidatetime.dateFormat(h, m.format, o) + "</a></li>";
          "" !== m.label && m.label !== !1 && u.append("<span>" + m.label + "</span>"),
          d.val(p),
          c.on("click.intimidatetime", "a",
          function(i) {
            i.preventDefault(),
            c.find("a.selected").removeClass("selected"),
            d.val(e(this).addClass("selected").data("value")),
            t._change.call(t, i)
          }),
          u.append(d).appendTo(i),
          c.html(v).appendTo(i)
        },
        option: function() {},
        value: function(e, t, i) {
          var n = t.find("input");
          return void 0 !== i ? (n.val(i), t) : n.val()
        }
      },
      select: {
        create: function(t, i, n) {
          n = void 0 === n || "Invalid Date" == "" + n ? new Date: n;
          var a, s, r, o = t.settings,
          l = i.data("unit"),
          m = o.units[l],
          u = e('<label class="unit-label unit-label-' + l + '"></label>'),
          d = e('<select class="unit-input unit-input-' + l + '"></select>'),
          c = n["get" + m.map](),
          p = e.intimidatetime.dateClone(n),
          h = m.max,
          f = m.min,
          g = "";
          if (("year" === l || "month" === l) && (n.setDate(1), p.setDate(1), c = n["get" + m.map]()), "day" === l && (a = e.intimidatetime.daysInMonth(n.getMonth(), n.getFullYear()), h > a && (h = a)), void 0 !== m.range && (void 0 === f && (f = n.getFullYear() - m.range), void 0 === h && (h = n.getFullYear() + m.range)), m.options) for (s = 0, r = m.options.length; r > s; s += 1) p["set" + m.map](m.options[s]),
          g += '<option value="' + m.options[s] + '">' + e.intimidatetime.dateFormat(p, m.format, o) + "</option>";
          else for (s = f; h >= s; s += m.step) p["set" + m.map](s),
          g += '<option value="' + s + '">' + e.intimidatetime.dateFormat(p, m.format, o) + "</option>";
          "" !== m.label && m.label !== !1 && u.append("<span>" + m.label + "</span>"),
          d.html(g).val(c),
          d.on("change.intimidatetime",
          function(e) {
            t._change.call(t, e)
          }),
          u.append(d).appendTo(i)
        },
        option: function() {},
        value: function(e, t, i) {
          var n = t.find("select");
          return void 0 !== i ? (n.val(i), t) : n.val()
        }
      }
    },
    dateClone: function(e) {
      return new Date(e.getTime()).setMicroseconds(e.getMicroseconds()).setTimezone(e.getTimezone())
    },
    dateParse: function(t, i, n) {
      var a, s, r, o, l, m, u = e.intimidatetime.extend({},
      e.intimidatetime.i18n[""], e.intimidatetime.defaults, n || {}),
      d = function(t, i) {
        var n = [];
        return t && e.merge(n, t),
        i && e.merge(n, i),
        n = e.map(n,
        function(e) {
          return e.replace(/[.*+?|()\[\]{}\\]/g, "\\$&")
        }),
        "(" + n.join("|") + ")?"
      },
      c = "(\\d{1,2})",
      p = "(\\d{1,3})",
      h = "(\\d{2,4})",
      f = "([0-9A-Za-z\\u00A0-\\u05FF\\u0700-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF]+|[\\u0600-\\u06FF\\/]+)",
      g = "(Z|[-+]\\d\\d:?\\d\\d|\\S+)?",
      v = "([\\+\\-]?\\d+(\\.\\d{1,3})?)",
      y = i.match(/(u{1,2}|y{1,4}|M{1,4}|d{1,4}|h{1,2}|H{1,2}|m{1,2}|s{1,2}|l{1}|c{1}|t{1,2}|T{1,2}|z{1,3}|'.*?')/g),
      b = {
        u: -1,
        y: -1,
        M: -1,
        d: -1,
        h: -1,
        H: -1,
        m: -1,
        s: -1,
        l: -1,
        c: -1,
        t: -1,
        T: -1,
        z: -1
      },
      M = {
        u: 0,
        y: 0,
        M: 0,
        d: 0,
        h: 0,
        m: 0,
        s: 0,
        l: 0,
        c: 0,
        z: 0
      };
      if (y) for (s = 0, r = y.length; r > s; s += 1) a = ("" + y[s]).charAt(0),
      -1 !== b[a] || "d" === a && /^d{3,4}$/.test(y[s]) || (b[a] = s + 1);
      return o = "^" + ("" + i).replace(/(u{1,2}|y{1,4}|M{1,4}|d{1,4}|h{1,2}|H{1,2}|m{1,2}|s{1,2}|l{1}|c{1}|t{1,2}|T{1,2}|z{1,3}|'.*?')/g,
      function(e) {
        var t;
        switch (e) {
        case "u":
          t = v;
          break;
        case "yy":
        case "yyyy":
          t = h;
          break;
        case "M":
        case "MM":
          t = c;
          break;
        case "MMM":
        case "MMMM":
          t = f;
          break;
        case "d":
        case "dd":
          t = c;
          break;
        case "ddd":
        case "dddd":
          t = f;
          break;
        case "H":
        case "HH":
        case "h":
        case "hh":
        case "m":
        case "mm":
        case "s":
        case "ss":
          t = c;
          break;
        case "l":
        case "c":
          t = p;
          break;
        case "z":
        case "zz":
          t = g;
          break;
        case "zzz":
          t = f;
          break;
        case "t":
          t = d(u.units.hour.am, u.units.hour.pm);
          break;
        default:
          return "(" + e.replace(/\'/g, "").replace(/(\.|\$|\^|\\|\/|\(|\)|\[|\]|\?|\+|\*)/g,
          function(e) {
            return "\\" + e
          }) + ")?"
        }
        return t
      }).replace(/\s/g, "\\s") + "$",
      l = t.match(RegExp(o, "i")),
      l ? ( - 1 !== b.y && (s = l[b.y], 100 > s && (s = parseInt("20" + s, 10)), M.y = s), -1 !== b.M && (isNaN(l[b.M]) ? (s = e.inArray(l[b.M], u.units.month.namesAbbr), -1 === s && (s = e.inArray(l[b.M], u.units.month.names))) : s = parseInt(l[b.M], 10) - 1, M.M = s), -1 !== b.d && (M.d = parseInt(l[b.d], 10)), -1 !== b.h && (s = parseInt(l[b.h], 10), r = "am", (e.inArray(l[b.t], u.units.hour.pm) || e.inArray(l[b.T], u.units.hour.pm)) && (r = "pm"), "am" === r && 12 === s ? s = 0 : "pm" === r && 12 !== s && (s += 12), M.h = s), -1 !== b.H && (M.h = parseInt(l[b.H], 10)), -1 !== b.m && (M.m = parseInt(l[b.m], 10)), -1 !== b.s && (M.s = parseInt(l[b.s], 10)), -1 !== b.l && (M.l = parseInt(l[b.l], 10)), -1 !== b.c && (M.c = parseInt(l[b.c], 10)), m = new Date(M.y, M.M, M.d, M.h, M.m, M.s, M.l), m.setMicroseconds(M.c), -1 !== b.z && m.setTimezone(e.intimidatetime.timezoneOffsetNumber(l[b.z], u.units.timezone.names)), -1 !== b.u && m.setTime(1e3 * l[b.u])) : e.intimidatetime.log("Unable to parse date " + t + " with " + o),
      m
    },
    dateRangeParse: function(t, i, n, a) {
      var s, r, o = [];
      for (t = t.split(n), s = 0, r = t.length; r > s; s += 1) o[s] = e.intimidatetime.dateParse(t[s], i, a);
      return o
    },
    dateRelative: function(t, i) {
      var n, a, s, r, o = e.intimidatetime.dateClone(t),
      l = {
        y: "FullYear",
        M: "Month",
        d: "Date",
        h: "Hours",
        m: "Minutes",
        s: "Seconds",
        l: "Milliseconds",
        c: "Microseconds"
      };
      if ("number" == typeof i) o.setDate(o.getDate() + o);
      else if ("string" == typeof i && (s = i.split(/(\s+|\,)/g))) for (n = 0, a = s.length; a > n; n += 1) r = s[n].match(/(\-?\+?\d+)(\w)/),
      r && void 0 !== l[r[2]] && o["set" + l[r[2]]](o["get" + l[r[2]]]() + parseInt(r[1], 10));
      return o
    },
    dateFormat: function(t, i, n) {
      if (void 0 === t || "Invalid Date" == "" + t) return "";
      var a = e.intimidatetime.extend({},
      e.intimidatetime.i18n[""], e.intimidatetime.defaults, n || {}),
      s = i,
      r = parseInt(t.getHours(), 10),
      o = r > 11 ? a.units.hour.pm[0] : a.units.hour.am[0],
      l = function(e, t) {
        return ("000" + e).slice( - 1 * t)
      },
      m = function(e) {
        return (e > 12 ? e - 12 : 0 === e ? 12 : e) + ""
      },
      u = function(e, t) {
        var i;
        if (isNaN(e) || e > 840 || -720 > e) i = e;
        else {
          var n = -1 * e,
          a = n % 60,
          s = (n - a) / 60,
          r = t ? ":": "";
          i = (n >= 0 ? "+": "-") + ("0" + ("" + 101 * s)).slice( - 2) + r + ("0" + ("" + 101 * a)).slice( - 2),
          "+00:00" === i && (i = "Z")
        }
        return i
      },
      d = function(e) {
        return a.units.timezone.names[e] || u(e, !1)
      };
      return s = s.replace(/(?:u{1,3}|yyyy|yy|M{1,4}|d{1,4}|HH?|hh?|mm?|ss?|[tT]{1,2}|z{1,3}|[lc]|('.*?'|".*?"))/g,
      function(e) {
        var i = "";
        switch (e) {
        case "u":
          i = parseInt(t.getTime() / 1e3, 10);
          break;
        case "uu":
          i = t.getTime() / 1e3;
          break;
        case "uuu":
          i = t.getTime();
          break;
        case "yy":
          i = t.getYear();
          break;
        case "yyyy":
          i = t.getFullYear();
          break;
        case "M":
          i = t.getMonth() + 1;
          break;
        case "MM":
          i = l(t.getMonth() + 1, 2);
          break;
        case "MMM":
          i = a.units.month.namesAbbr[t.getMonth()];
          break;
        case "MMMM":
          i = a.units.month.names[t.getMonth()];
          break;
        case "d":
          i = t.getDate();
          break;
        case "dd":
          i = l(t.getDate(), 2);
          break;
        case "ddd":
          i = a.units.day.namesAbbr[t.getDay()];
          break;
        case "dddd":
          i = a.units.day.names[t.getDay()];
          break;
        case "HH":
          i = l(r, 2);
          break;
        case "H":
          i = r;
          break;
        case "hh":
          i = l(m(r), 2);
          break;
        case "h":
          i = m(r);
          break;
        case "mm":
          i = l(t.getMinutes(), 2);
          break;
        case "m":
          i = t.getMinutes();
          break;
        case "ss":
          i = l(t.getSeconds(), 2);
          break;
        case "s":
          i = t.getSeconds();
          break;
        case "l":
          i = l(t.getMilliseconds(), 3);
          break;
        case "c":
          i = l(t.getMicroseconds(), 3);
          break;
        case "T":
          i = o.charAt(0).toUpperCase();
          break;
        case "TT":
          i = o.toUpperCase();
          break;
        case "t":
          i = o.charAt(0).toLowerCase();
          break;
        case "tt":
          i = o.toLowerCase();
          break;
        case "z":
          i = u(t.getTimezone(), !1);
          break;
        case "zz":
          i = u(t.getTimezone(), !0);
          break;
        case "zzz":
          i = d(t.getTimezone());
          break;
        default:
          i = e.replace(/\'/g, "") || "'"
        }
        return i
      }),
      s = e.trim(s)
    },
    dateRangeFormat: function(t, i, n, a) {
      var s, r, o = [];
      for (s = 0, r = t.length; r > s; s += 1) o[s] = e.intimidatetime.dateFormat(t[s], i, a);
      return o = o.join(n)
    },
    timezoneOffsetNumber: function(e, t) {
      var i;
      if (e = ("" + e).replace(":", ""), "Z" === e.toUpperCase()) return 0;
      if (!/^(\-|\+)\d{4}$/.test(e)) {
        if (void 0 !== t) for (i in t) if (t[i] === e) return i;
        return e
      }
      return ("-" === e.substr(0, 1) ? -1 : 1) * (60 * parseInt(e.substr(1, 2), 10) + parseInt(e.substr(3, 2), 10))
    },
    daysInMonth: function(e, t) {
      return /3|5|8|10/.test(e) ? 30 : 1 === e ? t % 4 > 0 && t % 100 || t % 400 > 0 ? 29 : 28 : 31
    },
    detectSupport: function(e) {
      var t = e.replace(/\'.*?\'/g, ""),
      i = function(e, t) {
        return - 1 !== e.indexOf(t) ? !0 : !1
      },
      n = i("U"),
      a = {
        year: n || i(t, "y"),
        month: n || i(t, "M"),
        day: n || i(t, "d"),
        hour: n || i(t, "h") || i(t, "H"),
        minute: n || i(t, "m"),
        second: n || i(t, "s"),
        milli: i(t, "l"),
        micro: i(t, "c"),
        timezone: i(t, "z") || i(t, "Z"),
        ampm: i(t, "t") && i(t, "h"),
        iso8601: i(t, "Z")
      };
      return a.date = a.year || a.month || a.day,
      a.time = a.hour || a.minute || a.second || a.milli || a.micro || a.timezone,
      a.datetime = a.date && a.time,
      a
    },
    extend: function() {
      for (var t = arguments[0], i = 1, n = arguments.length, a = function(t, i) {
        var n, s, r;
        for (n in i) i.hasOwnProperty(n) && (r = i[n], s = Object.prototype.toString.call(r), t[n] = "[object Date]" === s ? e.intimidatetime.dateClone(r) : "[object Array]" === s ? a([], r) : "[object Object]" !== s || null === r ? r: void 0 !== t[n] ? a(t[n], r) : a({},
        r));
        return t
      }; n > i; i += 1) t = a(t, arguments[i]);
      return t
    },
    log: function() {
      window.console && window.console.log && window.console.log.apply(window.console, arguments)
    },
    lookup: {
      i: 0
    },
    version: "0.2.0"
  }),
  e.fn.intimidatetime = function() {
    var t, i, n, a = Array.prototype.slice.call(arguments),
    s = a[0] || {};
    return "string" == typeof s ? "option" === s.substr(0, 3) && 2 === a.length ? (i = e.intimidatetime.lookup[e(this[0]).data("intimidatetime")], t = i[s].apply(i, a.slice(1))) : t = this.each(function() {
      i = e.intimidatetime.lookup[e(this).data("intimidatetime")],
      i[s].apply(i, a.slice(1))
    }) : t = this.each(function() {
      n = e(this),
      e.intimidatetime.lookup[++e.intimidatetime.lookup.i] = new e.intimidatetime(n, s),
      n.data("intimidatetime", e.intimidatetime.lookup.i)
    }),
    t
  },
  Date.prototype.getMicroseconds || (Date.prototype.microseconds = 0, Date.prototype.getMicroseconds = function() {
    return this.microseconds
  },
  Date.prototype.setMicroseconds = function(e) {
    return this.setMilliseconds(this.getMilliseconds() + Math.floor(e / 1e3)),
    this.microseconds = e % 1e3,
    this
  }),
  Date.prototype.getTimezone || (Date.prototype.localTimezone = (new Date).getTimezoneOffset(), Date.prototype.timezone = (new Date).getTimezoneOffset(), Date.prototype.getTimezone = function() {
    return this.timezone
  },
  Date.prototype.setTimezone = function(e) {
    return this.timezone = e,
    this
  },
  Date.prototype.adjustTimezone = function(e) {
    this.setMinutes(this.getMinutes() + (this.timezone - e)),
    this.setTimezone(e)
  })
})(window.jQuery || window.Zepto || window.$);