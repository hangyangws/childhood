<?php
if (isset($_POST['i'])) {
    include '../admin/ch.class.php';
    $db = new DB();
    $sql = 'SELECT `c`.`user_id`, `c`.`content`, `c`.`create_date`, `u`.`name`' . ' FROM `ch_comment` `c` LEFT JOIN `ch_user` `u` ON `u`.`id` = `c`.`user_id`' . ' WHERE `tolk_id` = ' . $_POST['i'] . ' ORDER BY `c`.`create_date` DESC';
    $data = $db->getObjListBySql($sql);
    if (count($data) !== 0) {
        echo json_encode($data);
    } else {
        //表示没有数据
        echo '0';
    }
} else {
    header('location:../index/');
}