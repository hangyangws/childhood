;
(function($) {
    "use strict";
    var login = {

        loginIn: true,

        submit: function(this$) {
            if (login.loginIn) {
                login.loginIn = false;
                this$.val('登录中...');
                var f = this$.closest('form'),
                    name = f.find('.l-name'),
                    pass = f.find('.l-pass'),
                    captcha = f.find('.l-captcha');
                if ($.formCheck(f)) { // 所有格式都正确
                    // 验证 验证码
                    $.post('deal_captcha.php', {
                        "c": $.trim(captcha.val())
                    }, function(data, status) {
                        if (status === 'success') {
                            if (data) {
                                // 验证用户名和密码
                                $.post('deal_login.php', {
                                    "n": $.trim(name.val()),
                                    "p": $.trim(pass.val())
                                }, function(data, status) {
                                    if (status === 'success') {
                                        if (data) {
                                            location.href = "../square/square.php";
                                        } else {
                                            $.inputRemind(name, '用户名或密码错误');
                                            this$.val('登录');
                                            login.loginIn = true;
                                        }
                                    } else {
                                        $.inputRemind(captcha, '网络堵塞');
                                        this$.val('登录');
                                        login.loginIn = true;
                                    }
                                });
                            } else {
                                $.inputRemind(captcha, '验证码错误');
                                $.changeCaptcha($('#captcha'));
                                this$.val('登录');
                                login.loginIn = true;
                            }
                        } else {
                            $.inputRemind(captcha, '网络堵塞');
                            this$.val('登录');
                            login.loginIn = true;
                        }
                    });
                } else {
                    this$.val('登录');
                    login.loginIn = true;
                }
            }
        }
    };
    // 刷新验证码
    $('#captcha').bind('click', function() {
        $.changeCaptcha($(this));
    });
    // 提交
    $('#submit').bind('click', function() {
        login.submit($(this));
    });
    // 回车绑定
    $('#main').on('keyup', '.ipt-item', function(e) {
        if ($.getKey(e) === 13) {
            $('#submit').trigger('click');
        };
    });
})(jQuery);
