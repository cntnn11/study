<?php
/**
 *	@desc	韩国剩余1000多个货的补偿。
 *	@url	http://test.study.com/bbt/20170106/index.php
*/
date_default_timezone_set('Asia/Shanghai');
error_reporting(1);

require_once( "./20170106.韩国11月后未发货订单.1060.price.csv.php" );
echo "<pre>";
//print_r($orderArr);

$msgText		= '“【%s】您好哟！您购买的韩国发货订单【%s】因中韩国际关系问题被延误。小管家为了您能够尽快收到商品，将会尝试召回海关滞留包裹从韩国重新发出。同时您的订单商品小管家会和品牌方申请原价8折出售，折扣金额【%s元】将会原路退还给您，预计1-3个工作日就会到账啦，非常感谢您对我们的支持！”';
$compensateArr	= [];
foreach ($orderArr as $row)
{
	if( empty($row[2]) || empty($row[5]) || empty($row[6]) || empty($row[15]) )
	{
		echo json_encode($row) . "<br/>";
	}
	else
	{
		$orderId	= trim($row[2]);
		$userId		= trim($row[5]);
		$realname	= trim($row[6]);
		$price		= trim($row[15]);
		$mobile		= trim($row[7]);

		$compensateArr[$orderId]['userId']	= $userId;
		$compensateArr[$orderId]['orderId']	= $orderId;
		$compensateArr[$orderId]['realname']= $realname;
		$compensateArr[$orderId]['mobile']	= $mobile;
		$compensateArr[$orderId]['price']	+= $price;
	}
}

$refundOrderArr	= [1002796851200128,1041687088300160,1041687088300160,1041690251264128,1041690251264128,1041690661093504,1041690661093504,1041693382443137,1041693382443137,1041693382443137,1041693382443137,1041693382443137,1041693382443137,1041786285162624,1041825845772416,1041825845772416,1041825845772416,1041901207584897,1041901207584897,1042078974443648,1042078974443648,1042078974443648,1042224212541568,1042224212541568,1042398235885696,1042398235885696,1043656676278400,1044235457560704,1044521944547456,1044521944547456,1046077046161536,1046077046161536,1047746303885440,1047746303885440,1047816264056960,1064603530952833,1112951251304577,1112951251304577,1112978263474304,1132872653865088];

echo "<hr/><hr/><hr/><hr/>";
foreach ($compensateArr as $orderId => $row)
{
	if( in_array($orderId, $refundOrderArr) )
	{
		continue;
	}
	$msg	= sprintf($msgText, $row['realname'], $row['orderId'], $row['price']);
	//echo "{$row['userId']}, {$msg}" . "<br/>";
	//echo "{$row['mobile']}, {$row['userId']}, {$msg}" . "<br/>";
	// 退款的补偿单信息
	$buchangMsg	= "XUDW-韩国商品物流超期，@山总审批8折优惠";
	echo "'{$row['orderId']}, {$row['price']}, {$buchangMsg}<br/>";
}
//print_r($compensateArr);



