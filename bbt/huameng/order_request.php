<?php

try {
		            $options = array
					(
				    'soap_version'=>SOAP_1_1,
				    'exceptions'=>true,
				    'trace'=>1,
				    'cache_wsdl'=>WSDL_CACHE_NONE
		            );	
                    $client = new SoapClient('http://api-test.wm-global-express.net/',$options); //测试
				   }catch (Exception $e) { 
				echo "<h2>Exception Error!</h2>"; 
				echo $e->getMessage(); }




//包裹描述
$obj->Description=array("Gift");
//寄件目的
$obj->PurposeOfShipment=array("Gift");
//物品高度
$obj->Height=array(10.0);
//物品宽度
$obj->Width=array(10.0);
//物品重量
$obj->Weight=array(10.0);
//物品长度
$obj->Length=array(10.0);
//物品价值
$obj->Value=array(10.0);
//物品数量
$obj->Items=1;
//密码
$obj->Password="api_password";
//账户名
$obj->Username="api_test";
//收件人邮编
$obj->RecipeintPostCode="210000";
//收件人地址
$obj->RecipientAddress="nan jing shi yu hua tai qu ";
//收件人城市
$obj->RecipientCity="nanjing";
//收件人公司
$obj->RecipientCompanyName="lisan";
//收件人名
$obj->RecipientContactName="lisan";
//收件人国家
$obj->RecipientCountry="China";
//收件人电话
$obj->RecipientPhone="15236984561";
//发件人地址
$obj->SenderAddress="The No 9 Street";
//发件人城市
$obj->SenderCity="Birmingham";
//发件人公司
$obj->SenderCompanyname="WM";
//发件人姓名
$obj->SenderContactName="WM";
//发件人国家
$obj->SenderContry="UK";
//发件人电话
$obj->SenderPhone="32831321";
//发件人邮编
$obj->SenderPostCode="B29 7sn";
//国际服务方式,这个参数很重要，目前有EMS, 荷兰邮政 postnl, 英国皇家邮政PF 相关服务，荷兰邮政与英国皇家邮政的某些服务测试版本不稳定
$obj->ServiceCode="ems";
//寄件日期
$obj->Shippingdate="2015-10-20";
//



//支持输出中文
//echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
//调用接口中的OrderPlace方法
$response= $client->OrderPlace($obj);


$errors=objectToArray(($response->OrderPlaceResult->Errors));

if(count($errors)>0)
{
			var_dump($response->OrderPlaceResult->Errors);
}
else{
    echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
echo "Tracking number:".$response->OrderPlaceResult->TrackNumber."<br/>" ;
echo   "Leader number:".$response->OrderPlaceResult->LeaderOrderNumber."<br/>";
echo " Order number:".$response->OrderPlaceResult->OrderNumber."<br/>";
}



function objectToArray($d) 
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}

?>