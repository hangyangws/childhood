var header = (function() {
    "use strict";
    var name = '',
        id = '',
        login = false;
    return {
        getName: function() {
            return decodeURI(name);
        },
        getId: function() {
            return id;
        },
        getIsLogin: function() {
            return login;
        },
        addHandler: (function() {
            if (document.addEventListener) {
                return function(ele, type, handler) {
                    ele.addEventListener(type, handler, false);
                };
            } else if (document.attachEvent) {
                return function(ele, type, handler) {
                    ele.attachEvent("on" + type, handler);
                };
            } else {
                return function(ele, type, handler) {
                    ele["on" + type] = handler;
                };
            };
        })(),
        getCookie: function(c_name) {
            if (document.cookie.length > 0) {
                var c_start = document.cookie.indexOf(c_name + "="),
                    c_end;
                if (c_start !== -1) {
                    c_start = c_start + c_name.length + 1;
                    c_end = document.cookie.indexOf(";", c_start);
                    c_end === -1 && (
                        c_end = document.cookie.length
                    );
                    return document.cookie.slice(c_start, c_end);
                }
            }
            return '';
        },
        delCookie: function(c_name) {
            var exp = new Date(),
                cval = header.getCookie(c_name);
            exp.setTime(exp.getTime() - 1000);
            cval !== '' && (
                document.cookie = c_name + "=" + cval + ";expires=" + exp.toGMTString() + ";path=/;"
            );
        },
        ini: function() {
            name = header.getCookie('ch_user_name');
            id = header.getCookie('ch_user_id');
            (name && id) && (
                login = true
            );
        }
    };
})();
header.ini();
