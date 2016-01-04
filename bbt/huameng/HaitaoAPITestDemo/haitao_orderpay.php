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
                    $client = new SoapClient('http://192.169.235.191:8989/WebService/htservice.asmx?wsdl',$options); //测试
				   }catch (Exception $e) { 
				echo "<h2>Exception Error!</h2>"; 
				echo $e->getMessage(); }



//华盟用户名
$obj->username="api_test";
//华盟用户密码
$obj->password="api_password";
//海淘订单号
$obj->htorderNumber="WHA151124073609235";
$obj->serviceCode="EMS";
$obj->changeaddress=false;
//收件人名
$obj->receiveAddrContact="Fan shao ping";
//收件人公司名
$obj->receiveAddrCompany="Fan shao ping";
//收件人地址1
$obj->receiveAddrline1="kun ming chuang yi ying guo mei gui yuan 3chuang 2dan yuan 501";
//收件人地址2
$obj->receiveAddrline2=" ";
//收件人地址3
$obj->receiveAddrline3=" ";
//收件人城市
$obj->receiveAddrCity="kun ming shi";
//收件人邮编
$obj->receiveAddrPostcode="215864";
//收件人国家
$obj->receiveAddrCountry="China";
////收件人电话
$obj->receiveAddrPhone="13759542570";
////收件人Email
$obj->receiveAddrEmail="1939283@qq.com";
//收件人身份证号码
$obj->idNumber="1234567890";


//支持输出中文
//echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
//调用接口中的htorderPlace方法
$response= $client->htorderPlace($obj);
if(count($response->htorderPlaceResult->Errors)>0)
{
			var_dump($response->htorderPlaceResult->Errors);
}
else{
print_r ("状态:".$response->htorderPlaceResult->Status."<br/>") ;
echo   "追踪号:".$response->htorderPlaceResult->TrackNumber."<br/>";

	
echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";

}
?>