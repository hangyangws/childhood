<?php
// 查看验证码是否正确
if (isset($_POST['c'])) {
    // 验证验证码
    if (!session_id()) {
        session_start();
    }
    if (strtoupper($_SESSION['show_text']) === strtoupper($_POST['c'])) {
        echo true;
    } else {
        echo false;
    }
} else {
    // 重定向到首页
    header('location:../index/');
}