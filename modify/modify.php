<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>资料修改-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/loading.css" />
    <link rel="stylesheet" href="../view/css/modify.css" />
</head>

<body id="body">
    <?php
        if (!isset($_COOKIE['ch_user_name']) || !isset($_COOKIE['ch_user_id']) ) {
            header('location:../index/');
            exit;
        };
        include("../public/header.php");
    ?>
    <div id="main" class="modify-wrap w1100 bc i-mw">
        <h3 class="lh400 f20 tc fcf">资料修改</h3>
        <div id="modify" class="m-wrap fc3 f16 pt30 pb20">
            <label id="name" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">用户名</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" data-role="name" />
            </label>
            <label class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">密码</span>
                <a class="fcm mr10" href="../ls/passmodify.php">修改密码</a>
                <a class="fcm" href="../ls/passfind.php">找回密码</a>
            </label>
            <label class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">头像</span>
                <a class="fcm mr10" href="../sethead/sethead.php">头像修改</a>
            </label>
            <label id="gender" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">性别</span>
                <label class="fl mr20 cp">
                    <input type="radio" name="gender" class="fl h30 mr5" value="1" />男</label>
                <label class="fl mr20 cp">
                    <input type="radio" name="gender" class="fl h30 mr5" value="0" />女</label>
            </label>
            <label id="motto" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">个性签名</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="loving" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">是否单身</span>
                <label class="fl mr20 cp c">
                    <input type="radio" name="loving" class="fl h30 mr5" value="1" />单身狗</label>
                <label class="fl mr20 cp c">
                    <input type="radio" name="loving" class="fl h30 mr5" value="0" />恋爱中</label>
            </label>
            <label id="qq" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">QQ</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" />
            </label>
            <label id="phone" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">手机</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" />
            </label>
            <label id="birthday" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">生日</span>
                <input type="text" class="ipt-key modify-hover Wdate fl p5 w300 radius4 ts4 animated" placeholder="格式 1993-01-01" />
            </label>
            <label id="primary_school" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">小学</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="middle_school" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">初中</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="high_school" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">高中</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="university" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">大学</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="hometown" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">家乡</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="profession" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">职业</span>
                <input type="text" class="ipt-key modify-hover fl p5 w300 radius4 ts4 animated" placeholder="长度为1-20的中文英文或数字" />
            </label>
            <label id="submit" class="each-label db bc mb10 c">
                <span class="each-text fl w100 mr10 tr">&nbsp;</span>
                <button class="fl b1e0 p5 bcf radius4">保存修改</button>
            </label>
        </div>
    </div>
    <?php
        include("../public/footer.html");
    ?>
    <div id="loadMask">
        <div class="load-wrap middle">
            <div class="sk-spinner sk-spinner-chasing-dots">
                <div class="sk-dot1"></div>
                <div class="sk-dot2"></div>
            </div>
        </div>
    </div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/modify.js"></script>
</body>

</html>
