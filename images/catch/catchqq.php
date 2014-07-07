<?php
$url		= "http://www.cntnn11.com/";
$url		= "http://test.study.com/images/";
$file_img	= "qq.jpg";
if(file_exists($file_img))
{
	unlink($file_img);
}
file_get_contents($url."catch/genimg.php");
if(file_exists($file_img))
{
	header('Content-Description: File Transfer');
	header('Content-Type: image/pjpeg');//
	header('Content-Disposition: attachment; filename='.basename($file_img));
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($file_img));
	ob_clean();
	flush();
	readfile($file_img);
	exit;
}
else
{
	header("content-type: image/jpeg;");
}


