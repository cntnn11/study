<?php
$conn	= mysql_connect('127.0.0.1', 'root', 'ms') or die('sql coon error!');
mysql_set_charset('utf8');
mysql_select_db('ciapp', $conn);
header("content-type: text/html; charset='utf-8'");

$sql	= "SELECT * FROM `qy_article` WHERE `a_status` = 1";
$query	= mysql_query($sql, $conn);
$url	= "html/news-id";
while($result	= mysql_fetch_array($query))
{
	$list[$result['a_id']]	= $result;

	if(is_file($url.$result['a_id'].".html"))
	{
		$list[$result['a_id']]['url']	= $url.$result['a_id'].".html";
	}
	else
	{	$list[$result['a_id']]['url']	= 'content.php?id='.$result['a_id'];	}

}
mysql_free_result($query);
mysql_close($conn);
?>
<body>
<table>
	<tr>
		<td>ID</td>
		<td>标题</td>
		<td>操作</td>
	</tr>
	<?php foreach ($list as $row): ?>
	<tr>
		<td><?php echo $row['a_id'];?></td>
		<td><a href='<?php echo $row['url'];?>' target='_bank'><?php echo $row['a_tit'] ?></a></td>
		<td><a href='#'>生成静态</a></td>
	</tr>
	<?php endforeach; ?>
</table>


</body>