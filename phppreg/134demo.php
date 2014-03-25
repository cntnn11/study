<?php
header("content-type: text/xhtml; charset=utf-8");
echo "<pre>\r\n";
/** 
 *	正则 模式修正符
 *	特点：多个模式修正符可以放在一块使用
 *		m	整个字符串按多行来进行匹配。可以理解为将字符串里符合的内容全部匹配出来
 *		i	不区分大小写模式的匹配
 *		x	忽略掉匹配表达式里[正则表达式]的空格
 *		U	匹配最近的字符串，禁止贪婪匹配
 *		A	强制从^字符串开始算起，必须配合^使用
 *		D	只匹配到$符号的位置处 设置了m就没用了
 *		e	把替换字符串当成一个表达式使用。类似eval()函数
 *	@author cntnn11 
 */

//m
echo 'm 模式'."\r\n";
echo '把整个字符串按多行来进行匹配'."\r\n";
$str	= "<a href='http:\\www.baidu.com'>baidu</a>\n<a href='http:\\sina.com.cn'>sina</a>";
$preg	= "/<a.*a>/m";
preg_match_all($preg, $str, $arr1, PREG_SET_ORDER);
var_dump($arr1);

//i
echo "\r\n".'i 模式'."\r\n";
echo '忽略字符串里的大小写'."\r\n";
$str	= "<DIV id='d1'>d1</DIV><div id='d2'>d2</div>";
$preg	= "/<div .*>(.*)<\/div>/i";
preg_match_all($preg, $str, $arr2, PREG_SET_ORDER);
var_dump($arr2);

//x
echo "\r\n".'x 模式'."\r\n";
echo '忽略掉正则表达式中的空格'."\r\n";
$str 	= 'http://www.houdunwang.com';
$preg	= '/houdun w ang.com/i';
preg_match($preg, $str, $arr3);
var_dump($arr3);

//U
echo "\r\n".'U 模式'."\r\n";
echo '禁止贪婪模式。如果字符串里有多个符合条件的内容，那么就列出多个被匹配到的内容。否则把所有匹配到的内容做为一个整体输出',"\r\n";
$str	= "<h3>h3标题1</h3><h3>标题2</h3>";
$preg	= '/<h3>(.*)<\/h3>/Ui';
preg_match_all($preg, $str, $arr4);
var_dump($arr4);

//A
echo "\r\n".'A 模式'."\r\n";
echo '匹配从^开始的内容';
$str	= "<h3>kona</h3><h3>santcurz</h3>";
$preg	= "/<h3>(.*)<\/h3>/Um";
preg_match_all($preg, $str, $arr5);
var_dump($arr5[1]);

//D
echo "\r\n".'D 模式'."\r\n";
echo '只匹配到$符号结束的位置 设置了m就没用'."\r\n";
$str	= 'houdun.com\nbaidu.com\n';
$preg	= '/.com$/D';
preg_match_all($preg, $str, $arr6);
var_dump($arr6);



?>