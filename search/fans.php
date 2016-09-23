<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8" />
    <title>粉丝和关注-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/search.css" />
</head>

<body id="body">
    <?php
        include("../public/header.php");
        if (isset($_GET['t']) && isset($_GET['u']) && preg_match("/^[0-9]+$/", $_GET['u'])) {
            if ($_GET['t'] === 'f') {
                // 获取粉丝
                $t = '<h3 class="lh400 f20 tc fcf">粉丝列表</h3>';
                $sql = "SELECT `ch_fans`.`from_care` as uid, `ch_user`.`name`, `ch_user`.`gender`, `ch_user`.`motto`, `ch_user`.`loving`, `ch_user`.`progress`, `ch_user`.`head` FROM `ch_user` INNER JOIN `ch_fans` ON `ch_user`.`id` = `ch_fans`.`from_care` WHERE `ch_fans`.`to_care` = " . $_GET['u'];
            } else if ($_GET['t'] === 'c') {
                // 获取关注
                $t = '<h3 class="lh400 f20 tc fcf">关注用户列表</h3>';
                $sql = "SELECT `ch_fans`.`to_care` as uid, `ch_user`.`name`, `ch_user`.`gender`, `ch_user`.`motto`, `ch_user`.`loving`, `ch_user`.`progress`, `ch_user`.`head` FROM `ch_user` INNER JOIN `ch_fans` ON `ch_user`.`id` = `ch_fans`.`to_care` WHERE `ch_fans`.`from_care` = " . $_GET['u'];
            } else {
                header("location:../square/square.php");
                exit;
            }
            include("../admin/ch.class.php");
            $db = new DB();
            $user = $db->getObjListBySql($sql);
        } else {
            header("location:../square/square.php");
            exit;
        }
    ?>
    <div id="main">
        <div class="s-wrap w1100 bc c">
            <?php
                if (!count($user)) {
                    echo '<h3 class="lh400 f20 tc fcf">没有搜索到任何用户</h3>';
                } else {
                    echo $t;
                    // 遍历数组
                    foreach ($user as $u) {
                        echo '<div class="s-each bcf w700 bc c p10 radius4 mb20">'.
                            '<a href="../user/visit.php?u='.$u->uid .'" class="s-head fl db radius50 ofh mr20 ts4">';
                            if($u->head == 1) {
                                echo '<img class="fl" src="../user/user_img/' .
                                    $u->uid .
                                    '/head_img/head.jpeg?t=' .
                                    time() .
                                    '" alt="头像" class="fl" />';
                            } else {
                                echo '<img class="fl" src="../view/img/user.png" alt="头像" class="fl" />';
                            }
                            echo '<ul class="fl lh200">'.
                            '<li><a href="../user/visit.php?u='. $u->uid .'" class="fcm f20 mr10">'. $u->name .'</a></li>';
                        switch ($u->gender) {
                            case '1':
                                echo '<li>性别: <i class="s-gender dlb mr10 pr boy" title="男"></i>';
                                break;
                            case '0':
                                echo '<li>性别: <i class="s-gender dlb mr10 pr girl" title="女"></i>';
                                break;
                            default :
                                echo '<li>性别: 未设置&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                        switch ($u->loving) {
                            case '1':
                                echo '恋爱状况: 单身狗</li>';
                                break;
                            case '0':
                                echo '恋爱状况: 热恋中</li>';
                                break;
                            default :
                                echo '恋爱状况: 未设置</li>';
                        }
                        if ($u->motto) {
                            echo '<li>个性签名: '. $u->motto .'</li>';
                        } else {
                            echo '<li>个性签名: 未设置</li>';
                        }
                        echo '<li>资料完善度: '. (round(($u->progress)/13, 3))*100 . "%" .'</li>' .
                            '</ul>' .
                        '</div>';
                    }
                }
            ?>
        </div>
    </div>
    <?php
        include("../public/footer.html");
        require_once "../public/footer-js.html";
    ?>
</body>

</html>
