<?php
if (isset($_POST['ch_name'])) {
    if(!session_id()){session_start();}
    $_SESSION['ch_user_name']=$_POST['ch_name'];
    $_SESSION['ch_user_id']=$_POST['ch_id'];
    setcookie("ch_user_name", $_POST['ch_name'], time()+2592000);
    setcookie("ch_user_id", $_POST['ch_id'], time()+2592000);
    echo true;
} else {
    // 非正常用户进入就重定向到首页
    header('location: ../index/');
}
