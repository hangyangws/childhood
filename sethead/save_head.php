<?php
if (isset($_POST['x'])) {
    $x = $_POST['x'];
    $y = $_POST['y'];
    $w = $_POST['w'];
    // 头像缓存路径 "/childhood". 在公网应该删除
    $from = $_SERVER['DOCUMENT_ROOT']."/childhood"."/user/user_img/".$_COOKIE['ch_user_id']."/head_img/head_buffer.jpeg";
    $from = iconv("utf-8", "gbk", $from);
    // 头像保存的路径 "/childhood". 在公网应该删除
    $to = $_SERVER['DOCUMENT_ROOT']."/childhood"."/user/user_img/".$_COOKIE['ch_user_id']."/head_img/head.jpeg";
    $to = iconv("utf-8", "gbk", $to);
    $from_im = imagecreatefromjpeg($from);//缓存的GD hander
    $to_im = imagecreatetruecolor(100, 100);//建立新的画布
    // 把缓存的头像的用户指定区域放在新建GD画布中
    imagecopyresized($to_im, $from_im, 0, 0, $x, $y, 100, 100, $w, $w);
    imagejpeg($to_im,$to);//保存head.jpeg到指定路径
    // 修改数据库有头像
    include("../admin/ch.class.php");
    $db = new DB();
    // getDataByAtr2 返回查找的一维数组结果 这个数组里面的每一字段都是一个对象
    $save_head = $db->updateParamById('ch_user','id',$_COOKIE['ch_user_id'], 'head', '1');
    // ***************************************************
    imagedestroy($from_im);//销毁获取图像GD的链接
    imagedestroy($to_im);//销毁创建的新画布
    if ($save_head) {
        echo "1";
    } else {
        echo '0';
    }
} else {
    header('location: ../index');
}
