<?php
// 传入用户名 密码 问题 回答 等字段 进行注册(设置session 返回 id js进行跳转)
// 传入用户名 查看此用户名是否已经被注册
if (isset($_POST['n'])) {
    // 提交注册
    include '../admin/ch.class.php';
    $columns = array('name', 'password', 'question', 'answer', 'add_date');
    $values = array($_POST['n'], sha1($_POST['p']), $_POST['q'], $_POST['a'], date('Y-m-d H:i:s', time()));
    $db = new DB();
    // $db是插入数据的id
    $id = $db->insertData('ch_user', $columns, $values);
    setcookie('ch_user_name', $_POST['n'], time() + 3600, '/');
    setcookie('ch_user_id', $id, time() + 3600, '/');
    echo $id;
} else {
    if (isset($_POST['n1'])) {
        // 验证用户名
        $name = $_POST['n1'];
        include '../admin/ch.class.php';
        $db = new DB();
        echo $db->getRowByAtr('ch_user', 'name', $name);
    } else {
        // 重定向到首页
        header('location:../index/');
    }
}