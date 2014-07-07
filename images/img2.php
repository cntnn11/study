<?php
header("content-type: text/html; charset=utf-8");
header("content-type: image/png;");
/**
 *	在图像中画条线
 *	@author 谭宁宁
 *	@datetime 2012-08-14
*/

/*echo "<h3>二：在图像中画条线 img2.php</h3>";
echo "<p>1.	创建画布，然后使用 imageline(image, x1, y1, x2, y2, color) 函数来画一条线</p>";
echo "<p>2.	左上角为0,0 x表示图像宽度，y表示图像高度。x1,y1表示线条端点位于画布中的坐标起点，x2,y2则表示线条终点。</p>";
echo "<p>3.	color:一个通过imagecolorallocate()函数创建的颜色【!或十六进制颜色值】</p>";
echo "<img src='img2.php' />";
echo "<br/><hr/><br/>";*/

$width	= 200;
$height	= 100;
$timg	= imagecreate($width, $height);
$bgcolor	= imagecolorallocate($timg, rand(1,85), rand(86, 170), rand(171, 255));
$linecolor	= imagecolorallocate($timg, 255, 255, 255);
$x1		= rand(0, $width);
$y1		= rand(0, $height);
$x2		= rand(0, $width);
$y2		= rand(0, $height);
imageline($timg, $x1, $y1, $x2, $y2, $linecolor);
imagepng($timg);
imagedestroy($timg);



?>