<?php
/**
 *	@DESC 获取吃好网的食材和营养素数据
 *	@author cntnn11
 *	@date 2013-05-16
*/
set_time_limit(0);
header("content-type:text/html;charset=utf-8");
error_reporting(E_ALL);

exit('已经跑完了！');
require_once (dirname(__FILE__).'/../2012/mdb.inc.php');
/**
 *	@DESC 从临时表中取出食材数据
*/
function getTableData($offset = 0, $limit = 10000)
{
	global $table_tmp;
	$data	= array();
	$sql	= "SELECT `id`,`name` FROM `{$table_tmp}` LIMIT {$offset}, {$limit}";
	echo $sql,"\n";
	$query	= mysql_query($sql);
	if($query && !mysql_error())
	{
		while($row=mysql_fetch_array($query))
		{
			$data[$row['id']]	= $row['name'];
		}
	}
	return $data;
}
/**
 *	@DESC 获取临时表中的数据总数
*/
function getTableTmpTotal()
{
	global $table_tmp;
	$total	= 0;
	$sql	= "SELECT COUNT(*) `total` FROM `{$table_tmp}`";
	$query	= mysql_query($sql);
	if(!mysql_error())
	{
		while ($row=mysql_fetch_array($query))
		{
			$total	= $row['total'];
		}
	}
	return $total;
}
/**
 *	@DESC 获取食材的信息
*/
function getShiCaiInfo($data = array())
{
	global $url;
	if(!empty($data))
	{
		foreach ($data as $food_id_old => $shicai)
		{
			$html_string	= file_get_contents($url.$shicai.'.html?'.time());
			if(strpos($html_string, '么有这个食材') === FALSE)
			{
				echo $url.$shicai.'.html?'.time().' --> “'.$shicai.' catch data...<br/>'."\n\r";
				pergInfo($food_id_old, $shicai, $html_string);
				$desc	= $url.$shicai.'.html?'.time().' --> “'.$shicai.' 数据抓取成功!<br/>';
				dgchfood_log($desc, TRUE);
			}
			else
			{
				$desc	= $url.$shicai.'.html?'.time().' --> “'.$shicai.'” 没有数据可以抓取';
				dgchfood_log($desc);
			}
			sleep(1);
		}
	}
}
/**
 *	@DESC 使用正则获取我需要的内容
 *	@reutrn array()
*/
function pergInfo($food_id_old = 0, $shicai = '', $string = '')
{	
	$data	= array();
	$string	= preg_replace('/(\n|\r|\t)/', '', $string);

	$attr_data	= getAttrData($shicai, $string);
	$attr_data2	= getAttr2Data($shicai, $string);
	$data		= array_merge((array)$attr_data, (array)$attr_data2);
	//将获取到的数据写入主表返回一个insert_id做为food_id
	$ins_food_id 	= insFoodData($food_id_old, $shicai, $data);
	if($ins_food_id > 0)
	{
		$yingyangsu	= getYingyangsuData($ins_food_id, $string);
		insYingyangsuData($ins_food_id, $shicai, (array)$yingyangsu);
	}
	return TRUE;
}
/**
 *	@DESC 插入数据库主表，返回插入数据的ID
 *	@return array
*/
function insFoodData($food_id_old = 0, $shicai = '', $data = array())
{
	$ins_id	= 0;
	$data['food_id_old']	= $food_id_old;
	$data['name']			= $shicai;
	$data['flag']			= 1;
	$ins_sql	= "INSERT DELAYED INTO `dg_chfood`(";
	$data_sql	= 'VALUES(';
	foreach ($data as $field => $value)
	{
		$ins_sql	.= "`".$field."`,";
		$data_sql	.= "'".$value."',";
	}
	$data_sql	= substr($data_sql, 0, -1).')';
	$ins_sql	= substr($ins_sql, 0, -1).')'.$data_sql;
	
	$ins_query	= mysql_query($ins_sql);
	dgchfood_log('执行的：'.$ins_sql, 'sql');
	if($ins_query && mysql_error() == '')
	{
		//获取最新插入的ID
		$get_id_query	= mysql_query("SELECT MAX(`id`) AS `id` FROM `dg_chfood`");
		while($row=mysql_fetch_array($get_id_query))
		{
			$ins_id	= $row['id'];
		}
		return $ins_id;
	}
	else
	{
		dgchfood_log('“'.$shicai.'”的SQL写入失败：'.$ins_sql.' --> '.mysql_error());
		return 0;
	}
}
/**
 *	@DESC 插入营养素表
 *	@return array
*/
function insYingyangsuData($food_id = 0, $shicai = '', $data = array())
{
	if(empty($data))
	{
		dgchfood_log('“'.$shicai.'”的 营养素 没有接收到数据');
		return TRUE;
	}
	$ins_sql	= "INSERT DELAYED INTO `dg_chfood_value`(`food_id`,`name`,`val`,`flag`)VALUES";
	foreach ($data as $value)
	{
		$ins_sql	.= "('{$food_id}', '{$value['name']}', '{$value['val']}','1'),";
	}
	$ins_sql	= substr($ins_sql, 0, -1);
	$ins_query	= mysql_query($ins_sql);
	dgchfood_log('执行的：'.$ins_sql, 'sql');
	if(mysql_error())
	{
		dgchfood_log($shicai.'的营养素SQL写入失败：'.$ins_sql.' --> '.mysql_error());
	}
	return TRUE;
}
/**
 *	@DESC 获取别名、分类之类的信息
 *	@return array
*/
function getAttrData($shicai = '', $string = '')
{
	global $conf_arr;
	preg_match_all('/<ul class=\"cs_show_right fz14\">(.*?)<\/ul>/', $string, $matches, PREG_SET_ORDER);
	$attr_str	= $matches[0][1];
	preg_match_all('/<(li)>(.*?)<\/\\1>/', $attr_str, $attr_out, PREG_SET_ORDER);
	foreach ($attr_out as $row)
	{
		preg_match_all('/【(.*)】：(.*)/', $row[2], $result, PREG_SET_ORDER);
		foreach ($result as $title)
		{
			if(!empty($conf_arr[$title[1]]))
			{
				$data[$conf_arr[$title[1]]]	= $title[2];
			}
		}
	}
	return $data;
}
/**
 *	@DESC 获取相关小知识等数据
 *	@return array
*/
function getAttr2Data($shicai = '', $string = '')
{
	global $conf_arr;	
	$data	= array();

	preg_match_all('/(<div class=\"title0710\">(?<name>.*?)<\/div>)\s*(<div class="shadow fz14 lh30">(?<content>.*?)<\/div>)/', $string, $attr_arr, PREG_SET_ORDER);
	foreach ($attr_arr as $key => $value)
	{
		foreach($conf_arr as $shicainame => $field)
		{
			$content	= $value['content'];
			if(strpos($value['name'], $shicai.$shicainame))
			{
				$content	= strip_tags($content);
				$content	= str_replace("&nbsp;", '', $content);
				$content	= preg_replace('/[\s]/', '', $content);
				$data[$field]	= $content;
			}
		}
	}
	return $data;
}
/**
 *	@DESC 获取营养素数据
 *	@return array
*/
function getYingyangsuData($shicai_id = 0, $string = '')
{
	$data = $matches = array();
	preg_match_all('/<div class=\"xx_02\">\s*<div class=\"w140 fl lh30 pl10\">(?<name>.*?)<\/div>\s*<div>(?<val>[\d\.]*)<\/div>\s*<\/div>/', $string, $matches, PREG_SET_ORDER);
	foreach ($matches as $row)
	{
		$tmp['name']	= $row['name'];
		$tmp['val']	= $row['val'];
		$data[]	= $tmp;
	}
	return $data;
}
/**
 *	@DESC 记录日志
*/
function dgchfood_log($desc = '', $status = FALSE)
{
	//$file_path	= '/tmp/';
	$file_path	= 'E:/';
	if($status === TRUE)
	{
		error_log("log ".(date("Y-m-d H:i:s"))." ：{$desc}\n", 3, $file_path."/dg_chfood/dg_chfood_succ".date("Ymd").".log");
	}
	elseif($status == 'sql')
	{
		error_log("log ".(date("Y-m-d H:i:s"))." ：{$desc}\n", 3, $file_path."/dg_chfood/dg_chfood_sql".date("Ymd").".log");
	}
	else
	{
		error_log("log ".(date("Y-m-d H:i:s"))." ：{$desc}\n", 3, $file_path."/dg_chfood/dg_chfood_fail".date("Ymd").".log");
	}
}
//-----------------------------------------------------------------------------------------------------------------
$date	= date('Ymd');
$sql		= "show tables like 'dg_foods'";
$result		= mysql_query($sql);
global $table_tmp,$url,$conf_arr;

$table_tmp	= "tmp_dgfoods{$date}";//临时表名
$url		= "http://www.chihao.com/shicai/";

if(@mysql_affected_rows($result)<=0)
{
	$sql	= "DROP TABLE IF EXISTS `$table_tmp`";
	mysql_query($sql);
	
	$sql	= "CREATE TABLE `{$table_tmp}` SELECT `id`,`name` FROM `dg_foods` WHERE `flag`>=0";
	mysql_query($sql);
}

$limit	= 10;
$total = $offset = 0;
$total	= 0;
$total	= getTableTmpTotal();

$conf_arr	= array(
	'食材名'	=> 'name',
	'别名'		=> 'bieming',
	'分类'		=> 'fenlei',
	'五行属性'	=> 'wuxing',
	'食量建议'	=> 'shiliang',
	'适宜人群'	=> 'shiyirenqun',
	'禁忌人群'	=> 'jinjirenqun',
	'简介'		=> 'jianjie',
	'营养价值'	=> 'yingyangjiazhi',
	'食用效果'	=> 'shiyongxiaoguo',
	'选购'		=> 'xuangou',
	'存储'		=> 'chucangfangshi',
	'烹饪小技巧'=> 'pengrenxiaojiqiao',
);

//查询
for ($offset; $offset < $total; $offset+=$limit)
{
	$data	= getTableData($offset, $limit);
	getShiCaiInfo($data);
}
//删除临时表
$sql	= "DROP TABLE IF EXISTS `$table_tmp`";
mysql_query($sql);
