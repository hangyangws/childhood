<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>个人中心-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/user.css" />
</head>

<body id="body">
    <?php
        if (!isset($_COOKIE['ch_user_name']) || !isset($_COOKIE['ch_user_id']) ) {
            header('location:../index/');
            exit;
        };
        include("../admin/ch.class.php");
        $db = new DB();
        $user = $db->getObjListBySql("SELECT `gender`, `motto`, `progress`, `head` FROM `ch_user` WHERE `id` = " . $_COOKIE['ch_user_id'] . "");
        include("../public/header.php");
    ?>
    <div id="main" class="mb50 i-mw">
        <div class="u-header tc pt50 pb30 mb20">
            <a href="../sethead/sethead.php" class="header-img w100 h100 db bc radius50 ofh c mb10 ts4" title="修改头像">
                <?php
                    if($user[0]->head == 1) {
                        echo '<img src="./user_img/' .
                            $_COOKIE['ch_user_id'] .
                            '/head_img/head.jpeg?t=' .
                            time() .
                            '" alt="头像" class="fl" />';
                    } else {
                        echo '<img src="../view/img/user.png" alt="头像" class="fl" />';
                    };
                ?>
            </a>
            <ul class="lh150 fcf">
                <li class="f16 mb5">
                    <?php
                        echo $_COOKIE['ch_user_name'];
                        switch ($user[0]->gender) {
                            case '1':
                                echo '<i class="u-gender dlb pr ml5 boy" title="男"></i>';
                                break;
                            case '0':
                                echo '<i class="u-gender dlb pr ml5 girl" title="女"></i>';
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
                            $data = $db->getObjListBySql("SELECT count('id') AS 'fans_num' FROM  `ch_fans` WHERE `to_care` = " . $_COOKIE['ch_user_id'] . "");
                            echo '<a href="../search/fans.php?t=f&u='. $_COOKIE['ch_user_id'] .'" class="fcm ml20" id="fan">'. $data[0]->fans_num .'</a>';
                        ?>
                    </li>
                    <li class="pl20">关注
                        <?php
                            $data = $db->getObjListBySql("SELECT count('id') AS 'care_num' FROM  `ch_fans` WHERE `from_care` = " . $_COOKIE['ch_user_id'] . "");
                            echo '<a href="../search/fans.php?t=c&u='. $_COOKIE['ch_user_id'] .'" class="fcm ml20" id="care">'. $data[0]->care_num .'</a>';
                        ?>
                    </li>
                    <li class="pl20">童言
                        <?php
                            $data = $db->getObjListBySql("SELECT count('id') AS 'says_num' FROM  `ch_says` WHERE `to_who` = " . $_COOKIE['ch_user_id'] . "");
                            echo '<span class="fcm ml20" id="say">'. $data[0]->says_num .'</span>';
                        ?>
                    </li>
                </ul>
                <!-- 修改个人信息 modify -->
                <div class="u-modify f16 lh300 mb20">
                    <div class="pl20 fcf">个人资料完善度
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
                    <div class="modify-do fcm tc"><a href="../modify/modify.php">查看/修改个人资料</a></div>
                </div>
                <!-- 发表童言 say-->
                <div id="sayPublish" class="u-say f16 h50 lh300 cp tc fcm" title="让更多童友知道你">
                    <span class="say-i fl w50 h50"></span>发表童言
                </div>
            </div>
            <div id="says" class="u-says fr ofh">
                <div id="sayLoad" class="lh300 fcf f16 tc">加载中...</div>
                <?php
                    $data = $db->getObjListBySql("SELECT `id`, `create_date`, `aggre_num`, `com_num`, `content`, `img` FROM  `ch_says` WHERE `to_who` = " . $_COOKIE['ch_user_id'] . " ORDER BY create_date DESC");
                    // foreach 遍历数组对象 开始拼接字符串
                    if ($data) {
                        echo '<script>document.getElementById("sayLoad").remove();</script>';
                        foreach ($data as $say) {
                            echo '<div class="say-item m10 ofh">'.
                            '<div class="say-extra p10 c">'.
                            '<span class="time fl">'. $say->create_date .'</span>'.
                            '<span class="delete fr w20 h20 cp radius50 f16 tc b16" data-img="'. $say->img .'" data-id="'. $say->id .'" title="删除此说说">x</span>'.
                            '</div>'.
                            '<p class="say-con t2 f16 fc3 p10 lh150">'. $say->content .'</p>'.
                            '<img class="say-img db ml40 zin ts4" src="user_img/'. $say->img .'" />'.
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
                            '<input class="say-ipt-item db bc w700 p10 mb10 radius4 animated" type="text" maxlength="200" placeholder="元芳 你怎么看？" />'.
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
                        }
                    } else {
                        echo '<script>document.getElementById("sayLoad").innerHTML = "你没有发表任何数据";</script>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
        include("../public/footer.html");
    ?>
    <!-- tpl -->
    <template id="tpl" class="none">
        <!-- 发表说说模块 -->
        <div class="say-publish middle w400 bcf radius4 animated flipInX">
            <div class="publish-nav p5 c">
                <span class="fl lh150">有什么好的回忆带给大家？</span>
                <span id="closePublish" class="delete fr w20 h20 cp radius50 f16 tc b16" title="取消发送 关闭窗口">x</span>
            </div>
            <form action="deal_say.php" enctype="multipart/form-data" method="POST">
                <input id="imgSuffix" type="hidden" name="imgSuffix" />
                <textarea id="publishCon" class="publish-con radius4 w300 h100 mt20 p5 db bc fc3 b1e0" name="publishText" placeholder="发表内容长度为1-200（只能包含中文数字英文）"></textarea>
                <div class="publish-footer mt10 c">
                    <label class="fl">
                        <span class="img-icon db w30 h30 mr5 cp" title="选择你要分享的图片"></span>
                        <input id="imgFile" type="file" name="publishImg" class="none" />
                    </label>
                    <div id="publishRemind" class="w200 lh200 fl to"></div>
                    <input type="button" class="start-publish fr p5 radius4 fcm b1e0 bcf" value="发布" />
                </div>
            </form>
        </div>
    </template>
    <!-- mask -->
    <div id="loadMask"></div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/layer.js"></script>
    <script src="../view/js/user.js"></script>
</body>

</html>
