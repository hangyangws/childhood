<?php
// 传入 用户和 新密码 更新此用户名的密码
if (isset($_POST['n']) && isset($_POST['p'])) {
    $n = $_POST['n'];
    $p = sha1($_POST['p']);
    include '../admin/ch.class.php';
    $db = new DB();
    echo $db->updateParamById('ch_user', 'name', $n, 'password', $p);
} else {
    // 重定向到首页
    header('location:../index/');
}