<?php
/**
 *	@url	http://test.study.com/bbt/test.php
*/


$newprocure = [
  "812021137927045120"  => ["errno"=>0,"errmsg"=>"ok","data"=>23553],
  "812021146273710080"  => ["errno"=>0,"errmsg"=>"ok","data"=>23554],
  "1112979779944577"    => ["errno"=>0,"errmsg"=>"ok","data"=>23555],
  "1112980649181313"    => ["errno"=>0,"errmsg"=>"ok","data"=>23556],
];
echo json_encode($newprocure);
exit();
$orderProcureitemIds  = [
  '1112977584750720'    => [
    "1004"=>"1004",
  ],
  "1112978022137985"    => [
    '984'=>'984',
    '985'=>'985',
  ],
  "1112979779944577"    => [
    '993'=>'993',
  ],
  "1112980649181313"    => [
    '997'=>'997',
    '998'=>'998',
  ],

];
echo json_encode($orderProcureitemIds);

exit();
$testHandRet	= array (
  1112977584750720 => 
  array (
    'item' => 2,
    'order' => 2,
    'newOrderArr' => 
    array (
      0 => '812021137914462208',
      1 => '812021137927045120',
    ),
  ),
  1112978022137985 => 
  array (
    'item' => 6,
    'order' => 2,
    'newOrderArr' => 
    array (
      0 => '812021146269515776',
      1 => '812021146273710080',
    ),
  ),
  1112979779944577 => 
  array (
    'newOrderArr' => 
      array (
        1 => "1112979779944577",
      ),
  ),
  1112980649181313 => 
  array (
    'newOrderArr' => 
    array (
      1 => "1112980649181313",
    ),
  ),
);
echo json_encode($testHandRet);

exit();
$orderProcureitemIds['a'][1]	= 1;
$orderProcureitemIds['a'][2]	= 2;
$orderProcureitemIds['a'][3]	= 3;
$orderProcureitemIds['b'][4]	= 4;
$orderProcureitemIds['b'][5]	= 5;
$orderProcureitemIds['b'][6]	= 6;
$reissueProcureitemids	= [];

$list	= ['a','b'];
foreach ($list as $row)
{
	$reissueProcureitemids	= array_merge($reissueProcureitemids, $orderProcureitemIds[$row]);
}

echo "<pre>";
print_r($reissueProcureitemids);
