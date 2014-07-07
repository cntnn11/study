<?php
/**
 *	@DESC 在图片上放些文字
 *	@author cntnn11
 *	@date 2013-07-25
*/

$_SERVER['REQUEST_URI']	= "http://user.qzone.qq.com/597398742/infocenter";
$uri	= $_SERVER['REQUEST_URI']	= "http://user.qzone.qq.com/597398742/infocenter";
$qzone	= file_get_contents($uri);
preg_match_all('/ownerProfileSummary=\[\"([^\]]*)\"\]/', $qzone, $matches, PREG_SET_ORDER);
echo '<pre>';
if(!empty($matches))
{
	$info_arr		= explode(',', $matches[0][1]);
}
var_dump($info_arr);
/*$uri_arr	= explode('/', $uri);
echo '<pre>';*/
/*$qq	= (int)$uri_arr[1];
if($qq)
{
	$text['qq']		= "QQ：".$qq;
	$text['name']	= "昵称：";
}
else
{
	$text['no']	= 'IS NOTHING!';
}*/


