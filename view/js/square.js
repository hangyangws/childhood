;
(function($) {
    var $hotuserWrap = $('#hotuserWrap'),
        $says = $('#says'),
        _user_html = $('#tpUser').html(),
        _say_html = $('#tpSay').html(),
        Square = {
            init: function() {
                // 热门用户字符串模板替换
                Square.hotUser();
                // 热门说说字符串模板替换
                Square.hotSay();
            },
            hotUser: function() {
                var _html = [],
                    _user_l = G.hotUser.length,
                    _user_temp = null,
                    _loving = null,
                    _gender = null;
                while (_user_l--) {
                    _user_temp = G.hotUser[_user_l];
                    // 设置恋爱状况
                    if (_user_temp.loving === '0') {
                        _loving = '恋爱中';
                    } else if (_user_temp.loving === '1') {
                        _loving = '单身狗';
                    } else {
                        _loving = '未设置';
                    }
                    // 设置性别
                    if (_user_temp.gender === '1') {
                        _gender = '<i class="vm dlb boy"></i>';
                    } else if (_user_temp.gender === '0') {
                        _gender = '<i class="vm dlb girl"></i>';
                    } else {
                        _gender = '<span class="vm f14">未设置</span>';
                    }
                    _html.push(
                        _user_html
                        .replace('{{id}}', _user_temp.id)
                        .replace('{{name}}', _user_temp.name)
                        .replace('{{progress}}', (_user_temp.progress / 13).toFixed(3) * 100 + '%')
                        .replace('{{gender}}', _gender)
                        .replace('{{loving}}', _loving)
                        .replace('{{motto}}', _user_temp.motto || '未设置')
                        .replace('{{head}}', _user_temp.head === '1' ? ('../user/user_img/' + _user_temp.id + '/head_img/head.jpeg') : '../view/img/user.png')
                    );
                }
                $hotuserWrap.html(G.hotUser.length ? _html.join('') : '<span class="db fcf tc mb20">没有任何数据</span>');
            },
            hotSay: function() {
                var _html = [],
                    _say_l = G.hotSays.length,
                    _say_temp = null;
                while (_say_l--) {
                    _say_temp = G.hotSays[_say_l];
                    _html.push(
                        _say_html
                        .replace('{{to_who}}', _say_temp.to_who)
                        .replace(/{{id}}/g, _say_temp.id)
                        .replace('{{name}}', _say_temp.name)
                        .replace('{{create_date}}', _say_temp.create_date.slice(0, 10))
                        .replace('{{content}}', _say_temp.content)
                        .replace('{{img}}', _say_temp.img)
                        .replace('{{com_num}}', _say_temp.com_num)
                        .replace('{{aggre_num}}', _say_temp.aggre_num)
                    );
                }
                $says.html(G.hotSays.length ? _html.join('') : '<span class="db fcf tc mt20 mb20">没有任何数据</span>');
            },
            start: function(this$) {
                if (header.getCookie('ch_user_name') && header.getCookie('ch_user_id')) {
                    this$.removeClass('f-animate').addClass('start-hide rotateOutUpRight').delay(1000).hide(function() {
                        $(this).next().removeClass('ml100').addClass('mr100').attr('title', 'Hi 我是童年萌萌哒 选择我右边的模块和我一起玩耍吧').end().remove();
                        $('#fMain').css('display', 'block').addClass('swing');
                    });
                } else {
                    $.remaind('亲 你还未登录哦 请登录', true);
                    setTimeout(function() {
                        location.href = "../ls/login.php";
                    }, 1400);
                }
            }
        };
    // 项目初始化
    Square.init();
    // find start
    $('#fStart').bind('click', function() {
        Square.start($(this));
    });
})(jQuery);
