<?php
header('Content-Type: text/html; charset=gb2312');
echo mb_strwidth("你");
echo '<br/>';
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
echo strrevs2("这是一段胡总温呢看哈库拉3452看见了好看");