;
(function($) {

    var gV = {
        $mask: $('#loadMask'),

        loadCss: ['<div class="load-wrap middle">',
            '<div class="sk-spinner sk-spinner-chasing-dots">',
            '<div class="sk-dot1"></div>',
            '<div class="sk-dot2"></div>',
            '</div>',
            '</div>'
        ].join(''),

        remaindCss: ['<div class="middle remaind-wrap animated bounceIn">',
            '<span id="remaindMessage"></span>',
            '<span id="confirmRemaind" class="transtion">确定</span>',
            '</div>'
        ].join(''),

        maskShow: function(type) {
            if (type) {
                gV.$mask.css('display', 'block');
            } else {
                gV.$mask.html('').fadeOut(400);
            };
        }
    };

    $.extend({
        remaind: function(text, type) {
            gV.$mask.append(gV.remaindCss);
            $('#remaindMessage').css('color', (type ? '#f00' : '#0c9')).html(text);
            gV.maskShow(true);
        },
        loading: function(type) {
            if (type) {
                gV.$mask.append(gV.loadCss);
                gV.maskShow(true);
            } else {
                gV.maskShow(false);
            };
        },
        showMask: function(type) {

            gV.maskShow(type);
        },
        changeCaptcha: function(img$) {
            var src = img$.attr('src').split('?')[0];
            img$.attr('src', src + '?' + new Date().getTime());
        },
        inputRemind: function(input$, t, status) {
            var f = false,
                type = input$.attr('type'),
                color = status ? '#09f' : '#f00';
            animate = status ? 'pulse' : 'swing';
            if (type !== 'text') {
                input$.attr('type', 'text');
                f = true;
            };
            input$.attr("readonly", "readonly")
                .val(t)
                .css('color', color)
                .addClass(animate)
                .delay(2000)
                .show(100, function() {
                    $(this).css('color', '#333')
                        .removeAttr("readonly")
                        .val('')
                        .removeClass(animate);
                    f && input$.attr('type', type);
                });
            // window 窗体移动
            $("html, body").animate({
                scrollTop: input$.position().top - 70
            }, 400);
        },
        checkName: function(text) {
            var l = text.length;
            // 长度为1-20 并且只包含中文数字字母和下划线
            return !(l < 1 || l > 20 || text.replace(/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/, "") !== "");
        },
        checkPass: function(text) {
            var l = text.length;
            // 长度为6-20 并且只包含数字字母和下划线
            return !(l < 6 || l > 20 || text.replace(/^[a-zA-Z_0-9]+$/, "") !== "");
        },
        checkQQ: function(text) {
            var l = text.length;
            // 长度为4-12 并且只包含数字
            return (l > 4 && l < 12 && text.replace(/^[0-9]+$/, "") === "");
        },
        checkPhone: function(text) {
            var l = text.length,
                regPhone = /(^13\d{9}$)|(^14)[5,7]\d{8}$|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17)[6,7,8]\d{8}$|(^18\d{9}$)/g;
            return (l === 11 && text.replace(/^[0-9]+$/, "") === "" && regPhone.test(text));
        },
        checkDate: function(text) {
            var l = text.length,
                regDate = /^((?:19|20)\d\d)-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/;
            return (l === 10 && regDate.test(text));
        },
        checkCaptcha: function(text) {
            return !(text.length !== 4 || text.replace(/^[a-zA-Z0-9]+$/, "") !== "");
        },
        formCheck: function(f$) {
            var doms = f$.find('input[data-role]'),
                // 只检查有data-role属性的input
                len = doms.length,
                dom,
                data,
                val;
            while (doms[--len]) {
                dom = $(doms[len]);
                data = dom.attr('data-role');
                val = $.trim(dom.val());
                switch (data) {
                    case 'name':
                        if (!$.checkName(val)) {
                            $.inputRemind(dom, '请检查用户名');
                            return false;
                        };
                        break;
                    case 'answer':
                        if (!$.checkName(val)) {
                            $.inputRemind(dom, '格式不正确');
                            return false;
                        };
                        break;
                    case 'pass':
                        if (!$.checkPass(val)) {
                            $.inputRemind(dom, '请检查密码');
                            return false;
                        };
                        break;
                    case 'qq':
                        if (!$.checkQQ(val)) {
                            $.inputRemind(dom, '请输入正确的qq号');
                            return false;
                        };
                        break;
                    case 'phone':
                        if (!$.checkPhone(val)) {
                            $.inputRemind(dom, '请输入合法的手机号');
                            return false;
                        };
                        break;
                    case 'date':
                        if (!$.checkDate(val)) {
                            $.inputRemind(dom, '请输入正常的日期');
                            return false;
                        };
                        break;
                    case 'captcha':
                        if (!$.checkCaptcha(val)) {
                            $.inputRemind(dom, '验证码错误');
                            $.changeCaptcha(dom.next());
                            return false;
                        };
                        break;
                    default:
                        $.inputRemind(dom, '错误');
                        return false;
                };
            };
            return true;
        },
        imgSuffix: function(suffix) {
            var img = [".jpg", ".png", ".gif", ".jpeg"];
            return $.inArray(suffix, img) === -1 ? false : true;
        },
        getE: function(e) {
            return e || window.event || arguments.callee.caller.arguments[0];
        },
        getKey: function(e) {
            e = $.getE(e);
            return e.keyCode || e.which || e.charCode;
        }
    });

    // confirmRemaind
    gV.$mask.delegate('#confirmRemaind', 'click', function() {
        gV.maskShow(false);
    });
})(jQuery);
