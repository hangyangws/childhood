<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>头像修改 - 童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="css/imgareaselect-default.css" />
    <link rel="stylesheet" href="css/my.css" />
</head>

<body id="body">
    <?php
        if (!isset($_COOKIE['ch_user_name']) || !isset($_COOKIE['ch_user_id'])) {
            header("location:../square/square.php");
            exit;
        }
    ?>
    <main class="main">
        <div class="ch-goback_outer">
            <div class="c">
                <a href="../user/user.php" class="ch-goback" title="返回主页">返回/取消</a>
                <div class="ch-who">
                    <?php
                        echo '用户: '.$_COOKIE['ch_user_name'].' (大图区域鼠标点击/拖拽 选择区域 小图预览)';
                    ?>
                </div>
        </div>
        </div>
        <div class="ch-outer ">
            <!-- 宽度 1004px -->
            <div class="ch-outer-con">
                <form class="c fcf" id="head_form" enctype="multipart/form-data" action="pro_head.php" method="POST">
                    <section class="c mb20">
                        <label class="fl">
                            <span class="file_submit_bg" title="浏览本地图片">添加/更换头像</span>
                            <input type="file" name="user_file" class="flie_submit" value="" />
                        </label>
                        <input type="button" title="确认" class="ok" value="确认/上传" />
                    </section>
                    <div id="photo" alt="你的图片">
                        <?php
                            $file_path = $_SERVER['DOCUMENT_ROOT'].'/childhood'.'/user/user_img/'.$_COOKIE['ch_user_id'].'/head_img/head_buffer.jpeg';
                            $file_path = iconv("utf-8", "gbk", $file_path);
                            if (file_exists($file_path)) {
                                $is_file = 1;
                                echo '<img class="db bc" id="pre_head" src="../user/user_img/'.$_COOKIE['ch_user_id'].'/head_img/head_buffer.jpeg?' . time() . '" />';
                            } else {
                                $is_file = 0;
                                echo "<span class='db tc mt20'>还未设置头像</span>";
                            }
                        ?>
                    </div>
                    <div class="sec_outer ml20 ofh">
                        <?php
                            if (isset($is_file) && $is_file == 1) {
                                echo '<img id="sec" src="../user/user_img/'.$_COOKIE['ch_user_id'].'/head_img/head_buffer.jpeg?' . time() . '" />';
                            } else {
                                echo "<span class='db tc mt20'>预览头像<br />(无图片)</span>";
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
        <!-- 错误提示 -->
        <div id="ch-error_outer">
            <div class="middle"></div>
        </div>
    </main>
    <!-- mask -->
    <div id="loadMask"></div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script src="../view/js/jquery.form.js"></script>
    <script src="js/jquery.imgareaselect.pack.js"></script>
    <script src="js/my.js"></script>
</body>

</html>
