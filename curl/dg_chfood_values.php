<?php
/**
 *	@DESC 获取食材下的营养素数据
 *	@author cntnn11
 *	@date 2013-05-16
*/
ignore_user_abort();
set_time_limit(0);
header("content-type:text/html;charset=utf-8");
error_reporting(E_ALL);
require_once ('D:\wamp\www\douguo\tool\2012\mdb.inc.php');

/**
 *	@DESC 利用curl模拟登录吃好网，获取cookie的文件
 *	@return cookie_file_path
 *	@author cntnn11
*/
function getCookie()
{
	global $cookie_file;
	//获取login登录页面的hash码
	$login	= file_get_contents("http://www.chihao.com/login");
	preg_match_all('/<input type=\"hidden\" name=\"__hash__\" value=\"(.*)?\" \/>/', $login, $matches, PREG_SET_ORDER);
	$hash = '';
	if(!empty($matches[0][1]))
	{
		$hash	= $matches[0][1];
	}

	//模拟提交登录
	$url		= "http://www.chihao.com/index.php?app=home&mod=Public&act=doLogin";
	$curl		= curl_init($url);
	$post_data	= array(
		'email'		=> '752091876@qq.com',
		'password'	=> '198878yhm',
		'__hash__'	=> $hash,
	);
	runlog("login hash：".$hash);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
	$header	= array(
		'POST http://www.chihao.com/index.php?app=home&mod=Public&act=doLogin HTTP/1.1',
		'Host: www.chihao.com',
		'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,\*\/*;q=0.8',
		'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
		'Accept-Encoding: gzip, deflate',
		'Referer: http://www.chihao.com/login',
		'Connection: keep-alive',
		'Content-Type: application/x-www-form-urlencoded',
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_COOKIEJAR,  $cookie_file);//将cookie信息存入我们生成的文件
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_exec($curl);
	curl_close($curl);
}

/**
 *	@DESC 获取营养素的hash数据
 *		该hash码基本上只要获取一次就ok了
 *	@param $cookie_file file_path 登录后获取到的cookie文件
 *	@return $hash string。 【如果没有获取到cookie文件，那么重新登录获取他】
 *	@author cntnn11
*/
function getYinyangsuHash($cookie_file = '')
{
	global $cookie_file;
	$hash		= '';
	if(is_file($cookie_file))
	{
		//获取营养素查询页面需要提交的hash码
		$ch_hash	= curl_init("http://www.chihao.com/index.php?app=home&mod=nutrient&act=nsearch");
		curl_setopt($ch_hash, CURLOPT_HEADER, 0);
		curl_setopt($ch_hash, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch_hash, CURLOPT_COOKIEFILE, $cookie_file);
		$response	= curl_exec($ch_hash);
		curl_close($ch_hash);
		preg_match_all('/<input type=\"hidden\" name=\"__hash__\" value=\"(.*)?\" \/>/', $response, $matches);
		if($matches)
		{
			$hash	= @$matches[1][0];
		}
	}
	return $hash;
}

/**
 *	@DESC 获取吃好网的食材对应ID
 *	@author cntnn11
*/
function getShicaiId($data = array(), $js_data = '')
{
	$search		= array('(',')');
	$replace	= array('\(', '\)');
	$name		= str_replace($search, $replace, $data['name']);
	$preg		= "/new Array[\(\（]{1}(?<shicai_id>\d*?),\'(?<shicai_name>{$name})\'[\)\）]{1}/is";
	preg_match_all($preg, $js_data, $matches, PREG_SET_ORDER);
	
	if(@$matches[0]['shicai_id'] && @$matches[0]['shicai_name'])
	{
		if($matches[0]['shicai_name'] == $data['name'])
		{
			return $matches[0]['shicai_id'];
		}
	}
	return '';
}

/**
 *	@DESC 使用curl模拟提交营养素数据查询
 *	@author cntnn11
*/
function catchData($hash = '', $shicai_id = '')
{
	if(empty($shicai_id))
	{
		runlog("no shicai_id!");
		return '';
	}
	if(empty($hash))
	{
		//记录下日志
		runlog("relogin");
		getCookie();
		$hash	= getYinyangsuHash();
	}
	if(empty($hash))
	{
		runlog("login fail!");
		return '';
	}
	//-----------------------------------抓取数据----------------------------------------
	global $cookie_file;
	$send_url	= "http://www.chihao.com/index.php?app=home&mod=nutrient&act=doSearch";
	$sendch = curl_init($send_url);
	$header	= array(
		'POST /index.php?app=home&mod=nutrient&act=doSearch HTTP/1.1',
		'Host: www.chihao.com',
		'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
		'Accept: \*\/*',
		'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
		'Accept-Encoding: gzip, deflate',
		'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
		'X-Requested-With: XMLHttpRequest',
		'Referer: http://www.chihao.com/index.php?app=home&mod=nutrient&act=nsearch',
		'Connection: keep-alive',
		'Pragma: no-cache',
		'Cache-Control: no-cache',
	);
	curl_setopt($sendch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($sendch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($sendch, CURLOPT_COOKIEFILE, $cookie_file);
	curl_setopt($sendch, CURLOPT_POST, 1);
	curl_setopt($sendch, CURLOPT_POSTFIELDS, 'vChoose='.$shicai_id.'&vTitle%5B%5D=1&vTitle%5B%5D=2&vTitle%5B%5D=3&vTitle%5B%5D=4&vTitle%5B%5D=5&vTitle%5B%5D=6&vTitle%5B%5D=7&vTitle%5B%5D=8&vTitle%5B%5D=9&vTitle%5B%5D=10&vTitle%5B%5D=11&vTitle%5B%5D=12&vTitle%5B%5D=13&vTitle%5B%5D=14&vTitle%5B%5D=15&vTitle%5B%5D=16&vTitle%5B%5D=17&vTitle%5B%5D=18&vTitle%5B%5D=19&vTitle%5B%5D=20&vTitle%5B%5D=21&vTitle%5B%5D=22&vTitle%5B%5D=23&vTitle%5B%5D=24&vTitle%5B%5D=25&vTitle%5B%5D=26&vTitle%5B%5D=27&vTitle%5B%5D=28&vTitle%5B%5D=29&vTitle%5B%5D=30&vTitle%5B%5D=31&vTitle%5B%5D=32&vTitle%5B%5D=33&__hash__='.$hash);
	$data	= curl_exec($sendch);
	curl_close($sendch);
	return $data;
}


/**
 *	@DESC 匹配数据，并插入数据库
 *	@param $content string 抓取到营养素内容
 *	@param $shicai_info array 当前的食材信息，纯粹记录日志用
 *	@author cntnn11
*/
function insData($content = '', $shicai_info = array())
{
	global $yys_data;
	$data = $matches = array();
	$sql_ins = $sql_data = '';
	preg_match_all('/<font color=#ffffff>(?<title>[^<]*?)<\/font>(.*?)(<font color=#333333>(?<val>[^<]*?)<\/font>*\s<font color=#aaaaaa>(?<danwei>[^<]*?)<\/font>|<font color=#cccccc>(?<noval>未测定|未检出?)<\/td>)/', $content, $matches, PREG_SET_ORDER);
	if(!empty($matches))
	{
		foreach ($matches as $row)
		{
			runlog($row['title'],' -- ',$row['val'].$row['danwei'],' == ',in_array($row['title'], $yys_data));
			if(in_array($row['title'], $yys_data))
			{
				$data[$row['title']]	= empty($row['noval']) ? $row['val'].$row['danwei'] : $row['noval'];
			}
		}
		foreach ($yys_data as $title)
		{
			if(!array_key_exists($title, $data))
			{
				$data[$title]	= '未测出';
			}
		}
		if(!empty($data) && is_array($data))
		{
			$sql_ins	= "INSERT DELAYED INTO `dg_chfood_value`(`food_id`, `name`, `val`)VALUES";
			foreach ($data as $name => $val)
			{
				$name	= addslashes($name);
				$val	= addslashes($val);
				$sql_data	.= "('{$shicai_info['id']}', '{$name}', '{$val}'),";
			}
			$sql_data	= substr($sql_data, 0, -1);
			$sql	= $sql_ins.$sql_data;
			$query	= mysql_query($sql);
		
			//$file_path	= '/tmp/';
			$file_path	= 'E:/';
			if($query && mysql_error() == '')
			{
				runlog("SUCC {$shicai_info['id']}-{$shicai_info['name']}");
				error_log("log ".(date("Y-m-d H:i:s"))." {$shicai_info['name']} -- 营养素数据写入成功\n", 3, $file_path."/dg_chfood/log_yys_succ.log");
			}
			else
			{
				runlog("FAIL {$shicai_info['id']}-{$shicai_info['name']} sql-->".$sql);
				error_log("log ".(date("Y-m-d H:i:s"))." {$shicai_info['name']} -- 营养素数据写入失败\n\tsql:{$sql}\n\terror:".mysql_error()."\n", 3, $file_path."/dg_chfood/log_yys_fail.log");
			}
		}
	}
}

/**
 *	@DESC 运行日志
*/
function runlog($desc = '')
{
	error_log("log ".(date("Y-m-d H:i:s"))." RUN {$desc}\n", 3, "E:/dg_chfood/log_yys_run.log");
}


global $cookie_file, $yys_data;
$cookie_file	= tempnam('D:\wamp\www\study\curl', 'cookie');
$yys_data	= array(
	'食部edible',
	'水分water',
	'能量energy(千卡)',
	'能量energy(千焦)',
	'蛋白质protein',
	'脂肪fat',
	'碳水化合物cho',
	'不溶性纤维dietary fiber',
	'胆固醇cholesterol',
	'灰分ash',
	'总维生素a vitamin a',
	'胡萝卜素carotene',
	'视黄醇retinol',
	'硫胺素thiamin',
	'核黄素riboflavin',
	'尼克酸niacin',
	'维生素c vitamin c',
	'维生素e（总） vitamin e	',
	'维生素e（α） vitamin e	',
	'维生素e（β+γ） vitamin e',
	'维生素e（δ） vitamin e',
	'钙 ca',
	'磷 p',
	'钾 k',
	'钠 na',
	'镁 mg',
	'铁 fe',
	'锌 zn',
	'硒se',
	'铜 cu',
	'锰 mn',
	'酒精Alcohol毫升Vol%',
	'酒精Alcohol克Weight',
);

$sql	= "SELECT `id`, `name` FROM `dg_chfood` WHERE `id`>540";
runlog("SQL:{$sql}");
runlog("cookie_file:{$cookie_file}");
$query	= mysql_query($sql);
if($query && mysql_error() == '')
{
	getCookie();
	//获取营养素查询页面的hash码
	include_once 'jsData.php';
	$hash	= getYinyangsuHash();
	runlog("yys_hash：{$hash}");
	while ($row = mysql_fetch_array($query))
	{
		$shicai_id = $content = '';
		$shicai_id	= getShicaiId($row, $js_data);
		runlog("shicai_info：yys->{$shicai_id} id->{$row['id']} name->{$row['name']}");
		$content	= catchData($hash, $shicai_id);
		insData($content, $row);
		sleep(2);
	}
}
runlog('The end!');
break;
//http://test.study.com/curl/dg_chfood_values.php

