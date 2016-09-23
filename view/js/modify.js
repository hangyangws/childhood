/**
 * [created by hangyangws]
 * @return {[Object]}
 */
;
! function($) {
    "use strict"
    var modify = (function() {
            var canIn = false,
                gender = false,
                loving = false,
                oldPress = 1, // 1 表示姓名进度
                info = {
                    "progress": 0,
                    "id": header.getId()
                };
            return {
                ini: function() {
                    // 获取用户数据
                    modify.getData();
                },
                getData: function() {
                    $.post('get_i.php', {
                        'id': header.getCookie('ch_user_id')
                    }, function(data, status) {
                        if (status === "success" && data) {
                            data = JSON.parse(data);
                            modify.showData(data[0]);
                        } else {
                            $.remaind('网络堵塞', true);
                        };
                    });
                },
                showData: function(data) {
                    let i;
                    //展示 view 用户已经填写过的数据 并且检测gender loving 而更新进度值
                    if (data) {
                        for (i in data) {
                            if (i === 'gender' || i === 'loving') {
                                $('#' + i).find('input[value=' + data[i] + ']').attr('checked', true);
                                if (i === 'gender' && data[i] !== '3') { //表示设置过性别
                                    oldPress++;
                                    gender = true;
                                };
                                if (i === 'loving' && data[i] !== '3') { //表示设置过恋爱状况
                                    oldPress++;
                                    loving = true;
                                };
                            } else {
                                $('#' + i).find('input').val(data[i]);
                            };
                            info[i] = data[i];
                        };
                        $.loading(false);
                        canIn = true;
                    }
                },
                submit: function(this$) {
                    if (canIn) {
                        canIn = false;
                        this$.html('修改中...');
                        var nD = $('#name').find('input'), //姓名
                            nV = $.trim(nD.val()),
                            moD = $('#motto').find('input'), //个性签名
                            moV = $.trim(moD.val()),
                            qD = $('#qq').find('input'), //qq
                            qV = $.trim(qD.val()),
                            cD = $('#phone').find('input'), //手机
                            cV = $.trim(cD.val()),
                            bD = $('#birthday').find('input'), //生日
                            bV = $.trim(bD.val()),
                            psD = $('#primary_school').find('input'), //小学
                            psV = $.trim(psD.val()),
                            mD = $('#middle_school').find('input'), //中学
                            mV = $.trim(mD.val()),
                            hD = $('#high_school').find('input'), //高中
                            hV = $.trim(hD.val()),
                            uD = $('#university').find('input'), //大学
                            uV = $.trim(uD.val()),
                            fD = $('#hometown').find('input'), //家乡
                            fV = $.trim(fD.val()),
                            pD = $('#profession').find('input'), //职业
                            pV = $.trim(pD.val()),
                            checkF = [{ //个性签名
                                'd': moD, //d 代表节点
                                'v': moV, //v 代表值
                                't': 'answer', //t 代表data-role
                                'n': 'motto' //n 代表数据库字段名
                            }, { //qq
                                'd': qD,
                                'v': qV,
                                't': 'qq',
                                'n': 'qq'
                            }, { //手机
                                'd': cD,
                                'v': cV,
                                't': 'phone',
                                'n': 'phone'
                            }, { //生日
                                'd': bD,
                                'v': bV,
                                't': 'date',
                                'n': 'birthday'
                            }, { //小学
                                'd': psD,
                                'v': psV,
                                't': 'answer',
                                'n': 'primary_school'
                            }, { //中学
                                'd': mD,
                                'v': mV,
                                't': 'answer',
                                'n': 'middle_school'
                            }, { //高中
                                'd': hD,
                                'v': hV,
                                't': 'answer',
                                'n': 'high_school'
                            }, { //大学
                                'd': uD,
                                'v': uV,
                                't': 'answer',
                                'n': 'university'
                            }, { //家乡
                                'd': fD,
                                'v': fV,
                                't': 'answer',
                                'n': 'hometown'
                            }, { //职业
                                'd': pD,
                                'v': pV,
                                't': 'answer',
                                'n': 'profession'
                            }];

                        // 重置资料进度
                        info.progress = oldPress;
                        // 单独设置姓名字段
                        info.name = nV;
                        // 把非空字段添加上对应的data-role值，否则移除data-role 属性
                        $.each(checkF, function(n, value) {
                            if (value.v) {
                                value.d.attr('data-role', value.t);
                                // 根据填写是否为空而更新进度
                                info.progress++;
                            } else {
                                value.d.removeAttr('data-role');
                            };
                            // 更新除loving 和 gender 以外 info
                            info[value.n] = value.v;
                        });

                        if ($.formCheck($('#modify'))) {
                            // 检查用户名是否重复
                            if (nV === header.getName()) {
                                // 没有修改用户名 直接保存
                                modify.update(this$, false);
                            } else { //检查新用户名是否重复
                                $.post('../ls/deal_register.php', {
                                    "n1": nV
                                }, function(data, status) {
                                    if (status === "success" && data === '0') {
                                        // 用户名可用  开始保存
                                        modify.update(this$, true);
                                    } else {
                                        $.remaind('用户名已经被注册了 换个名字试试', true);
                                        nD.val(header.getName());
                                        canIn = true;
                                        this$.html('保存修改');
                                    };
                                });
                            };
                        } else {
                            setTimeout(function() {
                                canIn = true;
                            }, 2000);
                            this$.html('保存修改');
                        };
                    };
                },
                update: function(this$, c) {
                    $.post('set_i.php', {
                        'i': JSON.stringify(info)
                    }, function(data, status) {
                        if (status === 'success' && data === '1') {
                            if (c) { //表示修改过用户名 需要注销cookie 让用户重新登录
                                $.remaind('修改成功 由于修改过用户名 请重新登录', false);
                                header.delCookie('ch_user_name');
                                header.delCookie('ch_user_id');
                                setTimeout(function() {
                                    location.href = "../ls/login.php";
                                }, 1800);
                            } else {
                                $.remaind('修改成功', false);
                                setTimeout(function() {
                                    location.reload();
                                }, 1400);
                            }
                        } else {
                            $.remaind('修改失败', true);
                            modify.canIn = true;
                            this$.html('保存修改');
                        }
                    });
                },
                gL: function(n, $this) {
                    var _get_status = {
                        gender: gender,
                        loving: loving
                    };
                    info[n] = $this.val();
                    if (!_get_status[n]) {
                        oldPress++;
                    };
                }
            };
        })();
    modify.ini();
    // 保存修改
    $('#submit').on('click', 'button', function() {
        modify.submit($(this));
    });
    // 设置性别
    $('#gender').on('click', 'input', function() {
        modify.gL('gender', $(this));
    });
    // 设置是否单身
    $('#loving').on('click', 'input', function() {
        modify.gL('loving', $(this));
    });
    // 回车绑定
    $('#modify').on('keyup', '.ipt-key', function(e) {
        if ($.getKey(e) === 13) {
            $('#submit').find('button').trigger('click');
        };
    });
}(jQuery);
