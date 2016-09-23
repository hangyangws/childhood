;
! function($) {
    "use strict";
    var register = {

        registerIn: true,

        answer: '1', // 用户当前选择的答案

        answerList: ['1', '2', '3'],

        choice: function(this$) {
            var _v = this$.attr('data-value');
            if (register.answerList.indexOf(_v) !== -1) {
                this$.addClass('q-live').siblings().removeClass('q-live');
                register.answer = _v;
            };
        },

        submit: function(this$) {
            if (register.registerIn) {
                register.registerIn = false;
                this$.val('注册中...');
                var f = this$.closest('form'),
                    name = f.find('.r-name'),
                    namev = $.trim(name.val()),
                    pass = f.find('.r-pass'),
                    passv = $.trim(pass.val()),
                    repass = f.find('.r-repass'),
                    answer = f.find('.r-answer'),
                    captcha = f.find('.r-captcha');
                if ($.formCheck(f)) { // 所有格式都正确
                    // 验证 验证码
                    $.post('deal_captcha.php', {
                        "c": $.trim(captcha.val())
                    }, function(data, status) {
                        if (status === 'success') {
                            if (data) {
                                // 验证 2次密码是否相同
                                if (passv === $.trim(repass.val())) {
                                    // 验证用户名是否可用
                                    $.post('deal_register.php', {
                                        "n1": namev
                                    }, function(data, status) {
                                        if (status === 'success') {
                                            if (data === '0') {
                                                // 开始注册
                                                $.post('deal_register.php', {
                                                    "n": namev,
                                                    'p': passv,
                                                    'q': register.answer,
                                                    'a': $.trim(answer.val())
                                                }, function(data, status) {
                                                    if (status === 'success') {
                                                        if (data !== '0') {
                                                            location.href = "../square/square.php";
                                                        } else {
                                                            $.inputRemind(name, '注册失败');
                                                            this$.val('注册');
                                                            register.registerIn = true;
                                                        }
                                                    } else {
                                                        $.inputRemind(name, '网络堵塞');
                                                        this$.val('注册');
                                                        register.registerIn = true;
                                                    }
                                                });
                                            } else {
                                                $.inputRemind(name, '用户名已经被注册');
                                                this$.val('注册');
                                                register.registerIn = true;
                                            }
                                        } else {
                                            $.inputRemind(name, '网络堵塞');
                                            this$.val('注册');
                                            register.registerIn = true;
                                        }
                                    });
                                } else {
                                    $.inputRemind(repass, '2次输入密码不同');
                                    this$.val('注册');
                                    register.registerIn = true;
                                }
                            } else {
                                $.inputRemind(captcha, '验证码错误');
                                this$.val('注册');
                                register.registerIn = true;
                            };
                        } else {
                            $.inputRemind(captcha, '网络堵塞');
                            this$.val('注册');
                            register.registerIn = true;
                        };
                    });
                } else {
                    this$.val('注册');
                    register.registerIn = true;
                }
            }
        }
    };
    // 验证码点击
    $('#captcha').on('click', function() {
        $.changeCaptcha($(this));
    });
    // 选择问题
    $('#question').on('click', 'li', function() {
        register.choice($(this));
    });
    // 提交
    $('#submit').on('click', function() {
        register.submit($(this));
    });
    // 回车绑定
    $('#main').on('keyup', '.ipt-item', function(e) {
        if ($.getKey(e) === 13) {
            $('#submit').trigger('click');
        };
    });
}(jQuery);
