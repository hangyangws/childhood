<?php
if (isset($_POST['i'])) {
    $src = getcwd() . '\\user_img\\' . $_POST['im'];
    unlink($src);
    //删除这条说说的图片
    include '../admin/ch.class.php';
    $db = new DB();
    $res = $db->delete('ch_comment', 'tolk_id', $_POST['i']);
    //删除这条说说的评论
    $db->delete('ch_says', 'id', $_POST['i']);
    //删除这条说说的内容
    if ($res) {
        echo '1';
    } else {
        echo '0';
    }
} else {
    header('location:../index/');
}