<?php
if (isset($_COOKIE['ch_user_name']) && isset($_COOKIE['ch_user_id'])) {
    if (is_uploaded_file($_FILES['user_file']['tmp_name'])) {
        //把上传的文件传到我希望的文件夹下面
        $from = $_FILES['user_file']['tmp_name'];//图片缓存地址
        // 自定函数 从src获取图像信息，并返回从此文件新建的图像
        function getImageHander ($url) {
            //获取此图像的信息
            $size = getimagesize($url);
            //getimagesize() 函数返回图像的一系列信息 并保存在数组中
            switch($size['mime']) {
                case 'image/jpeg':
                    $im = imagecreatefromjpeg($url);
                    break;
                case 'image/gif' :
                    $im = imagecreatefromgif($url);
                    break;
                case 'image/png' :
                    $im = imagecreatefrompng($url);
                    break;
                default: $im = false;
                    break;
            }
            return $im;
        }
        // 获取缓存图片信息真实宽高
        $buffer_width=getimagesize($from)[0];
        $buffer_height=getimagesize($from)[1];
        $rat=$buffer_width/$buffer_height;// 获取缓存图片的宽高比例
        // 根据不同情况设置新画布宽高
        if ($rat > 1) {
            $buffer_width2 = 300;
            $buffer_height2 = 300 / $rat;
        } else {
            $buffer_width2 = 300 * $rat;
            $buffer_height2 = 300;
        }
        $new_img=imagecreatetruecolor($buffer_width2, $buffer_height2);//建立新的画布
        // 获取缓存图片的的hander
        $from=getImageHander($from);
        //把缓存图片复制到新建画布
        imagecopyresized($new_img, $from, 0, 0, 0, 0, $buffer_width2, $buffer_height2, $buffer_width, $buffer_height);
        // 判断是否有此用户的图片目录 没有则建立一个目录 由于要嵌套创建 所以需要 2层目录创建
        $img_path = $_SERVER['DOCUMENT_ROOT'].'/childhood'.'/user/user_img/'.$_COOKIE['ch_user_id'];
        $img_path2 = $img_path.'/head_img';
        //给路径转码 mkdir只识别gbk
        $img_path=iconv("utf-8", "GBK", $img_path);
        $img_path2=iconv("utf-8", "GBK", $img_path2);
        //路径判断
        if (!file_exists($img_path)) {
            mkdir($img_path);
        }
        if (!file_exists($img_path2)) {
            mkdir($img_path2);
        }
        $to = $_SERVER['DOCUMENT_ROOT'].'/childhood'.'/user/user_img/'.$_COOKIE['ch_user_id'].'/head_img'.'/head_buffer.jpeg';
        $to = iconv("utf-8", "GBK", $to);//给路径转码 imagejpeg()只识别gbk
        imagejpeg($new_img, $to);
        imagedestroy($from);//销毁获取图像GD的链接
        imagedestroy($new_img);//销毁创建的新画布
        clearstatcache();// 清空缓存
        header("location:sethead.php");
    } else {
        echo "<script>window.alert('图片不能超过2M！不能上传头像');window.location.href = 'sethead.php';</script>";
    }
} else {
    header("location:../square/square.php");
}
