<?php
/**
 *	@url	http://test.study.com/bbt/testmem.php
 *	@desc	测试对比 compact 与 $data['var']
*/
echo "<pre>";

$pArr	= ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k'];
$valArr = [];
for($i=0; $i<1000; $i++)
{
	$valArr[]	= $i;
}
foreach ($pArr as $arrName)
{
	$$arrName	= $valArr;
}

$empty	= null;
$have	= 'haveval';
$echo	= 'echo';

$nowMem	= memory_get_usage();
echo '当前内存： ' . $nowMem . "<br/>";
echo 'startTime -> ' . microtime() . "<br/>";

/*$data = [];
$data['a']	= $a;
$data['b']	= $b;
$data['c']	= $c;
$data['d']	= $d;
$data['e']	= $e;
$data['f']	= $f;
$data['g']	= $g;
$data['h']	= $h;
$data['i']	= $i;
$data['j']	= $j;
$data['k']	= $k;*/

$data	= compact('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k');
echo 'endTime -> ' . microtime() . "<br/>";
/*$data=[];
$data['empty']	= $empty;
$data['have']	= $have;
$data['echo']	= $echo;
$data	= compact('empty', 'have', 'echo');
$endMem	= memory_get_usage();
echo '使用后： ' . $endMem . ". diff: " . ($endMem - $nowMem) . "<br/>";*/


//print_r($data);
