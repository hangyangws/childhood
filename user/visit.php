<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>访客-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/user.css" />
</head>

<body id="body">
    <?php
        if (isset($_GET['u']) && preg_match("/^[0-9]+$/", $_GET['u'])) {//传参非法 转到首页
            if (isset($_COOKIE['ch_user_id']) && $_COOKIE['ch_user_id'] === $_GET['u']) {//访问用户自己主页
                header("location:user.php");
                exit;
            };
            // 获取此用户的信息 如果没有 则转到 首页
            include("../admin/ch.class.php");
            $db = new DB();
            $user = $db->getObjListBySql("SELECT `name`, `gender`, `motto`, `head`, `progress` FROM  `ch_user` WHERE `id` = " . $_GET['u'] . "");
            if (count($user) === 0) {
                header("location:../square/square.php");
                exit;
            };
        } else {
            header("location:../square/square.php");
            exit;
        };
        include("../public/header.php");
    ?>
    <div id="main" class="mb50">
        <div class="u-header tc pt50 pb30 mb20">
            <span class="header-img w100 h100 db bc radius50 ofh c mb10 ts4">
                <?php
                    if($user[0]->head == 1) {
                        echo '<img src="./user_img/' .
                            $_GET['u'] .
                            '/head_img/head.jpeg?t=' .
                            time() .
                            '" alt="头像" class="fl" />';
                    } else {
                        echo '<img src="../view/img/user.png" alt="头像" class="fl" />';
                    };
                ?>
            </span>
            <ul class="lh150 fcf">
                <li class="f18 mb5">
                    <?php
                        // 姓名
                        echo $user[0]->name;
                        // 性别
                        switch ($user[0]->gender) {
                            case '1':
                            echo '<i class="u-gender dlb pr ml5 boy" title="男"></i>';
                            break;
                            case '0':
                            echo '<i class="u-gender dlb pr ml5 girl" title="女"></i>';
                        };
                        // 关注
                        if (isset($_COOKIE['ch_user_id'])) {
                            $care = $db->getObjListBySql("SELECT count(`id`) AS care FROM `ch_fans` WHERE `from_care` = " . $_COOKIE['ch_user_id'] . " AND `to_care` = " . $_GET['u']);
                            if ($care[0]->care === '1') {
                                echo '<span id="care" class="dlb bcf fcm pl5 pr5 radius4 cp f14 ml5">已关注</span>';
                            } else {
                                echo '<span id="care" class="dlb bcf fcm pl5 pr5 radius4 cp f14 ml5">未关注</span>';
                            };
                        } else {
                            echo '<span id="care" class="dlb bcf fcm pl5 pr5 radius4 cp f14 ml5">未关注</span>';
                        };
                    ?>
                </li>
                <li title="个性签名">
                    <?php echo $user[0]->motto; ?>
                </li>
            </ul>
        </div>
        <div class="w1100 bc u-con c">
            <div class="u-opton w250 fl">
                <!-- 基本信息列表 info -->
                <ul class="u-info f16 lh300 fcf mb20">
                    <li class="pl20">粉丝
                        <?php
                            $data = $db->getObjListBySql("SELECT count('id') AS 'fans_num' FROM  `ch_fans` WHERE `to_care` = " . $_GET['u'] . "");
                            echo '<a href="../search/fans.php?t=f&u='. $_GET['u'] .'" class="fcm ml20" id="fan">'. $data[0]->fans_num .'</a>';
                        ?>
                    </li>
                    <li class="pl20">关注
                        <?php
                            $data = $db->getObjListBySql("SELECT count('id') AS 'care_num' FROM  `ch_fans` WHERE `from_care` = " . $_GET['u'] . "");
                            echo '<a href="../search/fans.php?t=c&u='. $_GET['u'] .'" class="fcm ml20" id="care">'. $data[0]->care_num .'</a>';
                        ?>
                    </li>
                    <li class="pl20">童言
                        <?php
                            $data = $db->getObjListBySql("SELECT count('id') AS 'says_num' FROM  `ch_says` WHERE `to_who` = " . $_GET['u'] . "");
                            echo '<span class="fcm ml20" id="say">'. $data[0]->says_num .'</span>';
                        ?>
                    </li>
                </ul>
                <!-- 修改个人信息 modify -->
                <div class="u-modify f16 lh300 mb20">
                    <div class="pl20 fcf">资料完善度
                        <?php
                            $progress = (round(($user[0]->progress)/13, 3))*100 . "%";
                            echo '<span class="fcm ml20">'. $progress .'</span>';
                        ?>
                    </div>
                    <div class="modify-show ml20 mr20 mb10  bcf">
                        <?php
                            echo '<span id="infoProce" class="db h1" style="width:'. $progress .'"></span>';
                        ?>
                    </div>
                    <div class="modify-do fcm tc">
                        <?php
                            echo '<a href="../modify/info.php?u='. $_GET['u'] .'">查看他的资料</a>';
                        ?>
                    </div>
                </div>
            </div>
            <div id="says" class="u-says fr ofh">
                <div id="sayLoad" class="lh300 fcf f16 tc">加载中...</div>
                <?php
                    $data = $db->getObjListBySql("SELECT `id`, `create_date`, `aggre_num`, `com_num`, `content`, `img` FROM  `ch_says` WHERE `to_who` = " . $_GET['u'] . " ORDER BY create_date DESC");
                    // foreach 遍历数组对象 开始拼接字符串
                    if ($data) {
                        echo '<script>document.getElementById("sayLoad").remove();</script>';
                        foreach ($data as $say) {
                            echo '<div class="say-item m10 ofh">'.
                                '<div class="say-extra p10 c">'.
                                '<span class="time fl">'. $say->create_date .'</span>'.
                                '</div>'.
                                '<p class="say-con t2 f16 fc3 p10 lh150">'. $say->content .'</p>'.
                                '<img class="say-img db ml40 w700 zout ts4" src="user_img/'. $say->img .'" />'.
                                '<ul class="say-join h30 mt20 p10 c">'.
                                '<li class="comment cp fl mr20" data-id="'. $say->id .'" title="查看评论/回复">'.
                                '<span class="com-icon w30 h30 fl mr5"></span>'.
                                '<span class="com-num fl lh250">'. $say->com_num .'</span>'.
                                '</li>'.
                                '<li class="like cp fl" data-ing="true" data-id="'. $say->id .'" title="点赞">'.
                                '<span class="like-icon w30 h30 fl mr5"></span>'.
                                '<span class="like-num fl lh250">'. $say->aggre_num .'</span>'.
                                '</li>'.
                                '</ul>'.
                                '<div class="comment-con none">'.
                                '<div class="p10">'.
                                '<input class="db bc w700 p10 mb10 radius4 animated" type="text" maxlength="200" placeholder="元芳 你怎么看？" />'.
                                '<div class="com-conf bc">'.
                                '<button class="com-sub mr10 p5 radius4 fcm bcf" data-in="true" data-id="'. $say->id .'" >确定</button>'.
                                '<button class="com-close p5 radius4 fcm bcf">取消</button>'.
                                '</div>'.
                                '</div>'.
                                '<ul class="com-show  p10 fcf">'.
                                '<li class="tc">加载中...</li>'.//将会被替换成响应的评论 或者提示没有评论
                                '</ul>'.
                                '</div>'.
                                '</div>';
                        };
                    } else {
                        echo '<script>document.getElementById("sayLoad").innerHTML = "他没有发表任何数据";</script>';
                    };
                ?>
            </div>
        </div>
    </div>
    <?php
        include("../public/footer.html");
    ?>
    <!-- mask -->
    <div id="loadMask"></div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/user.js"></script>
    <script>
        (function($) {
            var care = {
                canIn: true,
                oldHTML: '',
                exc: function(this$) {
                    if (header.getId()) {
                        if (care.canIn) {
                            care.canIn = false;
                            care.oldHTML = this$.html();
                            this$.html('loading...');
                            // 开始执行
                            $.post('deal_care.php', {
                                'from': header.getId(),
                                'to': <?php echo $_GET['u']; ?>
                            }, function(data, status) {
                                if (status === 'success' && data) {
                                    if (care.oldHTML === '已关注') {
                                        this$.html('未关注');
                                    } else {
                                        this$.html('已关注');
                                    }
                                } else {
                                    $.remaind('网络堵塞 操作失败', true);
                                    this$.html(care.oldHTML);
                                }
                                care.canIn = true;
                            });
                        }
                    } else {
                        $.remaind('亲 你还未登录哦 请登录', true);
                        setTimeout(function() {
                            $.showMask(false);
                        }, 1000);
                    }
                }
            };
            // 点击关注
            $('#care').bind('click', function() {
                care.exc($(this));
            });
        })(jQuery);
    </script>
</body>

</html>
