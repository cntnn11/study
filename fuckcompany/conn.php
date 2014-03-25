<?php 
/**
 *	@DESC 简单mysql统一操作
 *	@author cntnn11
 *	@date 2013-07-30
*/
$db_config['location']	= array(
	'host'		=> "127.0.0.1",
	'username'	=> 'root',
	'pwd'		=> 'ms',
	'db'		=> 'test',
);
$db_config['cntnn11']	= array(
	'host'		=> "localhost",
	'username'	=> 'cntnncom',
	'pwd'		=> '77w9dvY9nL',
	'db'		=> 'cntnncom_my',
);
$type	= 'cntnn11';
$conn	= mysql_connect($db_config[$type]['host'], $db_config[$type]['username'], $db_config[$type]['pwd']) or die('数据库连接失败！');
mysql_set_charset('utf8');
mysql_select_db($db_config[$type]['db']);

function getlist()
{
	$sql	= "SELECT * FROM `fuckcompany` WHERE `flag`>'0' ORDER BY `id` DESC";
	$query	= mysql_query($sql);
	$lists	= array();
	if($query && mysql_error() == '')
	{
		while ($row = mysql_fetch_assoc($query))
		{
			$lists[]	= $row;
		}
		return $lists;
	}
	else
	{
		echo '<pre>';
		var_dump(mysql_error());
		exit('出错了，请通知网站管理员');
	}
}

function insert($data = array())
{
	if(is_array($data) && !empty($data))
	{
		$data_string	= '';
		foreach ($data as $field => $value)
		{
			$data_string	.= " '".$value."',";
		}
		$data_string	= substr($data_string, 0, -1);
		$sql_ins	= "INSERT INTO `fuckcompany` (`company_name`, `reason`, `sub_name`, `other`, `date`, `flag`) VALUES({$data_string}, '0')";
		$query = mysql_query($sql_ins);
		if(mysql_error())
		{
			echo '提交失败！回到首页吧';
			sleep(3);
			//header("Location:http://www.cntnn11.com");
			echo "<script>location.href='http://www.cntnn11.com'</script>";
			exit('ERROR:网站出错，请通知管理员');
		}
	}
	return true;
}
?>


