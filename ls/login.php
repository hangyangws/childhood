<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>登录 - 童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/ls.css" />
</head>

<body id="body">
    <?php
        if (isset($_COOKIE['ch_user_name']) && isset($_COOKIE['ch_user_id'])) {
            header('location: ../square/square.php');
            exit;
        };
    ?>
    <div id="main">
        <form class="pt50 ls animated">
            <h3 class="w300 bc mb15 c f20 lh200 pl10 pb5 fc3">登录<a href="../square/square.php" class="fr fcm mr10" title="首页">童年网</a></h3>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input data-role="name" name="name" class="ipt-item l-name w200 h40 bct fc3 animated" type="text" placeholder="用户名" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input data-role="pass" name="pass" class="ipt-item l-pass w200 h40 bct fc3 animated" type="password" placeholder="密码" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4 c ofh" title="不区分大小写">
                <input data-role="captcha" name="captcha" class="ipt-item l-captcha w200 h40 bct fc3 animated" type="text" placeholder="验证码" class="fl" />
                <img src="captcha.php?n=0" alt="验证码" id="captcha" class="fr cp" title="点击刷新" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input id="submit" name="submit" class="w300 h40 bct f16 fcm" type="button" value="登录" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4 h40 lh300 tc"><a href="register.php" class="db">快速注册</a></label>
            <label class="w300 bc db mb15 radius4 pl10 ts4 h40 lh300 tc"><a href="passfind.php" class="db">找回密码</a></label>
        </form>
    </div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/login.js"></script>
</body>

</html>
