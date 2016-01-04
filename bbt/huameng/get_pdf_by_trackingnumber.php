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





//密码
$obj->Password="api_password";
//账户名
$obj->Username="api_test";
//这个tracking number 就是上个调用返回的第一个参数
$obj->TrackNumber="1157363846999";


//支持输出中文
//echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
//调用接口中的OrderPlace方法
$response= $client->GetLabelByTrackNumber($obj);

$errors=objectToArray(($response->GetLabelByTrackNumberResult->Errors));

if(count($errors)>0)
{
            var_dump($response->GetLabelByTrackNumberResult->Errors);
}
else{

$bina=($response->GetLabelByTrackNumberResult->Label);

//pdf文档长度
 $size =strlen($bina);
// echo $size;
//pdf文档写入
header('Content-type: application/pdf');
header("Content-Length: {$size}");
header('Content-Disposition: attachment; filename="'.$obj->TrackNumber.'".pdf');
//echo $binaaaa;
print_r($bina);
header( "Connection: Close" );
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