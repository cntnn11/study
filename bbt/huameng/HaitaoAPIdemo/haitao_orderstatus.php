<?php
require 'lib/nusoap.php';
try {
		            $options = array
					(
				    'soap_version'=>SOAP_1_1,
				    'exceptions'=>true,
				    'trace'=>1,
				    'cache_wsdl'=>WSDL_CACHE_NONE
		            );	
                     //  $client = new SoapClient('http://wm-global-express.com/ShipService_v5.wsdl',$options); //真实
                    $client = new SoapClient('http://192.169.217.51:65512/WebService/htservice.asmx?wsdl',$options); //测试
				   }catch (Exception $e) { 
				echo "<h2>Exception Error!</h2>"; 
				echo $e->getMessage(); }


////华盟用户名
$obj->username="username";
//华盟用户密码
$obj->password="password";
//海淘订单号
$obj->htorderNumber="WHA151124073609235";

//支持输出中文
//echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
//调用接口中的OrderStatus方法
$response= $client->OrderStatus($obj);
if(count($response->OrderStatusResult->Errors)>0)
{
			var_dump($response->OrderStatusResult->Errors);
}
else{
	print_r ("订单号:".$obj->htorderNumber."<br/>") ;
print_r ("状态码:".$response->OrderStatusResult->Statuscode."<br/>") ;
print_r ("状态:".$response->OrderStatusResult->Status."<br/>") ;
echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
}
?>