<?php
// 传入用户名和密码 进行登录 (设置session 返回 true js进行跳转)
if (isset($_POST['n']) && isset($_POST['p'])) {
    $n = $_POST['n'];
    $p = sha1($_POST['p']);
    include '../admin/ch.class.php';
    $db = new DB();
    // 如果用户登录成功 $id就是这个用户的id 否则$id就是false
    $id = $db->getRowByTwo('ch_user', 'name', $n, 'password', $p);
    if ($id) {
        setcookie('ch_user_name', $n, time() + 3600, '/');
        setcookie('ch_user_id', $id, time() + 3600, '/');
        echo true;
    } else {
        echo false;
    }
} else {
    // 重定向到首页
    header('location:../index/');
}