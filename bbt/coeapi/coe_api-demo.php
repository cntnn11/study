<?php require 'coe_api.php';

header('Content-Type:text/plain;charset=utf-8');

$url = 'http://47.89.29.164:8080/index.php/I/Parcel/batchClaim';

/*
 * 郵包數據，可以進行多個認領
 */
$array = array(
    '873' => array(
        'warehouse_id' => 500, //倉庫ID
        'express_id' => 501, //UPS
        'enum' => '20170620',
        'member_code' => '', //選填
        'parcel_info' => json_encode(array( //郵包詳情
			array(
				'name' => 'Salopette Shortleg / Nearly Black', //貨品名稱, 必填
				'qty' => 1, //貨品數量, 必填
				'unit' => '個', //貨品單位, 必填
				'price' => 34, //貨品價格, 必填
				'safety' => 0 //保險金額, 選填
			),
		)), 
    ),
);
echo "<pre>";
print_r($array);

$return = Api::request($url, json_encode(array('claim' => $array)));
echo "\n----------------------------------------------------------------------------------------------------\n";
print_r($return);