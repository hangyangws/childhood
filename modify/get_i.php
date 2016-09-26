<?php
if (isset($_POST['id'])) {
    include '../admin/ch.class.php';
    $db = new DB();
    $data = $db->getObjListBySql('SELECT  `name` ,  `gender` ,  `motto` ,  `loving` ,  `qq` ,  `birthday` ,  `phone` ,  `primary_school` ,  `middle_school` ,  `high_school` ,  `university` ,  `hometown` ,  `profession` FROM  `ch_user` WHERE id = ' . $_POST['id'] . '');
    echo json_encode($data);
} else {
    header('location:../index/');
}