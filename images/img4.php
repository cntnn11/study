<?php
header("content-type: text/html; charset=utf-8");
header("content-type: image/png;");
/**
 *	在图像中画条线
 *	@author 谭宁宁
 *	@datetime 2012-08-15
*/

/*echo "<h3>四：在一张图片中生成一些东西 img4.php</h3>";
echo "<p>1.	通过 imagecreatefromjpeg($filename) 载入需要操作的图片</p>";
echo "<p>2.	然后使用imageline、imagettftext、等函数在图片上生成一些内容</p>";
echo "<img src='img4.php' />";
echo "<br/><hr/><br/><br/><br>";*/

$width	= 400;
$height	= 400;
$timg	= imagecreatefromjpeg("Penguins.jpg");
$string		= "让我在图上画些东西";

$linecolor	= imagecolorallocate($timg, rand(0, 255), rand(0, 255), rand(0, 255));
$x		= rand(0, $width);
$y		= rand(0, $height);
$x1		= rand(0, $width);
$y1		= rand(0, $height);
$x2		= rand(0, $width);
$y2		= rand(0, $height);
imageline($timg, $x1, $y1, $x2, $y2, $linecolor);

$stringcolor	= imagecolorallocate($timg, 255, 255, 255);
imagettftext($timg, rand(14, 20), rand(0, 360), $x, $y, $stringcolor, 'font/msyh.ttf', $string);

imagestring($timg, 5, $x, $y, 'I LIKE PHP', imagecolorallocate($timg, 0, 0, 0));
imagepng($timg);
imagedestroy($timg);
?>