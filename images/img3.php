<?php
header("content-type: text/html; charset=utf-8");
header("content-type: image/png;");
/**
 *	在图像中画条线
 *	@author 谭宁宁
 *	@datetime 2012-08-14
*/

/*echo "<h3>三：在图像中画个文字 img3.php</h3>";
echo "<p>1.	创建画布，然后使用 imagestring(image, font, x, y, string, color)函数写一个简单的英文文字</p>";
echo "<p>2.	左上角为0,0 xy表示文字的左顶点的位置</p>";
echo "<p>3.	color:一个通过imagecolorallocate()函数创建的颜色【!或十六进制颜色值】</p>";
echo "<p>4.	如果 font 是 1，2，3，4 或 5，则使用内置字体 [1~5表示字体大小，5最大]</p>";
echo "<p>5.	GD库可以输出utf-8的中文字符，如果是GBK或GB2312则需要icon()函数转码</p>";
echo "<p>6.	使用 imagettftext(image, size, angle, x, y, color, fontfile, text) 生成一幅中文文字图像</p>";
echo "<p>7.	size指定该文字的大小，单位为像素px</p>";
echo "<p>8.	angle 文字的角度，按逆时针方向转动</p>";
echo "<p>9.	x 表示文字的‘左下角’[区别于imagestring]位置</p>";
echo "<p>10.y 表示改文字的基线位置？</p>";
echo "<p>11.fontfile 文字使用的字体。此处建议将需要用到的字体统一放置在某个目录下，不建议使用系统库。linux和win下路径有区别。</p>";
echo "<p>12.text 不超过127个字符</p>";
echo "<img src='img3.php' />";
echo "<br/><hr/><br/><br/><br>";*/

$width	= 400;
$height	= 400;
$timg	= imagecreate($width, $height);
$bgcolor	= imagecolorallocate($timg, rand(1,85), rand(86, 170), rand(171, 255));

$textAr	= array('经','典','问','候','Hell','World','中','文','版','：','你','好','世','界！');

foreach ($textAr as $string)
{
	$linecolor	= imagecolorallocate($timg, rand(0, 255), rand(0, 255), rand(0, 255));
	$x		= rand(0, $width);
	$y		= rand(0, $height);
	$x1		= rand(0, $width);
	$y1		= rand(0, $height);
	$x2		= rand(0, $width);
	$y2		= rand(0, $height);
	imageline($timg, $x1, $y1, $x2, $y2, $linecolor);

	$stringcolor	= imagecolorallocate($timg, rand(0, 255), rand(0, 255), rand(0, 255));
	//imagestring($timg, 5, $x, $y, 'I LIKE PHP', $stringcolor);//该函数不支持中文，会乱码的
	imagettftext($timg, rand(14, 20), rand(0, 360), $x, $y, $stringcolor, 'font/msyh.ttf', $string);
}
imagestring($timg, 5, $x, $y, 'I LIKE PHP', imagecolorallocate($timg, 0, 0, 0));
imagepng($timg);
imagedestroy($timg);
?>