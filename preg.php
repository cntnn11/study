<?php
header("content-Type:text/html; charset=utf-8");
echo '<pre>';
/**
*	PHP正则的学习笔记
*/
?>
元字符
		代码	说明
		.		匹配除换行符以外的任意字符
		\d		匹配数字 [表示数字 0-9]
		\D		匹配除数字意外的任意字符 [\d的反义]
		\w		匹配字母或数字或下划线或汉字 [表示数字、字母、下划线、汉字 0-9 a-z A-Z]
		\s		匹配任意的空白符 [表示任意的空白符：空格 ，制表符\t，换行符\n，回车\r，分页\f，垂直制表\v，中文全角空格等]
		\S		匹配所有的非空白字符 [\s的反义]
		\b		匹配单词的开始或结束 [匹配单个单词]
		^		匹配字符串的开始 [用来匹配要查找字符串的开头 所有的字符都用于比较]
		$		匹配字符串的结束 [和\b、^ 类似，区别在于 $ 为结尾处 所有的字符都用于比较]
	正则 模式修正符
		特点：多个模式修正符可以放在一块使用
		m	整个字符串按多行来进行匹配。可以理解为将字符串里符合的内容全部匹配出来
		i	不区分大小写模式的匹配
		x	忽略掉匹配表达式里[正则表达式]的空格
		U	匹配最近的字符串，禁止贪婪匹配
		A	强制从^字符串开始算起，必须配合^使用
		D	只匹配到$符号的位置处 设置了m就没用了
		e	把替换字符串当成一个表达式使用。类似eval()函数
	
	限定字符
		代码	说明
		*		重复零次或多次 [任意次数]
		+		重复一次或多次 [至少会出现一次]
		?		重复零次或一次 [可能会出现一次]
		{n}		重复 n 次
		{n, }	重复 n 次或者更多次 [重复n次以上:包括n次] {TIP:貌似达不到预期}
		{n,m}	重复 n 到 m 次
	
	分歧条件
		|		或 [从左往右检测。如果左边的规则符合，右边的规则将不会去匹配]
	
	分组
		
 
	后向引用：
		 捕获：
			 (exp)	匹配exp字符串，并自动分配组号
			 (?<name>exp)	匹配exp字符串，并分配到组号为name的分组里
			 (?:exp)	不匹配exp字符串，并且也不分配组号
		 零宽断言（字符串分割匹配？）：
			 (?=exp)		匹配以exp结尾的字符，匹配结果不包括exp
			 (?<=exp)	匹配一exp开头的字符，匹配结果同样不包括exp
		 负向零宽断言（可以看做 '[^exp]' 的反义）
			 (?!exp)		某字符串后边不是exp的
			 (?<!exp)	某字符串前边不是exp的 //>
		 注释：(?#comment)	注释，给人看的
	 
	 贪婪与懒惰：
		 贪婪可以理解为尽可能多的匹配重复的字符
		 懒惰可以理解为尽可能少的匹配重复的字符（尽可能少？搞不明白）
			 示例语法：
				 *?、+?、??、{n,m}?、{n,}?
				 
	EXP：
		\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3} 匹配简单IP


<?php
echo '<br><hr><br>';
echo '<h3>原子表 []</h3>';
echo '<p>原子表将[]里的内容依次匹配，不当做整体去匹配，只要一个符合即返回true</p>';
echo '<p>如果原子表里有 ^ ，表示不是！即非</p>';
echo '$str = \'cntnn11.com\';<br/>';
echo '$preg = \'/n2/is\';<br/>';
echo '$preg2 = \'/[n2]/is\';<br/>';
echo 'preg_match($preg, $str) = 0<br/>';
echo 'preg_match($preg2, $str) = 1<br/>';
echo '<br><hr><br>';

echo '<h3>正则 原子组 ()</h3>';
echo '<p>把多个字符串分成一组，我们对多个字符串操作</p>';
echo '<p>匹配出来的内容会放入一个内存，可以后期使用。在正则语句里使用\Num来表示原子组的编号 [如果正则在双引号里，需要对\进行转义]</p>';
$str = "
	<html>
		<body>
			<h1>XX网php视频教程</h1>
			<h2>XX教程</h2>
			<h5>这是h5</h5>
			<p>www.baidu.com</p>
			<p>www.xxx.org</p>
			<p>map.google.com.cn</p>
		</body>
	</html>";
$preg = "/<(h[\d])>(.*?)<\/(\\1)>/";	//
preg_match_all($preg, $str, $arr, PREG_SET_ORDER);
$preg_replace = "<\\1>\\2 -> 替换结果<\\3>";
$str = preg_replace($preg, $preg_replace, $str);
echo $str,'<br/>';
echo '<p>如果在原子组里边加上 ?: 则表示不将该分组的内容进行缓存</p>';
echo '<p>测试内容缓冲 ?: 获取网址，输出各网址的后缀名</p>';
//$preg	= "/(www|map)\.\w+((\.)(com\.cn|com|org))/";	//获取所有匹配到的内容
$preg	= "/(?:www|map)\.\w+((\.)(com\.cn|com|org))/";	//只匹配url后缀
$preg	= "/(?:www|map)\.\w+((?:\.)(?:com\.cn|com|org))/";	//只匹配url的.com.cn/.com/.org...
preg_match_all($preg, $str, $arr);
var_dump($arr[1]);
echo '<p>注释：(?#各种字符) 放在正则块的后边</p>';

echo '<br><hr><br>';
echo '<h3>正则重复匹配</h3>';
echo '<p>exp:给php文件的注释里添加上\'@author cntnn11\'内容</p>';
$file	= file_get_contents('phppreg/134.php');
$preg	= "/(\/\*+)(.*)?(\*\/)/is";	//找出该文件中的注释部分。格式为：/** ... */
//preg_match_all($preg, $file, $arr, PREG_SET_ORDER);
//var_dump($arr);
$replace	= "\\1 \\2 *\t@author cntnn11 \r\n \\3";
$data	= preg_replace($preg, $replace, $file);
file_put_contents("phppreg/134demo.php", $data);

echo '<br/><hr></br>';
echo '<h3>匹配一个email格式</h3>';
echo '<p>email exp:</p>';
$email	= "alkdls email@.qq.com **78ajkdsfh google@gamil.com oi4 msn@live.cn 45u43oi self.cntnn11@cntnnn11.com 45645 company@com.company";
$preg	= "/(\w+)@(\w+)\.(\w+)/is";
preg_match_all($preg, $email, $emailArr);
var_dump($emailArr);

echo '<br/><hr></br>';
echo '<h3>匹配一个整数格式</h3>';
echo '<p>int Num exp:</p>';
$num	= '456 545 87d 54- -48 0 53.0 56';
$preg	= "/-?(\d+)/ism";
preg_match_all($preg, $num, $numArr);
var_dump($numArr);

echo '<br/><hr></br>';
echo '<h3>匹配一个座机号码</h3>';
echo '<p>tel exp:</p>';
$tel	= '010-12345678 | (010)12345678 | 12345678 | 0731-1234567 | (0731)1234567 | 1234567';
$preg	= "/(\([0-9]{3,4}\)|([0-9]{3,4})?|\d{3,4}-)\d{7,8}/ism";
preg_match_all($preg, $tel, $telArr);
var_dump($telArr);

echo '<br><hr><br>';
echo '<h3>正则搜索替换函数 preg_replace()</h3>';
echo '<p>preg_replace($pattern, $replacemenet, $subject, $limit, $count) [该函数与str_replace很相似，返回替换后的字符串]</p>';
echo '<p>$pattern:在$subject中被搜索的对象 [传入一个正则表达式，此处可以传入一个数组，包含多个表达式]</p>';
echo '<p>$replacemenet:用来替换匹配$pattern的内容 [传入一个正则表达式]</p>';
echo '<p>$subject:要操作的字符串</p>';
echo '<p>$limit:每个模式替换的次数 [默认-1，无限次替换]</p>';
echo '<p>$count:返回每替换一次就进行记录的变量 </p>';
echo '';
$str	= "我是一段字符串，字符串啊字符串！1234.。。。、5678！go go 够 足球go";
$pattern	= "/[\d*]/";
$replace	= "*";
echo preg_replace($pattern, '*', $str, 5),'<br />';

echo '<h3>prge_replace_callback()</h3>';
echo '<p>在获取到匹配后的字符串后，再去调用一个回调函数进行处理<p>';


echo '<br><hr><br>';
echo '<h3>正则搜索替换函数 preg_filter()</h3>';
echo '<p>preg_filter($pattern, $replacemenet, $subject, $limit, $count)</p>';
echo '<p>如果$subject是一个数组，那么匹配到则返回数组，否则空数组array()</p>';
echo '<p>其他情况则返回字符串，没匹配到则返回NULL</p>';
echo '<p>他会将匹配的元素返回来。没有匹配的元素则不返回</p>';
echo '<p></p>';
echo '';

$pattern = array('/\d/', '/[a-z]/', '/[1a]/');
$replace = array('t:$0', 'B:$0', 'C:$0');
$subject = array('1', 'a', '2', 'b', '3', 'A', 'B', '4');

echo "preg_filter returns\n";
print_r(preg_filter($pattern, $replace, $subject));
/*Array
(
	  [0] => A:C:1
	  [1] => B:C:a
	  [2] => A:2
	  [3] => B:b
	  [4] => A:3
	  [7] => A:4
)*/


echo '<br><hr><br>';
echo '<h3>返回匹配模式的数组条目 preg_grep()</h3>';
echo '<p>preg_grep($pattern, $inArray)</p>';
echo '<p>返回$inArray中匹配$pattern的元素</p>';
echo '<p>他的匹配与数组键名无关，只会与元素的值去匹配</p>';
$inArray	= array(0=>'nicaia123', 1=>'nicai', 'a'=>345, 'd'=>'中文', 4=>'-');
$pattern	= '/\d/';
$inArray	= preg_grep($pattern, $inArray);
var_dump($inArray);


echo '<br><hr><br>';
echo '<h3>返回匹配模式的数组条目 preg_match()</h3>';
echo '<p>preg_match($pattern, $inArray[, $arr, $offset])</p>';
echo '<p>返回$inArray中匹配$pattern的元素</p>';
echo '<p>他的匹配与数组键名无关，只会与元素的值去匹配</p>';
echo '<p>第三个参数$arr可以当做一个返回值，如果设置了那么将返回一个数组</p>';
echo '<p>主要用于判断正则是否成功匹配字符串。类似于stripos()函数</p>';
$inArray	= array(0=>'nicaia123', 1=>'nicai', 'a'=>345, 'd'=>'中文', 4=>'-');
$pattern	= '/\d/';
$inArray	= preg_grep($pattern, $inArray);
var_dump($inArray);

echo '<br><hr><br>';
echo '<h3>执行一个全局正则表达式匹配 preg_match_all()</h3>';
echo '<p>与preg_match()类似，区别在于该函数将返回所有匹配到的内容，而preg_match()只返回一次匹配到的内容</p>';


echo '<br><hr><br>';
echo '<h3>执行正则分隔字符串 preg_split()</h3>';
echo '<p>该函数将一段字符串按照正则规则进行分割，返回一个数组</p>';
echo '<p>该函数同explode()，str_split()类似。将一串字符串按照一定规则进行分隔成数组</p>';
$str	= "If you need to split a list of 'tags' while allowing for user error, you'll find this more useful than the manual's first example.";
$pattern	= '/n/';
$rs		= preg_split($pattern, $str);
var_dump($rs);


echo '<br><hr><br>';
echo '<h3>练习</h3>';
echo $subject	= "XX论坛bbs.xxg.comXX官网www.xxg.com245';统计第一个;号前的.com出现多少次";
preg_match_all('/(.com)(;)$/', $subject, $arr);
var_dump($arr);

echo '<br><hr><br>';
echo '<p>正则匹配一：</p>';
echo '<p>20110601/640_480/269_1306934785140.jpg<br/>
改为：<br/>
2011/06/01/640_480/269_1306934785140.jpg</p>';
$exam1	= '20110601/640_480/269_1306934785140.jpg';
$pregExam1	= '/((\w+\/)?)+(\w+\.jpg)/ism';
preg_match_all($pregExam1, $exam1, $arr);
var_dump($arr);

?>