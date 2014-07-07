
<?php
header("content-type:text/html; charset=utf-8");
/**
 *	@DESC CURL实例使用
*/
exit('测试完成了');
$url	= "http://www.douguo.com/ajax/login";
$curl	= curl_init($url);

//模拟post提交-----------------------------------------------
$post_data	= array(
	'username'	=> 'cntnn11@live.cn',
	'passwd'	=> 'cnpower1',
	'rem'		=> 'on',
);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));

//头信息-----------------------------------------------
$header	= array(
	'POST http://www.douguo.com/ajax/login HTTP/1.1',
	'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
	'Accept: application/json, text/javascript, \*\/*; q=0.01',
	'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
	'Accept-Encoding: gzip, deflate',
	'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
	'X-Requested-With: XMLHttpRequest',
	'Referer: http://www.douguo.com/signin.html?go=',
	'Content-Length: 48',
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);  //设置头信息的地方

//存储cookies-----------------------------------------------
$cookie_file	= tempnam('D:\wamp\www\study\curl', 'cookie');
curl_setopt($curl, CURLOPT_COOKIEJAR,  $cookie_file);

//是否允许内容输出在页面上
//第三个参数：0时可以输出，1时不输出
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//执行
$data	= curl_exec($curl);
echo "<pre>";
echo "<br/><hr/><br/>";
//var_dump(urldecode($data));
//echo "<br/><hr/><br/>";
//关闭
curl_close($curl);

//测试是否登录成功，上传日志
$ch	= curl_init("http://www.douguo.com/diet/create");
//使用上面保存的cookies再次访问
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
$response = curl_exec($ch);
curl_close($ch);
echo $response;



