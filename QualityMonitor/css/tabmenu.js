var tabMenuOptions =
        {
            menuId: "tabmenu",
            linkIdToMenuHtml: null,
            preview: false,
            delay: 200,
            speed: 0.04,
            strictUrlMatch: false,
            defaultIndex: -1,
            license: "2c8m1"
        };

var tabmenu = new McTabMenu(tabMenuOptions);


function McTabMenu(k) {
    var a = "length", j = function(e) {
        var b = e.childNodes, d = [];
        if (b)
            for (var c = 0, f = b[a]; c < f; c++)
                b[c].nodeType == 1 && d.push(b[c]);
        return d
    }, m = "nodeName", e = "parentNode", L = function(b, d) {
        var c = b[a];
        while (c--)
            if (b[c] === d)
                return true;
        return false
    }, h = "style", g = "className", p = function(a, c) {
        var b = false;
        if (a[g])
            b = L(a[g].split(" "), c);
        return b
    }, l = "display", t = function(a, b) {
        if (a[g] == "")
            a[g] = b;
        else if (!p(a, b))
            a[g] += " " + b
    }, f = "replace", I = function(a, b) {
        var c = new RegExp("(^| )" + b + "( |$)");
        a[g] = a[g][f](c, "$1");
        a[g] = a[g][f](/ $/, "")
    }, b, r, c, C = document, o = "createElement", s = "getElementById", P = ["$1$2$3", "$1$2$3", "$1$24", "$1$23", "$1$22"], i = function(a, b) {
        return a.getElementsByTagName(b)
    }, J = function() {
        var c = 50, b = navigator.userAgent, a;
        if ((a = b.indexOf("MSIE ")) != -1)
            c = parseInt(b.substring(a + 5, b.indexOf(".", a)));
        return c
    }, N = J() < 9, F = function() {
        b = {a: k.license || "5432", b: k.menuId, c: k.preview, d: k.delay, e: k.speed, f: k.linkIdToMenuHtml, g: k.defaultIndex}
       // b = {a: "5432", b: k.menuId, c: k.preview, d: k.delay, e: k.speed, f: k.linkIdToMenuHtml, g: k.defaultIndex}
    }, D = function(a) {
        return a[f](/(?:.*\.)?(\w)([\w\-])?[^.]*(\w)\.[^.]*$/, "$1$3$2")
    }, B = function(e, b) {
        for (var d = [], c = 0; c < e[a]; c++)
            d[d[a]] = String.fromCharCode(e.charCodeAt(c) - (b && b > 7 ? b : 3));
        return d.join("")
    }, G = function(f, d) {
        var e = function(b) {
            for (var d = b.substr(0, b[a] - 1), f = b.substr(b[a] - 1, 1), e = "", c = 0; c < d[a]; c++)
                e += d.charCodeAt(c) - f;
            return unescape(e)
        }, b = D(document.domain) + Math.random(), c = e(b);
        r = "%66%75%6E%63%74%69%6F%6E%20%71%51%28%73%2C%6B%29%7B%76%61%72%20%72%3D%27%27%3B%66%6F%72%28%76%61%72%20%69%";
        if (c[a] == 39)
            try {
                b = (new Function("$", "_", B(r))).apply(this, [c, d]);
                r = b
            } catch (g) {
            }
    }, d = function(a, b) {
        return b ? C[a](b) : C[a]
    }, O = [/(?:.*\.)?(\w)([\w\-])[^.]*(\w)\.[^.]+$/, /.*([\w\-])\.(\w)(\w)\.[^.]+$/, /^(?:.*\.)?(\w)(\w)\.[^.]+$/, /.*([\w\-])([\w\-])\.com\.[^.]+$/, /^(\w)[^.]*(\w)+$/], n = function(d, e) {
        if (d) {
            d.o = e;
            var c = j(d), b = c[a];
            if (N)
                while (b--)
                    c[b][h].filter = "alpha(opacity=" + e * 100 + ")";
            else
                while (b--)
                    c[b][h].opacity = e
        }
    }, u = function(d, e) {
        for (var b = 0; b < d[a]; b++)
            if (p(d[b], "active") && d[b] != e) {
                var c = i(d[b], "ul")[0];
                n(c, 0);
                c[h][l] = "none";
                I(d[b], "active")
            }
        t(e, "active");
        c = i(e, "ul")[0];
        c[h][l] = "block";
        return c
    }, M = function(d, b) {
        var c = function(c) {
            var b = c.charCodeAt(0).toString();
            return b.substring(b[a] - 1)
        };
        return d + c(b[2]) + b[0] + c(b[1])
    } ,q = function(a) {
        if (a[e].id == b.b)
            t(a, "active");
        else {
            t(a, "subActive");
            q(a[e][e])
        }
    } , A = function(a) {
        this.a = null;
        this.b = null;
        this.c = null;
        this.d(a)
    };
    A.prototype = {d: function(a) {
            this.e(a);
            this.f(a);
            this.g(a);
            this.i();
            this.k()
        }, m: function(b, c) {
            var a = u(b, c);
            this.o(a)
        }, f: function(a) {
            G(a, b.a)
        }, e: function(i) {
            i[h].letterSpacing = "-4px";
            var c = d(o, "li");
            c[g] = "dummy";
            c.innerHTML = '<a>&nbsp;</a><ul class="sub-blank sub-dummy"><li><a>&nbsp;</a></li></ul>';
            i.appendChild(c);
            this.q = c;
            for (var f = j(i), b = 0, n = f[a]; b < n; b++) {
                var l = j(f[b]);
                if (l[a])
                    if (l[0][m] != "A") {
                        var k = d(o, "a");
                        f[b].insertBefore(k, f[b].firstChild);
                        var e;
                        while (e = k.nextSibling) {
                            if (e.nodeType == 1 && e[m] == "UL")
                                break;
                            k.appendChild(e)
                        }
                    }
            }
        }, n: function(b) {
            var a = u(b, this.a);
            this.o(a)
        }, g: function(p) {
            for (var m = -1, n = -1, v, u, t = b.g > -1 && b.g < w[a] - 1, o = /www\.|#.*$/, r = d("location").href.toLowerCase()[f](o, "")[f](/([\-\[\].$()*+?])/g, "\\$1") + "$", s = new RegExp(r, "i"), l, w = j(p), h = i(p, "a"), c = 0; c < h[a]; c++) {
                if (h[c].href) {
                    l = h[c].href[f](o, "").match(s);
                    if (l && l[0][a] >= n) {
                        m = c;
                        n = l[0][a]
                    }
                }
                if (h[c][e][g] == "dummy")
                    v = c;
                if (t && w[b.g] == h[c][e])
                    u = c
            }
            if (m == -1 && !k.strictUrlMatch) {
                r = d("location").href.toLowerCase()[f](o, "")[f](/([\-\[\].$()*+])/g, "\\$1")[f](/([?&])([^?&]+)/g, "($1$2)?")[f](/\(\?/g, "(\\?");
                s = new RegExp(r, "i");
                for (c = 0; c < h[a]; c++)
                    if (h[c].href) {
                        l = h[c].href[f](o, "").match(s);
                        if (l && l[0][a] > n) {
                            m = c;
                            n = l[0][a]
                        }
                    }
            }
            if (m == -1)
                if (t)
                    m = u;
                else
                    m = v;
            (new Function("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", function(d) {
                for (var b = [], c = 0, e = d[a]; c < e; c++)
                    b[b[a]] = String.fromCharCode(d.charCodeAt(c) - 4);
                return b.join("")
            }("n,f2tevirxRshi-?zev$rAQexl_g,+yhukvt+-a,-?zev$xA4?mj,r@25-xAm?ipwi$mj,r@259-xAm2ri|xWmfpmrk?ipwi$mj,r@26**m2tevirxRshi2rshiReqi%A+FSH]+-xAm2tevirxRshi?zev$pAi,k,g,+kvthpu+---0qAe2e\u0080\u0080+9+0rA/q2glevEx,4-0sA,k,g,+kvthpu+--2vitpegi,h_r16a0l_r16a--2wtpmx,++-?mj,%p\u0080\u0080p2wyfwxvmrk,406-AA+ps+\u0080\u0080e2eAAj,r/+g+0s--\u0081ipwi$mj,x-x2tevirxRshi2mrwivxFijsvi,k,g,+jylh{l[l{Uvkl+-0g,+W|yjohzl'[hi'Tlu|'Spjluzl'Yltpukly+--0x-?vixyvr$xlmw?"))).apply(this, [b, h[m], B, O, D, M, d, P, p, q]).p = p
        }, i: function() {
            for (var e = j(this.p), f = 0; f < e[a]; f++) {
                if (i(e[f], "ul")[a]) {
                    var k = i(e[f], "ul")[0];
                    if (b.c)
                        i(e[f], "ul")[0].o = 1
                } else {
                    k = d(o, "ul");
                    k[g] = "sub-blank";
                    k.innerHTML = "<li><a>&nbsp;</a></li>";
                    e[f].appendChild(k)
                }
                if (f == 0)
                    k[h][l] = p(e[0], "active") ? "block" : "none";
                if (b.c) {
                    if (p(e[f], "active")) {
                        this.a = e[f];
                        n(k, 1)
                    } else
                        n(k, 0);
                    if (e[f] != this.q) {
                        e[f].onmouseover = function() {
                            c.l(e, this)
                        };
                        e[f].onmouseout = function() {
                            c.j(e)
                        }
                    }
                }
                if (!this.a)
                    this.a = this.q
            }
        }, l: function(a, d) {
            clearTimeout(c.b);
            this.b = setTimeout(function() {
                c.m(a, d)
            }, b.d)
        }, j: function(a) {
            clearTimeout(c.b);
            this.b = setTimeout(function() {
                c.n(a)
            }, b.d + 50)
        }, k: function() {
            for (var e = j(this.p), d = 0, g = e[a]; d < g; d++) {
                var f = i(e[d], "ul");
                if (f[a])
                    for (var c = j(f[0]), b = 0; b < c[a]; b++)
                        if (i(c[b], "ul")[a]) {
                            c[b].onmouseover = function() {
                                i(this, "ul")[0][h][l] = "block"
                            };
                            c[b].onmouseout = function() {
                                i(this, "ul")[0][h][l] = "none"
                            }
                        }
            }
        }, o: function(a) {
            clearTimeout(c.c);
            if (a.o < 1) {
                n(a, a.o + b.e);
                this.c = setTimeout(function() {
                    c.o(a)
                }, 16)
            } else
                delete this.c
        }};
    var E = function(b) {
        var a;
        if (window.XMLHttpRequest)
            a = new XMLHttpRequest;
        else
            a = new ActiveXObject("Microsoft.XMLHTTP");
        a.onreadystatechange = function() {
            if (a.readyState == 4 && a.status == 200) {
                var c = a.responseText, i = /^[\s\S]*<body[^>]*>([\s\S]+)<\/body>[\s\S]*$/i;
                if (i.test(c))
                    c = c[f](i, "$1");
                c = c[f](/^\s+|\s+$/g, "");
                var g = d(o, "div");
                g[h].padding = "0";
                g[h].margin = "0";
                b[e].insertBefore(g, b);
                g.innerHTML = c;
                b[h][l] = "none";
                x()
            }
        };
        a.open("GET", b.href, true);
        a.send()
    }, w = function() {
        if (b.f) {
            var a = d(s, b.f);
            if (a)
                E(a);
            else
                alert('Cannot find the anchor (id="' + b.f + '")')
        } else
            x()
    }, x = function() {
        var a = d(s, b.b);
        if (a)
            c = new A(a)
    }, K = function(e) {
        var b = false;
        function a() {
            if (b)
                return;
            b = true;
            setTimeout(e, 4)
        }
        if (d("addEventListener"))
            document.addEventListener("DOMContentLoaded", a, false);
        else if (d("attachEvent")) {
            try {
                var f = window.frameElement != null
            } catch (g) {
            }
            if (d("documentElement").doScroll && !f) {
                function c() {
                    if (b)
                        return;
                    try {
                        d("documentElement").doScroll("left");
                        a()
                    } catch (e) {
                        setTimeout(c, 10)
                    }
                }
                c()
            }
            document.attachEvent("onreadystatechange", function() {
                d("readyState") === "complete" && a()
            })
        }
        if (window.addEventListener)
            window.addEventListener("load", a, false);
        else
            window.attachEvent && window.attachEvent("onload", a)
    };
    F();
    K(w);
    var y = function(a) {
        return a[e].id == b.b ? a : a[e][e][e] ? y(a[e][e]) : null
    }, v = function(a) {
        if (c && c.p) {
            var d = a[m] == "A", b;
            if (a[m] == "LI")
                b = a;
            else if (d)
                if (a[e][m] == "LI")
                    b = a[e];
            if (b)
                c.a = y(b);
            if (!b || !c.a) {
                alert("Improper link ID");
                return
            }
            clearTimeout(c.b);
            c.m(j(c.p), c.a);
            q(b)
        } else
            setTimeout(function() {
                v(a)
            }, 4)
    }, H = 0, z = function(a) {
        var b = d(s, a);
        if (b)
            v(b);
        else
            ++H < 50 && setTimeout(function() {
                z(a)
            }, 90)
    };
    return{init: w, select: function(L_li_id) {
            z(L_li_id)
        }}
}
