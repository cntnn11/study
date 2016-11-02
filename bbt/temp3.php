<?php
/**
 *	@url	http://test.study.com/bbt/temp3.php
*/

echo '<pre>';
$shelfArr   = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', ];


$insertDataArr  = [];
$insertSql      = "INSERT INTO `subconfig`(`fileName`, `subName`, `subId`, `subContent`, `createTime`) VALUES ";
foreach ($shelfArr as $k => $name)
{
    $subId  = $k+1;
    $subContent = json_encode(['name'=>$name]);
    $createTime = date('Y-m-d H:i:s');
    $insertDataArr[]   = "('bbt_stockflow', 'shelfId', '{$subId}', '{$subContent}', '{$createTime}')";
}
echo '<pre>';
print_r($insertDataArr);
echo "<hr/>";

echo $insertSql . " " . implode(",", $insertDataArr) . ";";
