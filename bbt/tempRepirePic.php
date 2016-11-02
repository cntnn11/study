<?php 
/**
 *	@desc	修复pic_meta表数据
 *			处理方案： 将四个sql文件的数据插入到线上
 *			http://test.study.com/bbt/tempRepirePic.php
 *	@date	2016-09-18 11:02:54
*/
echo '<pre>';

// 读取四个文件
$picArr = $insterDataArr = [];
for($i=1; $i<=4; $i++ )
{
	$filePath	= "/Users/cntnn11/www/study/bbt/picMeta/picMeta{$i}.php";
	$contentArr	= [];

	$contentArr	= require_once($filePath);
	$picArr		= array_merge($picArr, $contentArr);
}


$j	= 0;
$k	= 0;
$insterSql	= "INSERT INTO `pic_meta` (`fkey`,`fuse`,`bucket`,`fsize`,`format`,`width`,`height`,`imageAve`,`createTime`,`updateTime`) VALUES";
foreach ($picArr as $row)
{
	error_log($row[0]."\n", 3, "/tmp/repirePicFkey.txt");
	/*if( $j>=500 )
	{
		$j=0;
		$k+=500;
	}
	$insterDataArr[$k]	.= "('{$row[0]}','{$row[1]}','{$row[2]}','{$row[3]}','{$row[4]}','{$row[5]}','{$row[6]}','{$row[7]}','{$row[8]}','{$row[9]}'),";
	$j++;*/
}


/*foreach ($insterDataArr as $rowSql)
{
	$rowSql	= substr($rowSql, 0, -1) . ";";
	error_log($insterSql . $rowSql . "\n", 3, "/tmp/repirePic.sql");
	echo $insterSql . $rowSql . "\n";
}*/


