<?php 
header("Content-Type: text/html; charset=utf-8");
?>
<head>
style
{
p{ font-size:16px; font-weight:bold; font-family:'微软雅黑', console; }
}
</head>
<?php
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
 * php字符串处理函数
 */
//---------------------------------------------
//str_getcsv 解析csv字符串为一个数组（和excel有关？）
//str_getcsv('待解析字符串', [字段界定符], [字段包裹字符],[转义字符 = '\'])


echo '<br /><hr><br />';

//str_replace() 字符串查找替换
//str_replace('search 查找的字符','replace 要被替换的字符', 'string 进行查找替换操作的字符串', 'count 替换次数 = int不限制')
//查找$string里边为 search的字符，并用replace替换掉这些内容。如果设置了count，那么将决定可以替换几次
//区分大小写版本：str_ireplace()
//该函数也可用于数组
$string = 'test str_replace function. hello str_replace! hello php!, hello china, chery, benz';
//普通替换
echo str_replace('hello', 'hi', $string),'<br />';
//指定count参数 --感觉不出有啥意义
$count = 1;
echo str_replace('hello', 'hi', $string, $count),'<br />';


echo '<br /><hr><br />';
//str_pad() 使用另一个字符串填充当前字符串以达到指定长度
//str_pad('$input 当前要填充字符串', '$int 整个字符串的长度', '$str 填充进来的字符', '$type 决定是填充到右边STR_PAD_RIGHT/左边STR_PAD_LEFT/两端同时开始STR_PAD_BOTH')
$input = 'str_pad';
//不指定$str
echo str_pad($input, 10),'<br />';
//指定$str
echo str_pad($input, 15, ','),'<br />';
//如果$int小于当前$input的长度，他会出什么情况呢？ => 他不会做任何填充
echo str_pad($input, 7, '2'),'<br />';


echo '<br /><hr><br />';
//str_repeat 将当前字符串重复N次
//str_repeat('$intpu 要重复的字符串', '$int 重复次数*')
//$int必须大于0，否则返回空字符串！
$input = 'str_repeat';
echo str_repeat($input, 1),'<br />';


echo '<br /><hr><br />';
//str_rot13() 对字符串进行rot13转换->可以理解为字符串加密
//str_rot13('$string 要转换的字符串')
//该函数只对字符串中的字母进行转换！如果是特殊字符或数字，将不做处理
//rot13转换：在26个字母中，用当前字母后边第13个字母替换当前字母！所以，解密只要在在执行一次该方法即可
$string = 'str_rot13()';
echo '加密：',str_rot13($string),'<br />';
echo '解密：',str_rot13(str_rot13($string)),'<br />';


echo '<br /><hr><br />';
//str_shuffle() 随机打乱一个字符串
//str_shuffle('$string 要打乱的字符串')
$string = 'str_shuffle()';
echo str_shuffle($string),'<br />';


echo '<br /><hr><br />';
//str_split() 将字符串按照指定长度组成一个数组 返回一个数组
//str_split('$string 待转换的字符串'， [$int 多少个字符组成一个键=1])
$string = 'str_split()';
var_array(str_split($string, 3));


echo '<br /><hr><br />';
//str_word_count() 统计当前字符串里有多少单词？ 可以理解为将一个字符串按照特殊符号、数字进行分割！
//str_word_count('$string', [$int 返回类型], [$charlist 附加的字符串，填上表示该字符串为单词的一部分])
$string = 'str_word_count() word, world, earth, good, google, nihao, bendan, shandiche, nicai';
//默认
echo str_word_count($string),'<br />';
//返回一个数组，$int=1
var_array(str_word_count($string, 1));


echo '<br /><hr><br />';
//strcasecmp() 二进制比较字符串
//strcasecmp($str1, $str2) 将字符串转换为二进制，然后在比较
$str1 = 'str1';
$str2 = 'str2';
echo strcasecmp($str1, $str2);


echo '<br /><hr><br />';
//strstr() 查询字符串首次出现的位置，并从该位置到末尾的字符串
//strstr('$haystack 输入的字符串', '$needle 需要查询的字符串', [true/false = false. ])
//区分大小写版：stristr()
//strstr()同样也是strchr()的别名函数
$string = 'strstr royalstar haers hero';
$needle = 'he';
echo strstr($string, $needle),'<br />';
//第三个参数设置为true，则返回needle在haystack中的位置之前的部分
echo strstr($string, $needle, TRUE),'<br />';


echo '<br /><hr><br />';
//strcmp() 同strcasecmp()函数，该字符串区分大小写！


echo '<br /><hr><br />';
//strcoll() 同strcmp(),但是该函数不是二进制安全的


echo '<br /><hr><br />';
//strcspn() 获取不匹配遮罩的起始子字符串的长度 可以理解为：返回$str2的第一个字符串在$str1中首次出现的位置之前的字符串长度。
//strcspn($str1, $str2, [$start = 0 查找的起始位置], [$length 查找的长度])
$str1	= 'applexiaomi';
$str2	= 'a';
$start	= 4;
echo strcspn($str1, $str2, $start),'<br />';


echo '<br /><hr><br />';
//strftime() 返回一个指定格式的格式化后的字符串
/**
 * 	参数说明
 * 	%a - 当前区域星期几的简写 
	■%A - 当前区域星期几的全称 
	■%b - 当前区域月份的简写 
	■%B - 当前区域月份的全称 
	■%c - 当前区域首选的日期时间表达 
	■%C - 世纪值（年份除以 100 后取整，范围从 00 到 99） 
	■%d - 月份中的第几天，十进制数字（范围从 01 到 31） 
	■%D - 和 %m/%d/%y 一样 
	■%e - 月份中的第几天，十进制数字，一位的数字前会加上一个空格（范围从 ' 1' 到 '31'） 
	■%g - 和 %G 一样，但是没有世纪 
	■%G - 4 位数的年份，符合 ISO 星期数（参见 %V）。和 %V 的格式和值一样，只除了如果 ISO 星期数属于前一年或者后一年，则使用那一年。 
	■%h - 和 %b 一样 
	■%H - 24 小时制的十进制小时数（范围从 00 到 23） 
	■%I - 12 小时制的十进制小时数（范围从 00 到 12） 
	■%j - 年份中的第几天，十进制数（范围从 001 到 366） 
	■%m - 十进制月份（范围从 01 到 12） 
	■%M - 十进制分钟数 
	■%n - 换行符 
	■%p - 根据给定的时间值为 `am' 或 `pm'，或者当前区域设置中的相应字符串 
	■%r - 用 a.m. 和 p.m. 符号的时间 
	■%R - 24 小时符号的时间 
	■%S - 十进制秒数 
	■%t - 制表符 
	■%T - 当前时间，和 %H:%M:%S 一样 
	■%u - 星期几的十进制数表达 [1,7]，1 表示星期一 
 */
echo strftime('%H'),'<br />';


echo '<br /><hr><br />';
//strip_tags() 尝试去掉字符串中所有的html、php标签和空字符串。
//strip_tags('$string 待操作的字符串', [allowable_tags 指定不被去除的字符])
$string = "<p id='trans-input-head'><span>请输入要翻译的文字内容或者网页地址</span><a id=empty-input-btn href='###'>清空</a></p><div id='trans-input-container'><div id=hightlight-mask></div><textarea id=user-input class='user-input' spellcheck=false></textarea>";
echo strip_tags($string),'<br />';
//echo '设置第二个参数：',strip_tags($string, 'span'),'<br />'; 不明白怎么搞


//------------------------------需细看---------------------------------
echo '<br /><hr><br />';
//stripcslashes() 返回转以后的字符串 去除带哦那些转义字符
//stripcslashes('$string')
$string = "<span>请输入要翻译的文字内容或者网页地址</span>href='###'清空='user-input'  <ea>";
echo stripcslashes($string),'<br />';


echo '<br /><hr><br />';
//addcslashes() 
//------------------------------需细看---------------------------------


echo '<br /><hr><br />';
//strpos() 查找字符串首次出现的位置
//strpos('$string', '$needle 要在$string中查找的字符串', [$int 指定从$int里哪一个位置开始查找])
//stripos()函数 区分大小写！
$string	= 'strpos()';
$needle	= 'p';
//普通查询  如果$needle在$string的第一个字母出现则返回0。需用 ===全等 来判断
echo strpos($string, $needle),'<br />';


echo '<br /><hr><br />';
//stripslashes 反引用一个引用字符串 将字符串里边的转义字符'\'给去掉吗？难道只是去掉 '\'？？？
//stripslashes('$string')
$string	= "Is your name O\'re\illy?";
echo stripslashes($string),'<br />';


echo '<br /><hr><br />';
//strlen() 计算字符串的长度
//strlen($string)
$string = 'strlen()';
echo strlen($string),'<br />';


echo '<br /><hr><br />';
//strnatcasecmp() 使用‘自然顺序算法’比较字符串
//strnatcasecmp($str1, $str2)
//strnatcmp($str1, $str2) 该函数区分大小写
echo strnatcasecmp($str1, $str2),'<br />';


echo '<br /><hr><br />';
//strncasecmp() 二进制安全比较字符串开头的N个字符（不区分大小写）
//strncasecmp($str1, $str2, [$int])
echo strncasecmp($str1, $str2, 2),'<br />';


echo '<br /><hr><br />';
//strpbrk() 在$string字符串中匹配$char,如果$char中有一个字符串匹配到$string,那么则返回当前位置后的字符串
//strpbrk('$string', '$char 要匹配的字符')
$string	= 'strpbrk()';
$char	= 'rt';
echo strpbrk($string, $char),'<br />';



echo '<br /><hr><br />';
//strptime() 返回一个将date解析后的数组
//strptime() 


echo '<br /><hr><br />';
//strrev() 将字符串倒转输出
//strrev($string)
$string	= 'strrev()';
echo strrev($string),'<br />';


echo '<br /><hr><br />';
//strripos() 查找某字符在指定字符串里最后一次出现的位置 同strpos()相反
//strripos('$string 当前字符串', '$needle 要查找的字符串', [$int $offset])
$string	= 'strripos';
echo strripos($string, 'i'),'<br />';


echo '<br /><hr><br />';
echo '<h3>转义字符 addslashes()</h3>';
echo '<p>对指定的字符串进行转义，给字符串添加斜线‘\’。主要用于生成sql语句时。</p>';
echo '<p>如果magic_quotes_sybase在php.ini中设置成on，那么所有的 GET、POST 和 COOKIE语句将被自动转义，就不需要使用该函数了。遇到这种情况时可以使用函数 get_magic_quotes_gpc()进行检测</p>';
//tip：如果开启了
$str	= "<p class='post_item_summary'><a href='http://www.cnblogs.com/esion/' target='_blank'><img align='left' class='pfs' src='http://pic.cnblogs.com/face/u430668.jpg?id=25090927' alt=''></a>在PHPCms内容页中，出于安全考虑，默认是禁止JavaScript脚本的，所以我们在添加文章时，虽然加入了js代码，但实际上并没有起作用，而是以文本形式显示。如果要让内容页支持JavaScript，则要做以下修改： 在文件..\caches\caches_model\caches_data\con</p>";
echo '原始语句：',htmlspecialchars($str),'<br />';
echo '转义语句：',htmlspecialchars(addslashes($str));

echo '<br /><hr><br />';
echo '<h3>还原字符 stripslashes()</h3>';
echo '<p>用于经过addslashes()转义后的字符串。将‘\’给删掉</p>';
echo 'stripslashes()还原后的字符串：',htmlspecialchars(stripslashes(addslashes($str)));


echo '<br /><hr><br />';
echo '<h3>字符串截取 substr(str, strart, end)</h3>';
echo '<p>对一段字符串进行截取。
		<br>1.中文由于占两个字符，所以该函数在中文环境下使用时会截成乱码！<br>
</p>';
$str	= "在PHPCms内容页中，出于安全考虑，默认是禁止JavaScript脚本的，所以我们在添加文章时，虽然加入了js代码，但实际上并没有起作用，而是以文本形式显示。如果要让内容页支持JavaScript，则要做以下修改： 在文件..\caches\caches_model\caches_data\con...";
echo "substr截取字符串：",substr($str, 0, 51),'...<br />';
echo chr(27),'<br />';

echo '<br /><hr><br />';
echo '<h3>html转换函数  htmlentities()</h3>';
echo '<p>讲一段字符串中的所有 [本来就没有htmlspecialchars好使]</p>';
$str	= '<td class="f"><h3 class="t"><a onmousedown="return c({    "fm":"as",    "F":"778317EA",    "F1":"9D73F1E4",    "F2":"4CA6DE6B",    "F3":"54E5243F",    "T":"1343224672",    "title":this.innerHTML,        "url":this.href,        "p1":3,    "y":"EF7CCFF7"        })" href="http://www.cnblogs.com/qiantuwuliang/archive/2009/07/16/1525139.html" target="_blank">整理一下收集的<em>PHP字符串截取函数</em> - 钱途无梁 - 博客园</a></h3> <font size="-1">  不管是uft-8编码转换为gb2312,还是将 gb2312 转换为 uft-8 ,都是一样道理,<em>php</em>4.3.1以后的iconv<em>函数</em>很好用的，只是需要自己写一个uft8到unicode的转换<em>函数</em>查...<br> <span class="g">  www.cnblogs.com/qiantuwuliang/archive/200 ... 2012-7-22  </span> - <a href="http://cache.baidu.com/c?m=9f65cb4a8c8507ed4fece763105392230e54f73260878e482a958448e435061e5a25b8e87b645741949b27345dfa540faaa16c2973543db799ca8357dfbe8f2b2b952433701b854019c419d891007a9f34d507a9f916a5e0b22592dec5a5da4325ce44757f9784fb4d0164dd1ff6034294b19838022f66ad9b3a728e53605a9c3441c6508993251d739687ae4b38b5&amp;p=8b2a9359caaf0eff57ed913e157a&amp;user=baidu&amp;fm=sc&amp;query=php%D7%D6%B7%FB%B4%AE%BD%D8%C8%A1%BA%AF%CA%FD&amp;qid=bff150e30ba03f8f&amp;p1=3" target="_blank" class="m"> 百度快照</a><span class="liketip" id="like_3083181530076642001"></span><br> </font></td>';
echo 'html转换后的内容：',htmlspecialchars($str),'<br />';


echo '<br /><hr><br />';
echo '<h3>',htmlspecialchars('动态xml输出 $str=<<<mark \'xxxx内容啊\' mark;'),'</h3>';
echo '<p>没有实际用过，不明白</p>';


echo '<br /><hr><br />';
echo '<h3>返回ASCII码值 ord()</h3>';
echo '<p>只返回第一个字符的ascii码值</p>';
echo '<p>十六进制表示区间：01-7f表示[0-9][aA-zZ][特殊字符]区间 ，各占一个字节</p>';
echo '<p>utf8字符是3个字节 GBK是2个字节数</p>';
echo ord('你猜'),'<br />';

echo '<br /><hr><br />';
echo '<h3>截取字符串 mb_substr(str, start=0, end=0, codetype)</h3>';
echo '<p>php扩展函数，使用时需要服务器开启php_mbstring.dll扩展才行</p>';
echo '<p>该函数按照字来分</p>';
echo '使用mb_substr截取字符串：',mb_substr(htmlspecialchars($str), 0, 80, 'utf8'),'<br />';





?>