<?php
if (isset($_POST['i'])) {
    $obj = json_decode($_POST['i']);
    $sql = 'UPDATE `ch_user` SET `name`=\'' . $obj->name . '\',`gender`=\'' . $obj->gender . '\',`motto`=\'' . $obj->motto . '\',`loving`=\'' . $obj->loving . '\',`qq`=\'' . $obj->qq . '\',`birthday`=\'' . $obj->birthday . '\',`phone`=\'' . $obj->phone . '\',`primary_school`=\'' . $obj->primary_school . '\',`middle_school`=\'' . $obj->middle_school . '\',`high_school`=\'' . $obj->high_school . '\',`university`=\'' . $obj->university . '\',`hometown`=\'' . $obj->hometown . '\',`profession`=\'' . $obj->profession . '\',`progress`=\'' . $obj->progress . '\' WHERE `id`=\'' . $obj->id . '\'';
    include '../admin/ch.class.php';
    $db = new DB();
    echo $db->updataBySql($sql);
} else {
    // 非正常用户进入就重定向到首页
    header('location:../index/');
}