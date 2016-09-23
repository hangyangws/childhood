;
(function($) {
    var pass = {

        passIn: true,

        n: '',

        p: false,

        submit: function(this$) {
            if (pass.passIn) {
                pass.passIn = false;
                this$.val('进行中...');
                var f = this$.closest('form'),
                    name = f.find('.m-name');
                if ($.formCheck(f)) { // 所有格式都正确
                    // 检测用户名是否通过
                    if (pass.n) {
                        // 检测旧密码是否通过
                        if (pass.p) {
                            // 设置密码
                            $.post('set_pass.php', {
                                'n': pass.n,
                                'p': $.trim(name.val())
                            }, function(data, status) {
                                if (status === 'success') {
                                    if (data) {
                                        $.inputRemind(name, '修改成功', true);
                                        setTimeout(function() {
                                            location.href = '../square/square.php';
                                        }, 1000);
                                    } else {
                                        $.inputRemind(name, '修改失败');
                                        this$.val('确定');
                                        pass.passIn = true;
                                    }
                                } else {
                                    $.inputRemind(name, '网络堵塞');
                                    this$.val('确定');
                                    pass.passIn = true;
                                }
                            });
                        } else {
                            // 检测旧密码是否正确
                            $.post('deal_login.php', {
                                'n': pass.n,
                                'p': $.trim(name.val())
                            }, function(data, status) {
                                if (status === 'success') {
                                    if (data) {
                                        $.inputRemind(name, '请更改密码', true);
                                        name.attr('placeholder', '输入新密码');
                                        this$.val('确定');
                                        pass.p = true;
                                        pass.passIn = true;
                                    } else {
                                        $.inputRemind(name, '密码错误');
                                        this$.val('确定');
                                        pass.passIn = true;
                                    }
                                } else {
                                    $.inputRemind(name, '网络堵塞');
                                    this$.val('确定');
                                    pass.passIn = true;
                                }
                            });
                        }
                    } else {
                        // 检测用户名是否可用
                        $.post('deal_register.php', {
                            'n1': $.trim(name.val())
                        }, function(data, status) {
                            if (status === 'success') {
                                if (data === '1') {
                                    pass.n = $.trim(name.val());
                                    $.inputRemind(name, '请输入你的旧密码', true);
                                    name.attr({
                                        'data-role': 'pass',
                                        'placeholder': '输入旧密码'
                                    });
                                    this$.val('确定');
                                    pass.passIn = true;
                                } else {
                                    $.inputRemind(name, '检测失败');
                                    this$.val('确定');
                                    pass.passIn = true;
                                }
                            } else {
                                $.inputRemind(name, '网络堵塞');
                                this$.val('确定');
                                pass.passIn = true;
                            }
                        });
                    }
                } else {
                    this$.val('确定');
                    pass.passIn = true;
                }
            }
        }
    };

    $('#submit').bind('click', function() {

        pass.submit($(this));
    });

    $('#form').on('submit', function() {
        $('#submit').trigger('click');
        return false;
    });
})(jQuery);
