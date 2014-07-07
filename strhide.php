<?php
/**
 *	@DESC 字符串插入*号取代
 *			工作中，我们会列出中奖用户、会员动态之类的列表输出，这时候需要保护用户的隐私，如是对文字进行隐藏处理，即 “username” => "us****me"。
 *	@DATE 2014-03-27
*/
$string	= 'nickname';

$model	= '';
$config['len_before']	= 1;
$config['len_tail']		= 1;
$config['replace']		= '*';
$config['replace_num']	= 6;

$result1	= simpleHide($string, $config);
var_dump($result1);

// 1. 简单的保留首尾，中间全部用 * 代替
function simpleHide($string, $config = array())
{
	$len_before	= $config['len_before'] ? (int)$config['len_before'] : 1;
	$len_tail	= $config['len_tail'] ? (int)$config['len_tail'] : 1;
	$replace	= $config['replace'] ? $config['replace'] : '*';
	$replace_num= $config['replace_num'] ? $config['replace_num'] : 6;

	$str_repeat	= str_repeat($replace, (int)$replace_num);
	if(mb_strlen($string) <= 1)
	{
		return $string.$str_repeat;
	}

	$str_before	= mb_substr($string, 0, (int)$len_before, 'UTF-8');
	$string_rev	= strrevs($string);
	$str_tail	= mb_substr($string_rev, 0, (int)$len_tail, 'UTF-8');
	$result	= $str_before.$str_repeat.$str_tail;
	return $result;
}
exit();
/**
 *	@DESC 反转字符串，主要是考虑处理中文
 *	@DATE 2014-03-26
 *	@author cntnn11
*/
function strrevs($str, $charset = 'utf-8')
{
	$strlen	= mb_strlen($str, $charset);
echo '长度 -> '.$strlen.'<br/>';
	$rev_arr	= array();
	if($strlen > 1)
	{
		for ($i=0; $i < $strlen; $i++)
		{
			$temp	= mb_substr($str, $i, 1, $charset);
			array_unshift($rev_arr, $temp);
		}
		return join('', $rev_arr);
	}
	else
	{
		return $strlen;
	}
}
echo '<pre>';
$string	= '这一段46546中文';
echo $string.'<br/>';
echo strrevs($string).'<br/>';
echo strrevs2($string).'<br/>';;

function strrevs2($str)
{
	preg_match_all('/./u', $str, $matches);
	if($matches[0])
	{
		$matches[0]	= array_reverse($matches[0]);
		return join('', $matches[0]);
	}
	return $str;
}