<?php
session_start();
header("content-type:text/html; charset=utf-8");
/**
 *	PHP图像操作
 *	@author 谭宁宁
 *	@datetime 2012-08-14
*/
?>
<body>
<?php

echo "<h3>一：生成一张纯色图 img1.php</h3>";
echo "<p>生成一张图片需要告诉浏览器输出图像的类型，所以设置header头信息，然后创建一个画布</p>";
echo "<p>1.	创建一个画布 imagecreate(width, height)</p>";
echo "<p>2.	设置画布背景色：imagecolorallocate(image source, red, green, blue)</p>";
echo "<p>3.	通过 imagegif函数输出图像</p>";
echo "<img src='img1.php' />";
echo "<br/><hr/><br/><br/><br>";

echo "<h3>二：在图像中画条线 img2.php</h3>";
echo "<p>1.	创建画布，然后使用 imageline(image, x1, y1, x2, y2, color) 函数来画一条线</p>";
echo "<p>2.	左上角为0,0 x表示图像宽度，y表示图像高度。x1,y1表示线条端点位于画布中的坐标起点，x2,y2则表示线条终点。</p>";
echo "<p>3.	color:一个通过imagecolorallocate()函数创建的颜色【!或十六进制颜色值】</p>";
echo "<img src='img2.php' />";
echo "<br/><hr/><br/><br/><br>";


echo "<h3>三：在图像中画个文字 img3.php</h3>";
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
echo "<br/><hr/><br/><br/><br>";

echo "<h3>四：在一张图片中生成一些东西 img4.php</h3>";
echo "<p>1.	通过 imagecreatefromjpeg($filename) 载入需要操作的图片</p>";
echo "<p>2.	然后使用imageline、imagettftext、等函数在图片上生成一些内容</p>";
echo "<img src='img4.php' width='102' height='76' />";
echo "<br/><hr/><br/><br/><br>";

echo "<h3>五：做一个简单的加乘验证码</h3>";
echo "<img src='imgcode.php' onclick=javascript:this.src='imgcode.php'; />";
echo "<p>SESSION值：",$_SESSION['scode'],'</p>';
?>
</body>