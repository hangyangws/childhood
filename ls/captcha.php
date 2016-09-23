<?php
// 生成验证码
if (!session_id()) {
    session_start();
}
$show_text = '';
$pattern = '123456789abcdefghijkmnpqrstwxyABCDEFGHIJKMNPQRSTWXY';
for ($i = 0; $i < 4; $i++) {
    $show_text .= $pattern[mt_rand(0, 50)];
}
//把验证码放在回话里面
$_SESSION['show_text'] = $show_text;
//建立画布
$img = imagecreatetruecolor(80, 40);
//设置几种颜色
$bg_color = imagecolorallocate($img, rand(120, 240), rand(130, 240), rand(130, 240));
$text_color = imagecolorallocate($img, rand(30, 100), rand(30, 100), rand(30, 100));
$line_color = imagecolorallocate($img, rand(100, 180), rand(100, 200), rand(80, 180));
$line_color2 = imagecolorallocate($img, rand(100, 180), rand(100, 200), rand(80, 180));
$dot_color = imagecolorallocate($img, rand(0, 80), rand(0, 80), rand(0, 80));
//给画布填充颜色
imagefilledrectangle($img, 0, 0, 80, 40, $bg_color);
//给画布填上文字
imagestring($img, 5, rand(0, 40), rand(0, 20), $show_text, $text_color);
//给画布画上扰乱视线的线条和点
for ($i = 0; $i < 10; $i++) {
    imagesetpixel($img, rand() % 80, rand() % 40, $dot_color);
    if ($i < 1) {
        imageline($img, 0, rand() % 40, 80, rand() % 40, $line_color2);
        imageline($img, 0 + mt_rand(1, 15), rand() % 40, 80 - mt_rand(1, 20), rand() % 40, $line_color);
    }
}
//通过首部传送到浏览器
header('Content-type:image/png');
imagepng($img);
//图像一定要清理掉
imagedestroy($img);