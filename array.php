<?php 
header('Content-Type: text/html; charset=utf-8');
echo '<pre>';
function var_array($array)
{
	echo '<pre>';
	var_dump($array);
	echo '</pre>';
}
function printr($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}
function getArr($sNum, $eNum=1, $step=1)
{
	$arr = range($sNum, $eNum, $step);
	$reArr = array();
	foreach($arr as $v)
	{
		$reArr[$v] = rand(0,10);
	}
	unset($arr);
	return $reArr;
}

/**
 * array数组练习
 */
//---------------------------------------------
//array_change_key_case() 改变数组索引的大小写字母，由最后一个参数决定：CASE_UPPER（转化为大写），CASE_LOWER(默认 转化为小写)
$expArr = array(
	'fiRsT' => '1',
	'sEcoNd' => '2',
	'ThIrd' => array(
		'HuiMa' => '3',
		'nengZhuaNma' => '5',
	)
);
printr(array_change_key_case($expArr));//全转化为小写

printr(array_change_key_case($expArr['ThIrd'], CASE_UPPER));//全转化为大写 只对$expArr数组里的某个index键转化

//总结：该函数只影响数组的一层。 并且不会对原数组产生影响

echo '<br/><hr/><br/>';
//---------------------------------------------
//array_chunk($array, $size, false)
//将一个数组分割成一个多维数组，size决定这个数组每$size个成为一个多维数组， true/false决定新数组的键值是否沿用原数组的键
$expArr = array('4','2','6','d','2');
printr(array_chunk($expArr, 3));
//总结：该函数只影响数组的一层。 并且不会对原数组产生影响

echo '<br/><hr/><br/>';
//---------------------------------------------
//array_combine($keyArr, $valArr)
//将两个数组组合成一个数组，$keyArr做为键，$valArr做为值
$expKey = array('g', 'd', 't');
$expVal = array('5', '8', '7');

printr(array_combine($expKey, $expVal));
//该函数同样只影响数组的一层，并且返回一个新数组


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_count_values($array)
//统计$array数组中每个value出现的次数，并以他个value做为新数组的键，出现次数做为value
$array = array('v1'=>'265', 'v2'=>'352', 'v3'=>'265', 'v4'=>'349', 'v5'=>'265');
printr(array_count_values($array));

//总结：该函数只能用于统计值为 string和integer类型的value，其他类型会发warning！


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_diff($array1, $array2...)
//以$array1为基础数组，他的值不出现在其他任何参数数组里的值组成一个新数组
$arr1 = array('v4'=>458, 'gren', 'b5', 'a5');
$arr2 = array('v4'=>598, 'red', 'a5', 'c4');
printr(array_diff($arr1, $arr2));

//总结：拿一个数组到一堆数组中找出这个数组中没有的值，统计、数据对比应该会用到
//array_intersect($array, $parArr, ....)
//该函数同array_diff在功能上一样，只是array_intersect()返回的是共有的数据，array_diff则是只存在于$array中的数据
//

echo '<br/><hr/><br/>';
//---------------------------------------------
//array_diff_assoc($array1, $array2...)
//同 array_diff()函数，但是这个也会拿key进行对比
//


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_diff_key
//同array_diff()函数
//只是这个只拿$array1的key去与其他参数数组进行查找
//


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_diff_uassoc($arr1, $parArr...., 回调函数)
//功能同array_diff()，但是需要用户定义一个回调函数
//未明白该函数的作用
//


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_diff_ukey($arr1, $parArr...., 回调函数)
//功能同array_diff_key(),只不过和array_diff_uassoc一样，需要一个回调函数
//
//

echo '<br/><hr/><br/>';
//---------------------------------------------
//array_fill($startInt, $numInt, $value)
//把$value填充到一个新数组，新数组的索引起始位置开始由$startInt决定，$numInt则控制这个数组生成多少个索引。
//tip：除了$value，$startInt,$numInt必须为数字，否则报错
printr(array_fill(2, 5, 'value'));
//总结：还没想到干啥用


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_fill_keys($arrKeys, $value);
//功能同array_fill()函数。只不过这里用$arrKeys【一个数组的值】来做为新数组的键
$arrKeys = array('45', 'd', 'b', 'c');
printr(array_fill_keys($arrKeys, 'value'));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_filter($arr, callBack回调函数)
//过滤函数，通过对$arr数组的值的判断，如果 callBack回调函数 返回true，则将当前键以及值添加到新的数组里
//TIP:回调函数可以写个规则，来过滤掉里边不符合规则的数组键
function cb($val)
{
	return $val%2 == 0;
}
$array = array('k1'=>3, 'k2'=>5,'k4'=>54654, 'k5'=>8794, 8945, 32549564);
printr($array, 'cb');
//tip:回调函数名建议用引号引起来

//总结：该方法可以做成一个数据过滤的集成
unset($array);


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_flip($array)
//将数组中key和value的关系转换。只支持string和integr类型的键，其他类型将会发出警告，并且有问题的键值不转换。在生成的新的数组，如果键相同，他会不停的替换掉现有键的值
$arr = array('k1'=>'v1', 'k2'=>'v2', 'k3'=>'v4', 'k4'=>'v4', 'k5'=>'v5');
printr(array_flip($arr));
unset($arr);


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_key_exists($key, $array)
//判断一个键是否存在于当前数组中，返回bool。也可用来判断对象
$array = array('cb' => 234, 'dv'=>45, 'one'=>897);
if(array_key_exists('one', $array))
	echo '存在这个数组中';
else
	echo '不存在';


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_keys($array, $selSearch_value)
//返回数组中的键名并组成一个新数组，如果指定了$selSearch_value值，那么将返回数组里等于$selSearch_value的键名
$array = getArr(4, 10);
printr(array_keys($array));
printr(array_keys($array, '5'));//带值的搜索

unset($array);
//总结：这个也可用于数据统计，数据对比验证



echo '<br/><hr/><br/>';
//---------------------------------------------
echo 'array_map:';
//array_map('callBack', $array,...)
//把传入的函数，返回经callback回调函数的返回值
//回调函数也可以返回一个数组。并且，回调函数只接受一个数组里的值传入
function mapCb($n)
{
	return $n*$n*$n;
}
$array = getArr(4, 15);
printr(array_map('mapCb', $array));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_merge($array,$array2...)
//将多个数组组成一个数组，并对数字索引进行重新编写。
$arr1 = getArr(1, 5);
$arr2 = getArr(5, 10);
printr(array_merge($arr1, $arr2));

//总结：将多个数组组成一个新数组。


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_merge_recursive($arr1, $arr2....)
//功能同上。但函数会将键名相同的值组成一个新数组，而不是替换掉
//但如果要用，根据实际情况使用


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_multisort()
//多维数组排序，目前只实现了二维数组排序。三维估计不能排
//该函数会直接改变员数组顺序


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_pad($arr, $size, $value)
//对数组进行填充，如果当前$arr的长度小于$size，那么，就用$value来填充$arr数组，直至$arr的长度与$size相等
//如果$arr的长度大于或等于$size,那么该函数将不会对$arr进行填充。  $size小于0则填充在$arr的左边，大于0则右边


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_pop($array)
//去掉数组的最后一个键。


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_product($arr)
//返回一个数组中所有数值的乘积。
//tip：该函数无法处理非数值类型的数据。如果传入数组里包含‘a、b之类字符串’，那么php会报错
$arr = array(4,5,5);
echo array_product($arr);


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_push($arr, $keyArr)
//将$keyArr添加到$arr数组的末尾，以key/栈的形式添加。
//与array_merge()、array_merge_recursive()两函数的区别：
//	arrap_push()是将一个$keyArr添加到$arr里边，而其他两个函数则是将多个函数连接成一个函数


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_rand($arr, $num=1)
//取出当前数组里的键，取出几个由$num决定，默认为1
//如果$num为1，那么它将返回一个string
//如果$num>1 && $num<count($arr) 函数返回一个数组
//否则php报错
$arr = getArr(5, 15);
printr(array_rand($arr, 4));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_reduce()
//和array_map()类似，通过回调函数，对数组里的数值进行处理，并接受返回值
//该函数返回一个字符串。他会将数组里所有的值进行计算，并返回计算后的值，而array_map则是对每个键下的值进行计算，并返回array
//不是太明白，实例看手册


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_replace($array, $parArr,...)
//用参数数组里键的值替换掉$array里相同键的值
//如果$array数组里在后边的参数数组里没有找到相应的键，那么添加到新数组后边
/*$arr = getArr(4, 10);
$arr2 = getArr(6, 15);
printr($arr);
printr($arr2);*/
$base = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
$replacements = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
printr(array_replace($base, $replacements));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_replace_recursive() 递归替换
//功能同array_replace()一样。区别在于：array_replace_recursive()可以对多维数组操作，并且不改变$array的结构，而array_replace()他最终会返回一个一维数组
$base = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
$replacements = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
printr(array_replace_recursive($base, $replacements));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_reverse($arr)
//将数组里的键按相反顺序排列


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_search($value, $array)
//在$array数组中去找值为$value的键名
//没有找到则返回false
//如果$array数组鸿有多个$value，那么只返回第一个匹配的键
//该函数与array_keys()类似，区别在于返回值上：array_search()只会返回一个匹配的键名，而array_keys()则可以返回一个由所有匹配的键组成的一维数组


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_shift($arr)
//去掉当前$arr数组里的第一个键，并且对后边的数字索引进行重新编排（但不改变原有顺序），非数字索引不变。
//该函数与array_pop()类似，区别在于array_pop()去掉是最后一个，array_shift()去掉脑袋


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_slice($arr, $offset, $length=0, false) 数组截取
//返回当前$arr数组里从$offset处开始偏移，共$length个元素/键，并组成一个新数组返回
//如果$offset或者$length为负数，那么就是向相反方向进行偏移
//感觉和substring()字符串截取类似
//直接用php手册上的实例了
$input = array("a", "b", "c", "d", "e");

$output = array_slice($input, 2);      // returns "c", "d", and "e"
$output = array_slice($input, -2, 1);  // returns "d"
$output = array_slice($input, 0, 3);   // returns "a", "b", and "c"
// note the differences in the array keys
printr(array_slice($input, 2, -1));
printr(array_slice($input, 2, -1, true));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_spslice($arr, $offset, $length)
//同array_slice()函数正好相反，该函数是去掉位于$offset和$length之间这些元素

unset($arr);
echo '<br/><hr/><br/>';
//---------------------------------------------
//array_sum($arr)
//将$arr数组里的所有值进行求和累加，如果是非数值类型的则尝试进行转换，但是大部分转换后为0
//该函数只会影响一层数组，和array_product()类似
$arr = array(
	45,56, 'a', 'b'=>getArr(1, 2),
);
printr($arr);
echo 'array_sum($arr)',array_sum($arr);


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_values($arr)
//将$arr数组里的值提取出来，组成新的数组
$arr = array(
	'k1'=>45,'k2'=>56, 'k3'=>'a', 'b'=>getArr(1, 2),
);
printr(array_values($arr));


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_unique($arr) 对数组进行排重
//对$arr数组进行排重，将重复的值进行过滤。多个相同的值将只保留第一个


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_walk($arr, callback[回调函数], $sel_perfix='')
//对当前数组下的每个键进送到 callback函数里进行处理
//如果加上$sel_perfix参数，回调函数也要三个参数来接收，否则报错
//该函数只影响一层
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
function test_alter(&$item1, $key, $prefix)
{
    $item1 = "$prefix: $item1";
}
printr(array_walk($fruits, 'test_print'));
array_walk($fruits, 'test_alter', 'fruit');


echo '<br/><hr/><br/>';
//---------------------------------------------
//array_walk_recursive()
//功能类似于array_alk();但是他会递归$arr的每一层数组，返回的数组不会改变原有数组的结构


echo '<br/><hr/><br/>';
//---------------------------------------------
//arsort($arr)
//按照数组键名排序数组，可以对字母进行排序。如果排序失败，将返回null


echo '<br/><hr/><br/>';
//---------------------------------------------
//asort()
//功能类似于arsort()，区别在于：asort()是对值进行排序










?>