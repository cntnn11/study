<?php

$secretkey	= "5qw7ULUq1n";
$type		= $_GET['type'];
$vid		= $_GET['vid'];
$sign		= $_GET['sign'];
switch($type)
{
	case 'upload':
	case 'invalidVideo':
		$md5	= md5( 'upload' . $vid . $secretkey );
		break;
	case 'encode':
	case 'encode_failed':
		$md5	= md5( 'encode' . $vid . $secretkey );
		break;
	case 'pass':
	case 'nopass':
	case 'del':
		$md5	= md5( 'manage' . $vid . $secretkey );
		break;
}

error_log( date('Y-m-d H:i:s') . ' TYPE->' . $type . ' VID->' . $vid . ' sign -> ' . $sign . " == md5->" . $md5 . "\n", 3, "/tmp/pl.log" );




echo '<pre>';

