<?php
header("content-type: text/html; charset=utf-8");
header("content-type: image/gif;");
/**
 *	生成一张纯色背景图
 *	@author 谭宁宁
 *	@datetime 2012-08-14
*/

/*echo "<h3>生成一张画布 img1.php</h3>";
echo "<p>生成一张图片需要告诉浏览器输出图像的类型，所以设置header头信息，然后创建一个画布</p>";
echo "<p>1.	创建一个画布 imagecreate(width, height)</p>";
echo "<p>2.	设置画布背景色：imagecolorallocate(image source, red, green, blue)</p>";
echo "<p>3.	通过 imagegif函数输出图像</p>";*/

$width	= 200;
$height	= 100;
$timg	= imagecreate($width, $height);
$white	= imagecolorallocate($timg, rand(1,255), rand(1, 255), rand(1, 255));
imagegif($timg);
imagedestroy($timg);



?>