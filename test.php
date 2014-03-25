<?php
ignore_user_abort();
date_default_timezone_set('Asia/Shanghai');
set_time_limit(0);

$intval	= 20;
$i = 0;

do{
	$i++;
	$txt	= " 什么是守护进程？".$i.'次。'.date('Y-m-d H:i:s').'\r\n';
	$fp	= fopen('test/log.txt', 'a');
	fwrite($fp, $txt);
	fclose($fp);
	sleep($intval);
}while(true);

?>