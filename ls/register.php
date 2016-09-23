<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>注册-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/ls.css" />
</head>

<body id="body">
    <div id="main">
        <form class="pt50 ls animated">
            <h3 class="w300 bc mb15 c f20 lh200 pl10 pb5 fc3">注册<a href="../square/square.php" class="fr fcm mr10" title="首页">童年网</a></h3>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input data-role="name" name="name" class="ipt-item r-name w200 h40 bct fc3 animated" type="text" placeholder="用户名(长1-20的中英文或数字)" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input data-role="pass" name="pass" class="ipt-item r-pass w200 h40 bct fc3 animated" type="password" placeholder="密码(长6-20的英文或数字)" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input name="repass" class="r-repass w200 h40 bct fc3 animated" type="password" placeholder="重复密码" />
            </label>
            <ul id="question" class="question bc lh150 cp pb5 pt5" title="请选择问题">
                <li class="pl15 pr10 pr ts4 q-live" data-value="1">最怀念的老师</li>
                <li class="pl15 pr10 pr ts4" data-value="2">最向往的圣地</li>
                <li class="pl15 pr10 pr ts4" data-value="3">最难以忘记的人</li>
            </ul>
            <label class="answer w300 bc db mb15 pl10 ts4">
                <input maxlength="10" data-role="answer" name="answer" class="ipt-item r-answer w200 h40 bct fc3 animated" type="text" placeholder="答案(长1-20的中英文或数字)" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4 c ofh" title="不区分大小写">
                <input maxlength="4" data-role="captcha" name="captcha" class="ipt-item r-captcha w200 h40 bct fc3 animated" type="text" placeholder="验证码" class="fl" />
                <img src="captcha.php?n=0" alt="验证码" id="captcha" class="fr cp" title="点击刷新" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input id="submit" name="submit" class="w300 h40 bct f16 fcm" type="button" value="注册" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4 h40 lh300 tc"><a href="login.php" class="db">快速登录</a></label>
        </form>
    </div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/register.js"></script>
</body>

</html>
