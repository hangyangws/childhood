<!-- header -->
<style>
    #header,
    .sear-s {
        background-color: rgba(255, 255, 255, .8);
        box-shadow: 0 1px 1px #999;
    }

    .logo {
        background: url('../view/img/logo_web.png') no-repeat;
    }

    .sear-s:hover {
        background-color: rgba(0, 0, 0, .05);
    }

    .h-item li {
        line-height: 50px;
    }

    .h-item a:hover {
        color: #099;
    }
</style>
<script src="../view/js/header.js"></script>
<header id="header" class="w1 pf t0 l0 z1">
    <div class="w1100 bc c">
        <div class="fl h50">
            <a href="../square/square.php" class="logo fl db w200 h50"></a>
            <form action="../search/search.php" method="POST" class="sear-f fl h30 mt10 ml50 bcf ofh">
                <input type="text" name="c" placeholder="搜索用户/空格分开关键词" class="fl w200 h30 ml10 mr10" value="<?php if(isset($_POST['c'])) echo $_POST['c']; ?>" />
                <input type="submit" value="搜索" class="sear-s fl h30 w40 bcf fcm ts4" />
            </form>
        </div>
        <ul class="h-item fr h50 f16">
            <?php
                if (isset($_COOKIE['ch_user_name']) && isset($_COOKIE['ch_user_id'])) {
                    echo '<li class="fl"><span>欢迎你:&nbsp;</span><a href="../user/user.php">' .
                    $_COOKIE['ch_user_name'] .
                    '</a></li>' .
                    '<li class="fl ml15 cp" id="loginOut">注销</li>';
            ?>
                <script>
                    header.addHandler(document.getElementById('loginOut'), 'click', function() {
                        header.delCookie('ch_user_name');
                        header.delCookie('ch_user_id');
                        location.href = "../index/";
                    });
                </script>
            <?php
                } else {
                    echo '<li class="fl"><a href="../ls/login.php">登录</a></li>' .
                    '<li class="fl ml15"><a href="../ls/register.php">注册</a></li>';
                };
            ?>
        </ul>
    </div>
</header>
<div class="h50"></div>
