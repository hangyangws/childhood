<?php
if (!session_id()) {
    session_start();
}
include("../admin/ch.class.php");
function PostTo($mySql, $witch)
{
    $db = new DB();
    if ($witch != 'school') {
        $data = $db->getOneBySql($mySql, $witch);
    } else { //关于学校的分支
        $data = $db->getObjListBySql($mySql);
    }
    echo json_encode($data);
}
if (isset($_POST['ok'])) {
    switch ($_POST['type']) {
        case 'love':
            $sql = 'SELECT gender FROM ch_user_basic WHERE id=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'gender');
            break;
        case 'bir':
            $sql = 'SELECT birthday FROM ch_user_life WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'birthday');
            break;
        case 'scho':
            $sql = 'SELECT primery_school,middle_school,height_school,university FROM ch_user_life WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'school');
            break;
        case 'home':
            $sql = 'SELECT home_town FROM ch_user_life WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'home_town');
            break;
        case 'mot':
            $sql = 'SELECT motto FROM ch_user_basic WHERE id=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'motto');
            break;
        case 'city':
            $sql = 'SELECT now_place FROM ch_user_society WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'now_place');
            break;
        case 'pos':
            $sql = 'SELECT profession FROM ch_user_society WHERE owner=\'' . $_SESSION['ch_user_id'] . '\'';
            PostTo($sql, 'profession');
            break;
        default:
            break;
    }
} else {
    header("location:../index/");
}
