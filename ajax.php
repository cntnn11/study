<?php
error_reporting(E_ALL & ~E_NOTICE);
$sqlConn = mysql_connect('127.0.0.1', 'root', 'ms') or die ('链接失败了哦'.mysql_error());
mysql_select_db('tuiguang', $sqlConn);
mysql_set_charset('utf-8', $sqlConn);

$date = !empty($_POST['date']) ? ' and date="'.$_POST['date'].'"' : ' and date="'.date("Y-m-d").'"';
$site_id = !empty($_POST['site_id']) ? ' and site_id="'.$_POST['site_id'].'"' : '';

$sql = "select date,hour,site_id,sum(pv) pv,sum(ip) ip,type from advs_pv_ip_byhour where 1 ".$date.$site_id.' group by date,hour,type order by hour asc';
echo $sql.'<br />';
$result = mysql_query($sql, $sqlConn);
$i = 0;
$reArr = array();
while($i < $num=mysql_fetch_array($result, MYSQL_ASSOC))
{
	if($num)
	{
		$reArr[$i] = $num;
		$i++;
	}
}
$data = array();
foreach($reArr as $k => $v)
{
	$data[$v['hour']]['hour'] = $v['hour'];
	if($v['type'] == 1)
	{	$data[$v['hour']]['advIP'] += $v['ip'];	}
	if($v['type'] == 2)
	{	$data[$v['hour']]['clickIP'] += $v['ip'];	}
	if($v['type'] == 3)
	{	$data[$v['hour']]['regIP'] += $v['regIP'];	}
}
//echo '<pre>';
foreach($data as $kd => $vd)
{
	echo "<li>当前小时：{$vd['hour']} | 展示IP：{$vd['advIP']} | 点击IP：{$vd['clickIP']} | 注册成功IP：{$vd['regIP']}</li>";
}
/* mysql_affected_rows($sqlConn)只有insert、update、delete有用，select没用
 * $result = mysql_query($sql, $sqlConn);
echo '受影响条数：'.mysql_affected_rows($result);*/

/*输出当前链接的所有库
$dataList = mysql_list_dbs($sqlConn);
$countData = mysql_num_rows($dataList);
echo "<select id='selDB' name='selDB' onchange='selectDB(this.value)'>";
while ($i < $countData)
{
	$name = mysql_db_name($dataList, $i);
	echo "<option value='{$name}'>".$name."</option>";
	$i++;
}
echo '</select>';*/
?>