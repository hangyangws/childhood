;
(function($) {
    var pass = {

        passIn: true,

        n: '',

        q: '',

        a: '',

        p: false,

        question: [
            '最怀念的老师',
            '最向往的圣地',
            '最难以忘记的人'
        ],

        submit: function(this$) {
            if (pass.passIn) {
                pass.passIn = false;
                this$.val('进行中...');
                var f = this$.closest('form'),
                    name = f.find('.f-name');
                if ($.formCheck(f)) { // 所有格式都正确
                    // 查看是否已经检测过用户名
                    if (!pass.a) {
                        // 通过用户名得到问题和答案
                        $.post('get_q_a.php', {
                            'n': $.trim(name.val())
                        }, function(data, status) {
                            if (status === 'success') {
                                if (data) {
                                    pass.n = $.trim(name.val());
                                    data = $.parseJSON(data)[0];
                                    pass.q = pass.question[(~~data.question) - 1];
                                    pass.a = data.answer;
                                    $.inputRemind(name, '请回答' + pass.q, true);
                                    this$.val('确定');
                                    name.attr({
                                        'data-role': 'answer',
                                        'placeholder': '输入您' + pass.q
                                    });
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
                    } else {
                        // 查看是否已经回答正确
                        if (pass.p) {
                            // 开始设置新密码
                            $.post('set_pass.php', {
                                'n': pass.n,
                                'p': $.trim(name.val())
                            }, function(data, status) {
                                if (status === 'success') {
                                    if (data) {
                                        $.inputRemind(name, '修改成功', true);
                                        setTimeout(function() {
                                            location.href = 'login.php';
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
                            // 校验回答是否正确
                            if ($.trim(name.val()) === pass.a) {
                                $.inputRemind(name, '回答正确 请设置新密码', true);
                                name.attr({
                                    'data-role': 'pass',
                                    'placeholder': '新密码(长6-20的英文或数字)'
                                });
                                this$.val('确定');
                                pass.p = true;
                                pass.passIn = true;
                            } else {
                                $.inputRemind(name, '回答错误');
                                this$.val('确定');
                                pass.passIn = true;
                            }
                        }
                    }
                } else {
                    this$.val('确定');
                    pass.passIn = true;
                }
            }
        }
    };

    $('#submit').on('click', function() {
        pass.submit($(this));
    });

    $('#form').on('submit', function() {
        $('#submit').trigger('click');
        return false;
    });
})(jQuery);
