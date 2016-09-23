<?php
if (isset($_POST['i'])) {
    include '../admin/ch.class.php';
    $time = date('Y-m-d H:i:s', time());
    $columns = array('user_id', 'tolk_id', 'content', 'create_date');
    $values = array($_POST['i'], $_POST['si'], $_POST['c'], $time);
    $db = new DB();
    // 说说表评论数加一
    // 获取值
    $now_num = $db->getOneByID('ch_says', 'id', $_POST['si'], 'com_num');
    $now_num = $now_num[0];
    $now_num = (int) $now_num->com_num + 1;
    // 更新值
    $db->updateParamById('ch_says', 'id', $_POST['si'], 'com_num', $now_num);
    // 评论表插入数据
    if ($db->insertData('ch_comment', $columns, $values)) {
        echo $time . '/' . $now_num;
    } else {
        echo '0';
    }
} else {
    header('location:../index/');
}