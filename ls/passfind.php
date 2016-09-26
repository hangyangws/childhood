<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>找回密码-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/ls.css" />
</head>

<body id="body">
    <div id="main">
        <form id="form" class="pt50 ls animated">
            <h3 class="w300 bc mb15 c f20 lh200 pl10 pb5 fc3">找回密码<a href="../square/square.php" class="fr fcm mr10" title="首页">童年网</a></h3>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input data-role="name" name="name" class="ipt-item f-name w200 h40 bct fc3 animated" type="text" placeholder="请输入您的用户名" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4">
                <input id="submit" name="submit" class="w300 h40 bct f16 fcm" type="button" value="确认" />
            </label>
            <label class="w300 bc db mb15 radius4 pl10 ts4 h40 lh300 tc"><a href="passmodify.php" class="db">修改密码</a></label>
        </form>
    </div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/passfind.js"></script>
</body>

</html>
