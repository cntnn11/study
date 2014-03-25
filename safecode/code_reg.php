<?php
//生成验证码图片
Header("Content-type: image/PNG");
$code = '';
$im = imagecreate(62,20);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
$gray = ImageColorAllocate($im, 200,200,200);
imagefill($im,0,0,$gray);    //改了这里的参数

//生成随机5位字符
$authnum = strtoupper(substr(md5(rand()),20,5));
//将验证码放入Session
session_start();
//将验证码绘入图片
imagestring($im, 5, 10, 3, $authnum, $black);
//设置干扰像素
for ($i=0;$i<=128;$i++) {
    $point_color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
    imagesetpixel($im,rand(2,128),rand(2,38),$point_color);
}
$_SESSION["check_num"] = $authnum;
ImagePNG($im);
ImageDestroy($im);
?>