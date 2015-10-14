<?php
/**
 *	@desc 获取视频的详细信息
*/
require_once("./polyv-php-sdk-master/polyvSDK.php");

$polyv_uid	= '15d8ff7460';
$writetoken	= 'TVWX0oCq1U7DHOS-v1mNa6RkPQQ6Gc41';
$readtoken	= '8hf1bEcRH1-g9XMaS4Vco-r0L15MD7hX';
$privatekey	= '5qw7ULUq1n';
$polyv		= new PolyvSDK($writetoken, $readtoken, $privatekey);


$vid	= '15d8ff74605300f766c4c419e14b047b_1';
$res		= $polyv->getById($vid);


/*if( is_array($res) && isset($res['swf_link']) )
{
	echo '视频原始地址 -> ' . $res['mp4'] . '<br/>';
	echo '视频播放器地址 -> ' . $res['swf_link'] . '<br/>';
	echo '视频文件大小 -> ' . $res['source_filesize'] . '<br/>';
	echo '视频首页截图 -> ' . $res['first_image'] . '<br/>';
	echo '视频总时长 -> ' . $res['duration'] . '<br/>';
}*/
echo '<pre>';
print_r( $res );
