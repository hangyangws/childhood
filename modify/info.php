<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8" />
    <title>信息查看 - 童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/loading.css" />
    <link rel="stylesheet" href="../view/css/modify.css" />
</head>

<body id="body">
    <?php
        if (!isset($_GET['u']) || !preg_match("/^[0-9]+$/", $_GET['u'])) { // 非法参数
            header('location:../index/');
            exit;
        };
        if (isset($_COOKIE['ch_user_id']) && $_COOKIE['ch_user_id'] === $_GET['u']) {//已经有用户登录 且访问的是用户自己
            header("location:modify.php");
            exit;
        }

        include("../public/header.php");

        // 获取此用户的信息 如果没有 则转到 首页
        include("../admin/ch.class.php");
        $db = new DB();
        $user = $db->getObjListBySql("SELECT `name`, `gender`, `motto`, `loving`, `qq`, `birthday`, `phone`, `primary_school`, `middle_school`, `high_school`, `university`, `hometown`, `profession`, `progress` FROM  `ch_user` WHERE `id` = " . $_GET['u'] . "");
        if (count($user) === 0) {
            header("location:../index/");
            exit;
        }
    ?>
    <div id="main" class="modify-wrap w1100 bc">
        <h3 class="lh400 f20 tc fcf">
        <?php
            echo $user[0]->name.' — 资料完善度&nbsp;&nbsp;'.(round(($user[0]->progress)/13, 3))*100 . "%";
        ?>
        </h3>
        <div class="m-wrap fc3 f16 pt30 pb20">
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">用户名</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to"><?php echo $user[0]->name; ?></span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">性别</span>
                <span class="fl dlb p5 h20 w300 bcf lh150">
                <?php
                    switch ($user[0]->gender) {
                    case '1':
                        echo '男';
                    break;
                    case '0':
                        echo '女';
                    break;
                    default :
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">个性签名</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->motto !== '') {
                        echo $user[0]->motto;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">恋爱状况</span>
                <span class="fl dlb p5 h20 w300 bcf lh150">
                <?php
                    switch ($user[0]->loving) {
                    case '1':
                        echo '单身狗';
                        break;
                    case '0':
                        echo '热恋中';
                        break;
                    default :
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">QQ</span>
                <span class="fl dlb p5 h20 w300 bcf lh150">
                <?php
                    if ($user[0]->qq !== '') {
                        echo $user[0]->qq;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">手机</span>
                <span class="fl dlb p5 h20 w300 bcf lh150">
                <?php
                    if ($user[0]->phone !== '') {
                        echo $user[0]->phone;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">生日</span>
                <span class="fl dlb p5 h20 w300 bcf lh150">
                <?php
                    if ($user[0]->birthday !== '') {
                        echo $user[0]->birthday;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">小学</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->primary_school !== '') {
                        echo $user[0]->primary_school;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">初中</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->middle_school !== '') {
                        echo $user[0]->middle_school;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">高中</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->high_school !== '') {
                        echo $user[0]->high_school;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">大学</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->university !== '') {
                        echo $user[0]->university;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">家乡</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->hometown !== '') {
                        echo $user[0]->hometown;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="fl w100 mr10 tr">职业</span>
                <span class="fl dlb p5 h20 w300 bcf lh150 to">
                <?php
                    if ($user[0]->profession !== '') {
                        echo $user[0]->profession;
                    } else {
                        echo '未设置';
                    }
                ?>
                </span>
            </label>
        </div>
    </div>
    <?php
        include("../public/footer.html");
        require_once "../public/footer-js.html";
    ?>
</body>

</html>
