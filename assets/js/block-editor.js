! function(t) {
	var e = {};

	function n(o) {
		if (e[o]) return e[o].exports;
		var r = e[o] = {
			i: o,
			l: !1,
			exports: {}
		};
		return t[o].call(r.exports, r, r.exports, n), r.l = !0, r.exports
	}
	n.m = t, n.c = e, n.d = function(t, e, o) {
		n.o(t, e) || Object.defineProperty(t, e, {
			enumerable: !0,
			get: o
		})
	}, n.r = function(t) {
		"undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
			value: "Module"
		}), Object.defineProperty(t, "__esModule", {
			value: !0
		})
	}, n.t = function(t, e) {
		if (1 & e && (t = n(t)), 8 & e) return t;
		if (4 & e && "object" == typeof t && t && t.__esModule) return t;
		var o = Object.create(null);
		if (n.r(o), Object.defineProperty(o, "default", {
				enumerable: !0,
				value: t
			}), 2 & e && "string" != typeof t)
			for (var r in t) n.d(o, r, function(e) {
				return t[e]
			}.bind(null, r));
		return o
	}, n.n = function(t) {
		var e = t && t.__esModule ? function() {
			return t.default
		} : function() {
			return t
		};
		return n.d(e, "a", e), e
	}, n.o = function(t, e) {
		return Object.prototype.hasOwnProperty.call(t, e)
	}, n.p = "", n(n.s = 5)
}([function(t, e) {
	! function() {
		t.exports = this.wp.url
	}()
}, function(t, e) {
	! function() {
		t.exports = this.wp.element
	}()
}, function(t, e) {
	! function() {
		t.exports = this.wp.i18n
	}()
}, function(t, e) {
	! function() {
		t.exports = this.wp.plugins
	}()
}, function(t, e) {
	! function() {
		t.exports = this.wp.editPost
	}()
}, function(t, e, n) {
	"use strict";
	n.r(e);
	var o = n(1),
		r = n(2),
		i = n(3),
		u = n(4),
		c = (n(6), n(0));
	Object(i.registerPlugin)("shop-extra-more-menu-item", {
		icon: "arrow-left-alt",
		render: function() {
			return window.history.replaceState("", "", Object(c.addQueryArgs)(window.location.href, {
				blocks: "1"
			})), Object(o.createElement)(u.PluginMoreMenuItem, {
				onClick: function() {
					window.location.href = Object(c.removeQueryArgs)(window.location.href, "blocks")
				}
			}, Object(r.__)("Back to Classic Editor", "blocks-for-products"))
		}
	})
}, function(t, e) {
	! function() {
		t.exports = this.wp.components
	}()
}]);