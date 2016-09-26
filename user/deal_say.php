<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8" />
    <title>发表说说-童年</title>
    <link rel="shortcut icon" href="../view/img/logo.png" type="image/x-icon" sizes="16x16 32x32" />
    <style>
    body {
        margin: 0;
        background-color: #9c9
    }

    .content {
        color: #fff;
        text-align: center;
        font-size: 18px;
        font-weight: 200;
        letter-spacing: 2px;
        font-family: 'Microsoft YaHei', '微软雅黑', Verdana, Arial, Helvetica, sans-serif;
        -webkit-font-smoothing: antialiased;
        height: 100px;
        line-height: 100px;
        margin-top: 100px;
        background-color: #444;
        background-color: rgba(0, 0, 0, .5)
    }
    </style>
</head>

<body>
    <div id="content" class="content">正在处理说说...</div>
    <?php
    if (isset($_POST['publishText']) && $_COOKIE['ch_user_id']) {
        //getcwd() 获取当前文件路径
        $img_name = time().$_POST['imgSuffix'];
        $upFilePath = getcwd()."/user_img//".$img_name;

        // 以时间戳转存图片
        $ok = move_uploaded_file($_FILES['publishImg']['tmp_name'], $upFilePath);

        if ($ok) {
            // 开始存数据库 说说内容
            include("../admin/ch.class.php");
            $columns = array("to_who", "create_date", "content", "img");
            $values = array($_COOKIE['ch_user_id'], date("Y-m-d H:i:s", time()), $_POST['publishText'], $img_name);
            $db = new DB();
            $id = $db->insertData("ch_says", $columns, $values);
            if ($id !== 0) {
                echo '<script>document.getElementById("content").innerHTML = "发送成功，正在跳转至个人中心...";location.href = "user.php";</script>';
            } else {
                echo '<script>document.getElementById("content").innerHTML = "说说发表失败，请重试";setTimeout(function () {location.href = "user.php";}, 600);</script>';
            }
        } else {//说说图片存取失败
            echo '<script>document.getElementById("content").innerHTML = "说说图片太大，请上传小于4兆的图片";setTimeout(function () {location.href = "user.php";}, 600);</script>';
        }
    } else {
        // 重定向到首页
        header("location:../index/");
    }
    ?>
</body>

</html>
