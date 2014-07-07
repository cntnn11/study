<?php
/**
 *	实例测试页面
 *	@time 2012-12-23
 *	@author cntnn11
*/
//开启缓存 [通过php.ini设置可以打开]
ob_start();
echo '<p>我在头信息的前面</p>';
//发送一个头信息
header("content-type:text/html; charset=utf-8");

echo '<p>我在头信息的后边</p>';

//我清楚缓冲区的内容
//ob_clean();

//我不仅清除缓冲区的内容，还关掉了ob_start();
//这下，下边不能发送头信息了，不然php报错！
//ob_end_clean();


//将缓冲区的内容写入文件
$file	= "html/index.html";
if(is_file($file))
{	unlink($file);	}
else
{
	//获取缓存的内容
	$contents	= ob_get_contents();
	file_put_contents($file, $contents);
}
?>


<?php
if(is_file($file))
{
?>
<hr>
<h3>缓存区的内容</h3>
<iframe src='<?php echo $file; ?>' ></iframe>;
<hr>
<?php
}
else
{	echo '没有该文件！';	}
?>