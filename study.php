<?php 
header("Content-Type: text/html; charset=utf-8");
echo '<pre>';
?>
<body>
<?php
echo '<h3>list()不是函数，而是一种语言结构;</h3>';
echo '<p>将一个数组里的值按照数字索引赋值给list($n1, $n2, $n3...)里的变量';
echo '<p>list() 仅能用于数字索引的数组并假定数字索引从 0 开始。</p>';
echo '<p>exp:</p>';
$arr	= array('v1', 'v2', 'v3');
list($n1, $n2, $n3)	= $arr;
echo '<p>$n1=',$n1,'</p>';
echo '<p>$n2=',$n2,'</p>';
echo '<p>$n3=',$n3,'</p>';
echo '<p>可用于mysql数据返回，while(list($field1, $f2)=mysql_fetch_array($rs))</p>';
echo '<hr/><br/>';

echo '<h3>array_unshift($arr, $var) $arr头部添加若干$var元素</h3>';
echo '<p>如果$arr的键值为数字，那么添加新元素后将更新元素的键值。非数字键则不受影响</p>';

echo '<p>exp:</p>';
$arr2	= array('zhi', 'bbb', 'cc'=>'ddd');
array_unshift($arr2, 'add1', 'add2');
var_dump($arr2);
echo '<hr/><br/>';

echo '<h3>array_push($arr, $var1) 在数组末尾添加元素若干元素</h3>';
echo '<p>新加入的元素其键值为数组里最大的数字键+1</p>';
echo '<p>该方法同array_push()相同。只不过一个在数组头部添加，一个在数组末尾添加</p>';
echo '<p>exp:</p>';
$arr4	= array('d1', 'd2', 'b4'=>'d4', 'd3');
array_push($arr4, 'd2', 'd4', array('b1','b2'));
var_dump($arr4);
echo '<hr/><br/>';

echo '<h3>array_shift() 将数组的头一个元素删除掉</h3>';
echo '<p>执行后，数字键按照顺序重新更新，非数字键元素保持不变</p>';
echo 'exp:';
$arr3	= array('w1', 'w2', 'w3', 'k2'=>'w4', 'k1'=>'w5');
array_shift($arr3);
var_dump($arr3);
echo '<hr/><br/>';

echo '<h3>array_pop($arr) 删除数组最后一个的元素</h3>';
echo '<p>把数组最后的元素删掉，长度减一。和array_shift相反</p>';
echo '<p>exp:</p>';
$arr5	= array('p1', 'p2', 'p3', 'p4', 'p5');
array_pop($arr5);
var_dump($arr5);
echo '<hr/><br/>';

echo '<h3>in_array($var, $arr) 验证变量$var是否是$arr数组里的一个元素</h3>';
echo '<p>只要存在与$var变量相同的元素，那么则返回1 否则返回0</p>';
echo '<p>exp:</p>';
$arr6	= array('bb', 'cc', 'aa', 'hh', 'tt', 'c'=>'cc');
$var6	= 'bb';
echo in_array($var6, $arr6);
echo '<hr/><br/>';

echo '<h3>array_key_exists(($var, $arr) 验证变量$var是否是$arr数组里的一个键值</h3>';
echo '<p>只要存在与$var变量相同的键值，那么则返回1 否则返回0</p>';
echo '<p>exp:</p>';
$arr6	= array('bb', 'cc', 'aa', 'hh', 'tt', 'c'=>'cc');
$var6	= 'c';
echo array_key_exists($var6, $arr6);
echo '<hr/><br/>';

echo '<h3>array_search($var, $arr) 搜索$arr数组里是否存在$var的值或元素，存在则返回该元素的键</h3>';
echo '<p>只要存在与$var变量相同的元素，那么则返回1 否则返回0</p>';
echo '<p>exp:</p>';
$arr6	= array('bb', 'cc', 'aa', 'hh', 'tt', 'c'=>'cc');
$var6	= 'bb';
echo array_search($var6, $arr6);
echo '<hr/><br/>';

echo '<h3>array_keys($arr, $value) 返回数组的键名，如果填入$value，则返回与$value对应的键名。将键名以数组形式返回</h3>';
echo '<p>对原数组不会产生影响</p>';
echo '<p>exp:</p>';
$arr7	= array('k1'=>'v1', 'k2'=>'v2', 'v3', 'k4'=>'v4', 'k5'=>'v3');
$value	= 'v3';
echo '<p>返回数组里的键值</p>';
var_dump(array_keys($arr7));
echo '<p>返回与$value对应的键值</p>';
var_dump(array_keys($arr7, $value));

echo '<h3>array_values($arr) 返回数组中所有的元素值，以数字做为新数组的键值</h3>';
echo '<p>对原数组不会产生影响</p>';
echo '<p>exp:</p>';
$arr9	= array('k1'=>'v1', 'k2'=>'v2', 'v3', 'k4'=>'v4', 'k5'=>'v3');
$value	= 'v3';
var_dump(array_values($arr9));
echo '<hr/><br/>';

echo '<h3>array_count_values($arr) 统计$arr里的值。值做为键存在，该值在数组中出现的次数做为值存在。</h3>';
echo '<p>exp:</p>';
$arr8	= array(1, "hello", 1, "world", "hello");
var_dump(array_count_values ($arr8));
echo '<hr/><br/>';

echo '<h3>array_unique($arr) 删除数组里的重复值。键名保留第一个</h3>';
echo '<p>Note:只有当重复的值全等时，才保留碰到的第一个值</p>';
echo '<p>exp:</p>';
$arr10	= array('1', 1, "hello", 1, "world", "hello", '1');
var_dump(array_unique($arr10));
echo '<hr/><br/>';

echo '<h3>array_reverse($arr, [bool false/false]) 将数组元素逆序输出</h3>';
echo '<p>第二个参数默认为false。 如果设置为true，则原值的的键名也将跟着原值走</p>';
echo '<p>exp:</p>';
$arr11	= array('1', 2, 3, 5=>'5', array('b'=>'c', 'd'=>'a'));
echo '<p>默认：</p>';
var_dump(array_reverse($arr11));
echo '<p>第二个参数设置为true：</p>';
var_dump(array_reverse($arr11, true));
echo '<hr/><br/>';

echo '<h3>array_flip($arr) 反转数组的键和值</h3>';
echo '<p>如果$arr存在多个重复的值，则只保留原数组最后一个值的键，其他的都丢失。</p>';
echo '<p>如果值的格式非法，即非int、string类型，那么发出一个警告，并不进行该元素的转换</p>';
echo '<p>exp:</p>';
$arr12	= array('k1'=>'v1', 'k2'=>'v2', 'k3'=>'v3');
var_dump(array_flip($arr12));
echo '<hr/><br/>';
echo '------------------------------------------------数组排序函数------------------------------------------------';
echo '<h3>sort() 对数组按照键值进行排序，按照值从低到高的顺序排列，新排列的会改变数组原有的键值</h3>';
echo '<p>直接改变数组结构</p>';
$arr13	= array('a', 'b', 'c', 'd', 'f', 'e');
sort($arr13);
var_dump($arr13);
echo '<hr/><br/>';

echo '<h3>rsort() 对数组值倒序输出，同样会给排序后的值赋予新的键值，原键值会改变。同sort()一样</h3>';
rsort($arr13);
var_dump($arr13);

echo '<h3>asort() 同sort，按升序排列，只不过不改变键值</h3>';
$arr14	= array('d', 'v', 'c', 'a', 'u'=>'b', 9=>'0');
asort($arr14);
var_dump($arr14);

echo '<h3>arsort() 同asort，按照倒序排序，同样也不改变键值</h3>';
arsort($arr14);
var_dump($arr14);

echo '<h3>natsort() 用自然排序算法进行升序排序 不改变元素的键值</h3>';
echo '<p>区分大小写，小写在后</p>';
$arr15 = $arr16 = array('str4', 'str23', 'str10', 'str1', 'str9');
echo '<p>sort排序后：</p>';
sort($arr15);
var_dump($arr15);
echo '<p>natsort排序后：</p>';
natsort($arr16);
var_dump($arr16);

echo '<h3>natcasesort() 同natsort()一样，该函数不区分大小写</h3>';
echo '<p></p>';
$arr17	= array('sort1', 'SorT0', 'Sort5', 'sort10', 'SORT20');
natcasesort($arr17);
var_dump($arr17);

echo '<h3>ksort() 按照键值对数组升序排列。新数组的键名不变</h3>';
$arr18	= array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
ksort($arr18);
var_dump($arr18);

echo '<h3>krsort() 同ksort()一样，该函数按照倒序排列</h3>';
krsort($arr18);
var_dump($arr18);
echo '------------------------------------------------合并拆分数组------------------------------------------------';
echo '<h3>array_merge($arr1, $arr2, ...) 合并数组。将$arr2里的元素添加到$arr1的后面，如果是数字键值，则对附加添加的元素进行重新排列，非数字键名不变</h3>';
echo '<p>如果有相同键名的元素，则取最后一个元素做为新数组的值</p>';
$arr191	= array("color" => "red", 2, 4);
$arr192	= array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
var_dump(array_merge($arr191, $arr192));

echo '<h3>array_merge_recursive($arr1, $arr2, ...) 同array_merge()一致，区别在于对相同键值的处理</h3>';
echo '<p>该函数如果有相同的键值，则将这些相同键值的元素组成一个数组。array_merge()则是取最后一个元素做为新数组的值</p>';
var_dump(array_merge_recursive($arr191, $arr192));

echo '<h3>array_combine($arrKeys, $arrValues) 将两个数组连接，返回一个新数组，其中$arrKeys做为新数组的键值，$arrValues做为新数组的值。</h3>';
echo '<p>如果两个数组的长度不同或者为空，那么返回FALSE</p>';
$arr20k	= array('id', 'name', 'sex');
$arr20v	= array('2', 'nicaia', '1');
var_dump(array_combine($arr20k, $arr20v));

echo '<h3>array_slice($arr, $offset[, $len]) 返回从$offset到$len键值位置的元素，组成新的数组</h3>';
echo '<p>如果元素的键值是数字键，那么新数组会改变该元素的键值，非数字键的不受影响</p>';
echo '<p>该函数同字符串截取substr()类似</p>';
$arr21	= array('a', 'b', 'c', 'h'=>'d', 'f', 'e');
var_dump(array_slice($arr21, 2, 3));

echo '<h3>array_splice(&$arr, $offset[, $len, $replacement]) 同array_slice()相同，处理相反</h3>';
echo '<p>array_splice()将位于$offset到$len之间的元素给移除掉，同时改变原数组的结构，而array_slice则是返回这些元素，不改变原数组</p>';
echo '<p>如果提供了$replacement，则用$replacement数组替换掉被移除的部分</p>';
echo '<p>同字符串替换函数substr_replace()有点类似</p>';
array_splice($arr21, 2);
var_dump($arr21);

echo '<h3>array_intersect($arr1, $arr2, ...) 将多个数组当中相同的元素找出来，组成新的数组。同时新数组的键值保留第一个</h3>';
$arr221	= array('green', 'red', 'co'=>'yellow', 'blue');
$arr222	= array('co'=>'red', 'green', 'yellow');
var_dump(array_intersect($arr221, $arr222));

echo '<h3>array_intersect_assoc(array1, array2)</h3>';
echo '<p>该函数同array_intersect()相同。区别在于该函数同时对每个元素的键值也做判断，只有键值和元素都相等的才会被找到。</p>';
$arr222	= array('co'=>'yellow', 'green', 1=>'red');
var_dump(array_intersect_assoc($arr221, $arr222));

echo '<h3>array_diff($arr1, $arr2, ...) 求各个数组的差集 即第一个数组里的元素不存在于后续数组里的元素。键名保留不变</h3>';
$arr231	= array('type'=>'XC', 'cj'=>'kona', 'bs'=>'shimanuo', 'deroe');
$arr232	= array('type'=>'XC', 'M9', 'intense', 'deroe', 'shimanuo');
var_dump(array_diff($arr231, $arr232));

echo '<h3>array_diff_assoc($arr1, $arr2, ...) 同array_diff()一样，区别在于该函数加入了对键值的判断</h3>';
var_dump(array_diff_assoc($arr231, $arr232));

echo '<h3>array_rand($arr, [int num req]) 随机返回数组的键名。num默认为1，返回一个字符串。如果大于1，则返回一个数组</h3>';
$arr24	= array('kona'=>'18500', 'intense'=>'26540', 'santacurz'=>'15000', 'contour'=>'4999', 'trek'=>'45000');
var_dump(array_rand($arr24));

echo '<h3>shuffle($arr) 对数组进行随机排序。会删除原有键名，并改变数组内部结构</h3>';
$arr25	= array('sram', 'shimanuo', 'tektro', 'dv'=>'contour', 'gopro', 'qc'=>'rockshox');
shuffle($arr25);
var_dump($arr25);

echo '<h3>array_sum() 对数组元素求和。该函数只会统计数组里的int和float数据，对于其他类型的数据则不做处理。</h3>';
echo '<p>如果是多维数组，那么该函数也只会对数组第一维度进行求和计算</p>';
$arr26	= array('acear'=>'1000', 'deroe'=>'3000', 'X9'=>'4000', 'SLR'=>'6500', 'biansu', array('kona'=>'23450', 'duke'=>1999));
var_dump(array_sum($arr26));

echo '------------------------------------------------常用字符串处理------------------------------------------------';
echo '<h3>strcmp($str1, $str2) 以二进制方式比较两个字符串。如果$str1小于$str2，那么返回-1，大于返回1。等于返回0</h3>';
echo '<p>Note:该函数区分大小写。</p>';
echo '<p>exp:</p>';
$str1	= 'strcmp1';
$str2	= 'Strcmp1';
echo strcmp($str1, $str2);
echo '<hr/><br/>';

echo '<h3>strcasecmp($str1, $str2) 字符串比较。同strcmp，但是不区分大小写</h3>';
$str21	= 'santacurz';
$str22	= 'Intense';
echo strcasecmp($str21, $str22);
echo '<hr/><br/>';

echo '<h3>strspn($string, $searcStr, [$start, $length]) 查找$string中全部存在于$searcStr字符串中的连续字符。?????</h3>';
echo '<p>$start表$string的起始位置，$length表示$string从$start起始位置开始截取的长度</p>';
$str1	= 'hello world, 47 nuguRoad Beijing. TEL: 010-78453256';
$str2	= 'world';
var_dump(strspn($str1, $str2));

echo '<h3>strtolower($str) 将字符串全部转化为小写</h3>';
echo '<hr/><br/>';
echo '<h3>strtoupper($str) 将字符串全部转化为大写</h3>';
echo '<hr/><br/>';
echo '<h3>ucfirst($str) 将字符串首字符转化为大写</h3>';
echo '<hr/><br/>';
echo '<h3>ucwords($str) 将字符串中每个单词的首字母转换为大写</h3>';
echo '<p>这里单词的定义是紧跟在空白字符（空格符、制表符、换行符、回车符、水平线以及竖线）之后的子字符串</p>';
echo '<hr/><br/>';

echo '<h3>strip_tags($str, [特例]) 去掉字符串中的html、php标记、空字符等，如果输入了‘特例’，那么这部分将不做处理</h3>';
echo '<p></p>';
$str3	= '<b>mountain</b> <font class=nicai>bike</font>';
echo htmlspecialchars(strip_tags($str3, '<font>')),'<br />';

echo '<h3>explode($分隔符, $string) 将一段字符串按照特定的分隔符拆成一个数组</h3>';
$str4	= date('Y-m-d');
var_dump(explode('-', $str4));
echo '<hr/><br/>';

echo '<h3>implode($分隔符, $arr) 把数组按照拆分成一个字符串，每个元素用分隔符隔开</h3>';
$arr27	= array('kona', 'rockshox', 'sram');
echo implode('-', $arr27);
echo '<hr/><br/>';

echo '<h3>strpos($str, $need需要检测的字符串, [$offset]) 检测$need是否存在于$str里边，返回$need第一次出现的位置。没有则返回FALSE</h3>';
echo '<p>$offset决定了从$str的哪个位置开始检测</p>';
$str5	= 'i like mountain bike!';
$need	= 'like';
echo strpos($str5, $need);
echo '<h3>stripos($str, $need需要检测的字符串, [$offset]) 同strpos()一样，区别是该函数不区分大小写</h3>';
echo '<hr/><br/>';

echo '<h3>str_replace($search, $replace, $str) 替换字符串里指定的内容</h3>';
echo '<p>将$str5里边的$search用$replace进行替换</p>';
echo '<p>该函数区分大小写。</p>';
$str5	= 'RockShox, suntour, gopro, sram, cycLife, bike';
$search	= 's';
$replace= '/';
echo str_replace($search, $replace, $str5);
echo '<h3>str_ireplace($search, $replace, $str) 同str_replace()一样，区别是该函数不区分大小写</h3>';
echo '<hr/><br/>';

echo '<h3>strstr($str, $need, [bool true/false]) 查找$need在$str中第一次出现的位置到最后一位的部分 如果第三个参数设置为true，则返回到第一位的部分</h3>';
$str6	= 'kona,fox,manitou,suntour,epicon,duke,atx xtc';
$need	= 'x';
echo strstr($str6, $need);
echo '<h3>stristr($str, $need, [bool true/false]) strstr()一样，区别是该函数不区分大小写</h3>';
echo '<hr/><br/>';

echo '<h3>substr($string, $start, [$length]) 截取$string指定位置开始的$length长的子串</h3>';
echo '<p>如果$start小于0，则从$string的结尾处开始</p>';
$str7	= 'M9,V10,350';
echo substr($str7, 2);
echo '<hr/><br/>';

echo '<h3>substr_count($string, $need, [$offset, $length]) 计算$string里从$offset位置开始$need出现的次数</h3>';
echo '<p>如果$offset小于0，则从$string的结尾处开始</p>';
$str7	= 'M9,V10,350';
echo substr_count($str7, '0');
echo '<hr/><br/>';

echo '<h3>trim($str, [$charlist]) 过滤字符串，只是针对字符串头部和尾部</h3>';
echo '<p>如果$charlist没有指定，那么则过滤空格、换行符、制表符、回车、空字节、垂直制表符</p>';
$str8	= 'yyyy-mm-dd hh-ii-ss ';
echo trim($str8, '');
echo '<h3>ltrim()-过滤字符串左边的字符</h3>';
echo '<h3>rtrim()-过滤字符串右边的字符</h3>';
echo '<hr/><br/>';

echo '<h3>str_pad($str, $length, [$chr, STR_PAD_RIGHT]/STR_PAD_LEFT/STR_PAD_BOTH]) 用指定的字符填充$str到指定的长度</h3>';
echo '<p>默认填充到字符串的末尾，也就是STR_PAD_RIGHT</p>';
$str9	= 'vpp';
$chr	= '0';
echo str_pad($str9, 10, $chr, STR_PAD_BOTH);
echo '<hr/><br/>';

echo '<h3>count_chars($str, [$mode 0-4]) 统计字节值里每个字符一共出现了多少次。返回一个数组</h3>';
echo '<p>默认返回由字节值做为键，次数做为值的数组</p>';
echo '<p>Note:此处是字节值！</p>';
$str10	= 'kjdkadkljfasdjflqueoruwoexcvn,xzncv,m';
var_dump(count_chars($str9, 1));

?>
</body>