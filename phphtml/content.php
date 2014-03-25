<?php
$conn	= mysql_connect('127.0.0.1', 'root', 'ms') or die('sql coon error!');
mysql_set_charset('utf8');
mysql_select_db('ciapp', $conn);
header("content-type: text/html; charset='utf-8'");
echo '<pre>';
$id	= intval($_GET['id']);
$sql	= "SELECT * FROM `qy_article` WHERE `a_id`='{$id}'";
$query	= mysql_query($sql);
ob_start();
while ($result = mysql_fetch_array($query))
{
	echo "<body>";
	echo "<h3>标题：{$result['a_tit']}</h3>";
	echo "<div>
			<p>内容：</p>
			{$result['a_content']}
		</div>";
	echo "</body>";
}
$content	= "<head><meta http-equive='content-type' content='text/html; charset=utf-8'></head>";
$content	.= ob_get_contents();
$filename	= 'html/news-id'.$id.'.html';
ob_end_clean();
if(file_exists($filename));
{	file_put_contents($filename, $content);	}
echo $content;
?>