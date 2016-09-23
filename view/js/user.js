;
/**
 * [个人中心 created by hangyangws]
 * @return {[Object]}
 */
! function($) {
    "use strict";
    var $says = $('#says'),
        $mask = $('#loadMask'),
        _formOk = false,
        _is_home = typeof isHome === 'undefined' ? false : true, // 判断是否是首页
        _html_comment = ['<li>',
            '<a class="fcm" href="',
            _is_home ? '../user/' : '',
            'visit.php?u={{user_id}}">{{name}}</a>',
            '<p class="t2 mt5 mb5">{{content}}</p>',
            '<span class="db tr">{{create_date}}</span>',
            '</li>'
        ].join(''),
        user = (function() {
            var $say = $('#say'),
                _is_ajax = true,
                _say_img = false,
                $publish = $('#tpl').html();
            return {
                init: function() {
                    $('#tpl').remove();
                },
                commentOpen: function($this) {
                    var $dom = $this.closest('.say-item').find('.comment-con'),
                        _temp = [];
                    $dom.slideDown(400);
                    // 开始加载此说说的评论
                    $.post(_is_home ? '../user/get_com.php' : 'get_com.php', {
                        'i': $this.attr('data-id')
                    }, function(data, status) {
                        if (status === 'success' && data !== '0') {
                            data = JSON.parse(data);
                            $.each(data, function(n, v) {
                                _temp.push(_html_comment
                                    .replace('{{user_id}}', v['user_id'])
                                    .replace('{{name}}', v['name'])
                                    .replace('{{content}}', v['content'])
                                    .replace('{{create_date}}', v['create_date']));
                            });
                            $dom.find('.com-show').html(_temp.join(''));
                        } else {
                            //没有数据
                            $dom.find('.com-show').html('<li class="tc">没有评论 快来抢沙发吧</li>');
                        };
                    });
                },
                commentClose: function($this) {
                    $this.closest('.comment-con').slideUp(400, function() {
                        $(this).find('.com-show').html('<li class="tc">加载中…</li>');
                    });
                },
                publishOpen: function() {
                    $mask.html($publish);
                    $.showMask(true);
                },
                startPublish: function() {
                    var _con,
                        _l;
                    if (_is_ajax) {
                        _is_ajax = false;
                        // 检测发表文字格式
                        _con = $.trim($mask.find('#publishCon').val());
                        _l = _con.length;
                        if (_l < 1 || _l > 200) {
                            user.publishRemind('长度只能在1-200', true);
                            _is_ajax = true;
                        } else {
                            user.publishRemind('', false);
                            // 检测发表图片
                            if (_say_img) {
                                // 现在可以发送form表单了
                                _formOk = true;
                                $mask.find('form').submit();
                            } else {
                                user.publishRemind('请附带一张图片', true);
                                _is_ajax = true;
                            }
                        };
                    }
                },
                publishRemind: function(text, f) {
                    $mask.find('#publishRemind').css('color', (f ? "#f00" : "#0f0")).html(text);
                },
                uploadImg: function($this) {
                    var imgVal = $this.val(),
                        _imgSuffix = imgVal.substring(imgVal.lastIndexOf('.')).toLowerCase();
                    if (!$.imgSuffix(_imgSuffix)) {
                        user.publishRemind('图片只支持 jpg jpeg gif png 格式', true);
                    } else {
                        user.publishRemind($this.val(), false);
                        $('#imgSuffix').val(_imgSuffix);
                        _say_img = true;
                    };
                },
                deleteSay: function($this) {
                    layer.closeAll();
                    var _say_id,
                        _say_img,
                        _now_num,
                        _this;
                    if (_is_ajax) {
                        _is_ajax = false;
                        _say_id = $this.data('id');
                        _say_img = $this.data('img');
                        $this.closest('.say-item').slideUp(400, function() {
                            _this = $(this);
                            // 后台ajax请求删除
                            $.post('del_say.php', {
                                'i': _say_id,
                                'im': _say_img
                            }, function(data, status) {
                                if (status !== 'success' && data !== '1') {
                                    $.remaind('删除失败', true);
                                    _this.slideDown(400);
                                } else {
                                    _now_num = $says.find('.say-item').length;
                                    _this.remove();
                                    $say.html(--_now_num);
                                    //检测是否是最后一条说说
                                    (_now_num === 0) && $says.html('<div id="sayLoad" class="lh300 fcf f16 tc">你没有发表任何数据</div>');
                                }
                                _is_ajax = true;
                            });
                        });
                    }
                },
                like: function($this) {
                    var $dom,
                        _id = $this.data('id');
                    if ($this.data('ing')) {
                        if (!localStorage[header.getName() + _id]) {
                            $this.data('ing', false);
                            $dom = $this.find('.like-num');
                            $dom.html(~~$dom.html() + 1);
                            $.post(_is_home ? '../user/deal_like.php' : 'deal_like.php', {
                                'i': _id
                            }, function(data, status) {
                                if (status === 'success' && data) {
                                    localStorage[header.getName() + _id] = true;
                                    $dom.html(data);
                                } else {
                                    $.remaind('网络堵塞 点赞失败', true);
                                    $dom.html(~~$dom.html() - 1);
                                };
                                $this.data('ing', true);
                            });
                        } else {
                            $.remaind('你已经点过赞过此说说', true);
                        };
                    };
                },
                comSub: function($this) {
                    if ($this.data('in')) {
                        $this.data('in', false);
                        var i = header.getId(), // 当前登录用户id
                            si = $this.data('id'), // 说说id
                            d = $this.parent().prev(), // 评论内容节点
                            v = $.trim(d.val()), // 评论内容
                            l = v.length, // 评论长度
                            t = [], // _temp 拼接数据
                            $fd = $this.closest('.comment-con').find('.com-show'); // 评论列表节点
                        if (i) {
                            if (l < 1 || l > 200) {
                                $.inputRemind(d, '回复内容长度为1-200', false);
                                $this.data('in', true);
                            } else {
                                $this.html('提交中…');
                                $.post(_is_home ? '../user/deal_com.php' : 'deal_com.php', {
                                    'i': i,
                                    'si': si,
                                    'c': v
                                }, function(data, status) {
                                    if (status === 'success' && data !== '0') {
                                        // 插入节点
                                        t.push(_html_comment
                                            .replace('{{user_id}}', i)
                                            .replace('{{name}}', header.getName())
                                            .replace('{{content}}', v)
                                            .replace('{{create_date}}', data.split('/')[0]));
                                        $fd.find('.tc').remove().end().prepend(t.join(''));
                                        // 数值更新
                                        $this.closest('.say-item').find('.com-num').html(data.split('/')[1]);
                                        // 清空原来的文本框
                                        d.val('');
                                    } else {
                                        $.remaind('评论失败', true);
                                    };
                                    $this.html('确定');
                                    $this.data('in', true);
                                });
                            }
                        } else {
                            $.remaind('请先登录', true);
                            $this.data('in', true);
                        }
                    };
                }
            };
        })();
    // 页面初始化
    user.init();
    // 打开评论
    $says.on('click', '.comment', function() {
        user.commentOpen($(this));
    });
    // 关闭评论
    $says.on('click', '.com-close', function() {
        user.commentClose($(this));
    });
    // 发表说说
    $('#sayPublish').on('click', function() {
        user.publishOpen();
    });
    // 确定发表说说
    $mask.on('click', '.start-publish', function() {
        user.startPublish();
    });
    // 发表说说textarea获取焦点
    $mask.on('focus', '#publishCon', 'focus', function() {
        user.publishRemind('', false);
    });
    // 关闭说说发表窗口
    $mask.on('click', '#closePublish', function() {
        $.showMask(false);
    });
    // 上传图片
    $mask.on('change', '#imgFile', function() {
        user.uploadImg($(this));
    });
    // 检测表单上传
    $mask.on('submit', 'form', function() {
        return _formOk;
    });
    // 删除说说
    $says.on('click', '.delete', function() {
        var $this = $(this);
        layer.confirm('确认删除此说说', { icon: 3 }, function() {
            user.deleteSay($this)
        });
    });
    // 说说点赞
    $says.on('click', '.like', function() {
        user.like($(this));
    });
    // 评论说说
    $says.on('click', '.com-sub', function() {
        user.comSub($(this));
    });
    $says.on('keyup', '.say-ipt-item', function(e) {
        $.getKey(e) === 13 && $(this).parent().find('.com-sub').trigger('click');
    });
    // 图片放大放小
    $says.on('click', '.say-img', function() {
        $(this).toggleClass('active');
    });
}(jQuery);
