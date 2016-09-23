<?php
if (!session_id()) {
    session_start();
}
include("../admin/ch.class.php");
function PostTo($mySql)
{
    $db   = new DB();
    $data = $db->getObjListBySql($mySql);
    echo json_encode($data);
}
if (isset($_POST['type'])) {
    $from   = $_POST['from'];
    $limit  = $_POST['limit'];
    $gender = $_POST['gender'];
    switch ($_POST['type']) {
        case 'love':
            $sql = "SELECT id,name,gender,have_head" . " FROM ch_user_basic WHERE id!=" . $_SESSION['ch_user_id'] . " AND" . " gender=" . $gender . " LIMIT " . $from . "," . $limit;
            PostTo($sql);
            break;
        case 'bir':
            $sql = 'SELECT birthday FROM ch_user_life WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql);
            break;
        case 'scho':
            $sql = 'SELECT primery_school,middle_school,height_school,university FROM ch_user_life WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql);
            break;
        case 'home':
            $sql = 'SELECT home_town FROM ch_user_life WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql);
            break;
        case 'mot':
            $sql = 'SELECT motto FROM ch_user_basic WHERE id=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql);
            break;
        case 'city':
            $sql = 'SELECT now_place FROM ch_user_society WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql);
            break;
        case 'pos':
            $sql = 'SELECT profession FROM ch_user_society WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql);
            break;
        default:
            break;
    }
} else {
    header("location:../index/");
}
