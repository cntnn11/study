<?php
header("Content-type: text/html; charset=utf-8");
$url	= "http://54.223.61.248:8081/1.0/uiorder/wareyisong/packagein";

$client_id	= "YIBBTBZ";

$param	=  [
	'ware_house_id'	=> 'DEA',
	'oversea_express_no'=>'984923489589234',
	'status'=>'2',
	'client_identifier'=>'YIBBTBZ',
	'inbound_weight'=>'1.23',
	'goods_list'=> [
		'0'=>['upc'=>'123456789','sku_id'=>'123456789','count'=>'2'],
		'1'=>['upc'=>'223456789','sku_id'=>'223456789','count'=>'3'],
	]
];
$post	= [];
$post['param']	= json_encode($param);
$api_url	= $url;

// 税金回调
$transfer_id= 'zhangmeng_test_123';
$tax		= '66.6';
$ver_code	= md5( $client_id . $transfer_id . $tax );
$param	= [
	'transfer_id'	=> $transfer_id,
	'tax'	=> $tax,
	'ver_code'	=> $ver_code,
];
$url	= 'http://54.223.61.248:8081/1.0/uiorder/wareyisong/duty';
//$post['param']	= json_encode($param);
//$api_url	= $url;


$url	= 'http://54.223.61.248:8081/1.0/uiorder/wareyisong/tracking';
$param	= [
	'transfer_id'	=> '1993445712',
	'status'		=> 5,
];
//$post['param']	= json_encode($param);
//$api_url	= $url;
		$ch		= curl_init() or die(curl_error());
		curl_setopt( $ch, CURLOPT_URL, $api_url );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 5);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt( $ch, CURLOPT_REFERER, $refer);
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post);
		$data		= curl_exec( $ch );
		$error		= curl_error( $ch );
		$error_no	= curl_errno( $ch );
		curl_close($ch);
		$data		= json_decode($data, true);
if( $error )
{
echo "<h1>NO</h1>";
var_dump( $error );
}
else
{
//echo "<h1>OK</h1>";
//echo '<pre>';
//echo $data;
	echo json_encode( $data );
}

