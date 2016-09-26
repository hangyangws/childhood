<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>导航 - 童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/index.css" />
</head>

<body id="body">
    <?php
        if (isset($_COOKIE['ch_user_name']) && isset($_COOKIE['ch_user_id'])) {
            header("location:../square/square.php");
            exit;
        }
    ?>
    <div id="main">
        <div class="guide pt50 pb20 animated">
            <div class="g-show radius50 bc ts4" title="大家好我是萌萌哒"></div>
        </div>
        <ul class="ls bc w250 tc f20 lh200 ts4 animated">
            <li class="ts4 mb20 radius4"><a class="db" href="../ls/login.php">登录</a></li>
            <li class="ts4 mb20 radius4"><a class="db" href="../ls/register.php">注册</a></li>
            <li class="ts4 mb20 radius4"><a class="db" href="../square/square.php">发现</a></li>
        </ul>
    </div>
    <?php
        require_once "../public/footer-js.html";
    ?>
</body>

</html>
