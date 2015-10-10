<?php
require_once("./polyv-php-sdk-master/polyvSDK.php");

$polyv_uid	= '15d8ff7460';
$writetoken	= 'TVWX0oCq1U7DHOS-v1mNa6RkPQQ6Gc41';
$readtoken	= '8hf1bEcRH1-g9XMaS4Vco-r0L15MD7hX';
$privatekey	= '5qw7ULUq1n';
$polyv		= new PolyvSDK($writetoken, $readtoken, $privatekey);


$title		= date('Ymd') . " 极客学院上传 ";
$desc		= "视频的描述";
$tag		= "视频标签";
$cataid		= 1;
$video_url	= 'http://cv2.jikexueyuan.com/html5/course_966/01/video/c966b_01_h264_sd_960_540.mp4?e=1444387275&token=kvniiGWb17-XSxTMHiIVkclXvpopl7nuzl4ANRHA:1USxHFepj6pGTqWBckOoVePiFC0=';
$res		= $polyv->uploadUrlFile($title,$desc,$tag,$cataid,$video_url);


if( is_array($res) && isset($res['swf_link']) )
{
	echo '视频原始地址 -> ' . $res['mp4'] . '<br/>';
	echo '视频播放器地址 -> ' . $res['swf_link'] . '<br/>';
	echo '视频文件大小 -> ' . $res['source_filesize'] . '<br/>';
	echo '视频首页截图 -> ' . $res['first_image'] . '<br/>';
	echo '视频总时长 -> ' . $res['duration'] . '<br/>';
}
echo '<pre>';
print_r( $res );
