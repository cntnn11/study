<?php
header('Content-Type: text/html; charset=gb2312');
echo mb_strwidth("��");
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
echo strrevs2("����һ�κ������ؿ�������3452�����˺ÿ�");