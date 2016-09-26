<?php
// 传入 用户名 返回此用户的 问题和 答案的json
if (isset($_POST['n'])) {
    $n = $_POST['n'];
    include '../admin/ch.class.php';
    $db = new DB();
    $q_a = $db->getDataByAtr2('ch_user', 'name', $n, 'question', 'answer');
    if (count($q_a) === 1) {
        echo json_encode($q_a);
    } else {
        echo false;
    }
} else {
    // 重定向到首页
    header('location:../index/');
}