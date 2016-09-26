;
! function($) {
    "use strict";
    var HeadImg = (function() {
        var $err = $('#ch-error_outer'),
            $submit = $('#submit'),
            $img = $('#photo').find('img'),
            $secImg = $('#sec'),
            _is_upload = false,
            x = 0,
            y = 0,
            w = 0,
            _is_save = true;
        return {
            init: function() {
                // 检测是否有图片 从而调用图片裁剪函数
                if ($img.length) {
                    var _time = setInterval(function() {
                        // 检测图片加载完成
                        console.log('aaaaa')
                        if ($secImg[0].complete) {
                            console.log('dddddddd')
                            clearInterval(_time);
                            HeadImg.imgSelect();
                        }
                    }, 200);
                }
            },
            imgSelect: function() {
                // 预览图片上下居中
                var pre_width = $img.width(),
                    pre_height = $img.height();
                if (pre_width > pre_height) {
                    $img.css({
                        marginTop: 150 - pre_height / 2 + 'px'
                    });
                };
                $img.imgAreaSelect({
                    // 设置参数
                    // 具体见http://odyniec.net/projects/imgareaselect/usage.html
                    // http://www.cnblogs.com/mizzle/archive/2011/10/13/2209891.html
                    show: true,
                    aspectRatio: '1:1', //截图比例一比一，不写为自由缩放
                    handles: true,
                    // 预览区域预览选区
                    onSelectChange: function(img, selection) {
                        x = selection.x1;
                        y = selection.y1;
                        w = selection.width;
                        // "放大倍数"
                        var rat = w / 100;
                        $secImg.css({
                            width: pre_width / rat + 'px',
                            height: pre_height / rat + 'px',
                            marginLeft: '-' + x / rat + 'px',
                            marginTop: '-' + y / rat + 'px'
                        });
                    },
                    onSelectEnd: function(img, selection) {
                        x = selection.x1;
                        y = selection.y1;
                        w = selection.width;
                    }
                });
            },
            checkImg: function($this) {
                var file_name = $this.val(),
                    suf = file_name.substring(file_name.lastIndexOf("."), file_name.length).toUpperCase();
                if (suf !== ".PNG" && suf !== ".GIF" && suf !== ".JPG" && suf !== ".JPEG") {
                    HeadImg.err('SORRY: 头像仅限于 png gif peg jpg 格式！');
                } else {
                    _is_upload = true;
                    $('#head_form').trigger('submit');
                };
            },
            err: function(_text, _type) {
                $err.find('div').css("color", _type ? '#0f0' : '#f00').html(_text).end()
                    .show(0)
                    .delay(600)
                    .fadeOut(200);
            },
            formLoad: function(e) {
                if (!_is_upload) {
                    $.getE(e).preventDefault();
                    return false;
                };
            },
            okImg: function() {
                if (_is_save) {
                    _is_save = false;
                    if (w) {
                        HeadImg.err('操作中...', true);
                        $.post("save_head.php", {
                            "x": x,
                            "y": y,
                            "w": w
                        }, function(data, status) {
                            if (status === "success") {
                                if (data === '1') {
                                    HeadImg.err('头像设置成功', true);
                                } else {
                                    HeadImg.err('头像设置失败');
                                };
                            } else {
                                HeadImg.err('网络堵塞');
                            };
                            location.href = "../user/user.php";
                        });
                    } else {
                        _is_save = true;
                        HeadImg.err('你还未选择区域(鼠标点击/拖拽 选择区域)')
                    };
                };
            }
        };
    })();
    HeadImg.init();
    // 头像上传检测
    $('#head_form').on('change', '.flie_submit', function() {
        HeadImg.checkImg($(this));
    });
    // 表单上传事件
    $('#head_form').on('submit', function(e) {
        HeadImg.formLoad(e);
    });
    // 确认裁剪
    $('#head_form').on('click', '.ok', function() {
        HeadImg.okImg();
    });
}(jQuery);
