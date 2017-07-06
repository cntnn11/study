<?php 
/**
 *	@desc	修复宜送没有物流信息的。
 *			处理方案： 推送到快递100中获取物流信息。
 *			http://test.study.com/bbt/importtag.php
 *	@date	2016-07-23 14:19:35
*/
echo '<pre>';

$tagData= [];
$tagCsv	= file_get_contents("./20161105_import_tag.csv");
$tagCsv	= str_replace(["\r", "\n","\r\n"], '-', $tagCsv);
$tagArr	= explode("-", $tagCsv);

$tagNameArr	= !empty($tagArr[0]) ? explode(",", $tagArr[0]) : [];
if( !empty($tagArr) && is_array($tagArr) && !empty($tagNameArr) )
{
	$tempTagArr	= $tagArr;
	array_shift($tempTagArr);
//print_r($tagNameArr);
//print_r($tempTagArr);
	foreach ($tempTagArr as $tagChar)
	{
		$rowArr	= explode(",", $tagChar);
		foreach ($rowArr as $k => $tag)
		{
			if( !empty($tagNameArr[$k]) && !empty($tag) )
			{
				$tagData[$tagNameArr[$k]][]	= $tag;
			}
		}
	}
}
else
{
	echo json_encode([' ERROR ',$tagNameArr, $tagArr[0]]);
}


if( !empty($tagData) )
{
	foreach ($tagData as $tagName => $row)
	{
		$row	= array_unique($row);
		echo $tagName . "," . (implode(",", $row)) . "<br/>";
	}
}
else
{
	echo json_encode(['errno'=>500, 'errmsg'=>'fail!']);
}
