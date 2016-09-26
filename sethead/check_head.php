<?php
if (isset($_POST['ok'])) {
    if (!session_id()) {
        session_start();
    }
    // 这里的'/my_big/childhood'.去掉
    $head_src = $_SERVER['DOCUMENT_ROOT'] . '/my_big/childhood' . '/user/user_img/' . $_SESSION['ch_user_id'] . '/head_img/head.jpeg';
    $head_src = iconv("utf-8", "gbk", $head_src);
    if (file_exists($head_src)) {
        echo 'user_img/' . $_SESSION['ch_user_id'] . '/head_img/head.jpeg';
    } else {
        echo '0';
    }
} else { //非法用户去到首页
    header("location:.././index.php");
}
