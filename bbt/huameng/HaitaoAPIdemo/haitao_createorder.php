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


//附加服务
//服务方式
// 1 加固包装  £2  为物品提供额外的填充，缠绕，加固确保安全。只针对外箱缠绕加固。奶粉若选择此种包装，破损不赔
// 2 合并包裹  £3  对多个包裹进行合并节省运费，箱子免费。合并3个包裹以内3镑，超过3个包裹每增加一个包裹加收1镑，超过3个请联系客服。
// 3 拆分包裹   £3  NUL对包裹进行拆箱减重，或者重新分箱，箱子免费。合并3个包裹以内3镑，拆分3个包裹每增加一个包裹加收1镑，超过3个请联系客服。
// 4 货物清点   £5  清点包裹内货物种类和数量。到货数量超过10件，必须选择清点货物，否则少货不赔.按订单计算，每单5镑
// 5 拍照服务   £3  对包裹内商品进行拍照.按订单计算，每单3镑
// 6 仓储服务   £1  客户需要囤货，长期存储。30天内免费，超过30天，每天1镑
// 7 退货服务   £5  将包裹退回原购物网站。五镑为我们的操作费，退货若产生英国或欧洲境内运费，客户需自己承担，具体联系客服报价
$additionalservice->ServiceArrID=1;
//客户请求
$additionalservice->RequestNotes="帮我加的牢固点";
//华盟用户名
$obj->username="username";
//华盟用户密码
$obj->password="password";
//需要添加商品种类的数量
$obj->allCommodityCount=1;
//商品的种类
$obj->commodityType=array("奶粉");
//商品名称
$obj->commodityName=array("milk");
//购物地址链接
$obj->commodityWebsite=array("http://wm-global-express.net");
//海外物流公司
$obj->commodityWlCompany=array("Etao");
//海外物流号
$obj->commodityWlNumber=array("123456789");
//订单号
$obj->commodityOrderno=array("WM123456789");
//商品数量
$obj->commodityQuantity=array(1);
//商品单价（英镑
$obj->commodityPrice=array(10.0);
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
$obj->htadditionalService=array($additionalservice);

//支持输出中文
//echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
//调用接口中的CreateOrder方法
$response= $client->CreateOrder($obj);
if(count($response->CreateOrderResult->Errors)>0)
{
			var_dump($response->CreateOrderResult->Errors);
}
else{
print_r ("状态:".$response->CreateOrderResult->Status."<br/>") ;
echo   "海淘单号:".$response->CreateOrderResult->Htordernumber."<br/>";

	
echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";

}
?>