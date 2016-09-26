<?php
if (isset($_POST['i'])) {
    include '../admin/ch.class.php';
    $db = new DB();
    // 获取值
    $now_num = $db->getOneByID('ch_says', 'id', $_POST['i'], 'aggre_num');
    $now_num = $now_num[0];
    $now_num = (int) $now_num->aggre_num + 1;
    // 更新值
    $db->updateParamById('ch_says', 'id', $_POST['i'], 'aggre_num', $now_num);
    // 返回值
    echo $now_num;
} else {
    header('location:../index/');
}