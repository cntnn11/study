<?php

/**
 *	@desc	读取三个文本进行合并操作
 *			php /Users/cntnn11/www/study/caigouStatis.php >> /Users/cntnn11/www/temp/caigouStatis.csv
*/

$content1	= file_get_contents("/Users/cntnn11/www/webwork/bonbon/worklog/20160315_小修改/采购成功.txt");
$content2	= file_get_contents("/Users/cntnn11/www/webwork/bonbon/worklog/20160315_小修改/官网已发货.txt");
$content3	= file_get_contents("/Users/cntnn11/www/webwork/bonbon/worklog/20160315_小修改/出库已完成.txt");
$header		= ["采购成功", "官网已发货", "出库已完成"];
$body		= [];
$csv		= [];

$arr1		= explode("\n", $content1);
foreach ($arr1 as $str)
{
	$row	= explode("|", $str);
	$row[1]	= trim($row[1]);
	$row[2]	= trim($row[2]);
	if( !empty($row['1']) && $row['1'] != 'sourceWebsite' )
	{
		$body[$row['1']]['采购成功']	= trim($row['2']);
	}
}


$arr2		= explode("\n", $content2);
foreach ($arr2 as $str)
{
	$row	= explode("|", $str);
	$row[1]	= trim($row[1]);
	$row[2]	= trim($row[2]);
	if( !empty($row['1']) && $row['1'] != 'sourceWebsite' )
	{
		$body[$row['1']]['官网已发货']	= trim($row['2']);
	}
}

$arr3		= explode("\n", $content3);
foreach ($arr3 as $str)
{
	$row	= explode("|", $str);
	$row[1]	= trim($row[1]);
	$row[2]	= trim($row[2]);
	if( !empty($row['1']) && $row['1'] != 'sourceWebsite' )
	{
		$body[$row['1']]['出库已完成']	= trim($row['2']);
	}
}

foreach ($header as $title)
{
	foreach ($body as $supplier => $row)
	{
		$csvBody[$supplier][$title]	= !empty($row[$title]) ? $row[$title] : 0;
	}
}


foreach ($csvBody as $supplier => $row)
{
	$csv[]	= $supplier . ',' . implode(',', $row);
}



echo " ," . implode(',', $header) . "\n";
echo implode("\n", $csv);



