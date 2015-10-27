<?php
$secretkey	= "5qw7ULUq1n";


// ?vid=e8888b74d19fe43983170b7cf804444d_e&code=abc&t=143020010115550947
$vid	= $_GET['vid'];
$code	= $_GET['code'];
$t		= $_GET['t'];


$username	= '你是非法用户';
$msg		= '请先登录！';
$status		= 2;
if( $code == 'token' )
{
	//$_SESSION['username']	= $role;
	$username				= 'tanning';
	$msg					= 'ok';
	$status					= 1;
}
$sign	= md5( "vid={$vid}&secretkey={$secretkey}&username={$username}&code={$code}&status={$status}&t={$t}" );


$res	= [
	'status'	=> $status,
	'username'	=> $username,
	'sign'		=> $sign,
	'msg'		=> $msg,
];
echo json_encode($res);
