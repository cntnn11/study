<?php
/**
 *	@DESC 在图片上放些文字
 *	@author cntnn11
 *	@date 2013-07-25
*/
header("content-type: text/html; charset=utf-8");
function strsub($string, $start=0, $offest=0, $suff='', $charset='utf8')
{
	$count	= strlen($string);
	$max	= (int)$start+$offest;
	$re_str	= '';
	$byte	= 0;	//按字节数累计
	$char	= 0;	//按字符数累计
	$size	= 1;	//记录每次substr时的终止位置，汉字需要考虑gbk和utf8两种情况
	while ($byte < $count)
	{
		//英文及半角特殊字符，使用en编码，就是以1个字节为单位
		if(ord($string[$byte]) >=0 && ord($string[$byte]) <=126)
		{
			$char_temp	= 'en';	
		}
		else
		{
			$char_temp	= $charset;
		}
		
		switch (strtolower($char_temp))
		{
			case 'gb2312':
			case 'gbk':
				$byte	+= 1;
				$size	= 2;
				break;
			case 'utf8':
				$byte	+= 2;
				$size	= 3;
				break;
			case 'en':
			default:
				 $size	= 1;
				break;
		}

		if($char < (int)$max && $char >= $start)
		{
			$tstart	= (int)($byte-$size+1);
			$re_str	.= substr($string, $tstart, $size);
			$str	= substr($string, $tstart, $size);

			$char++;
			$byte++;
		}
		else
		{
			return $re_str.$suff;
		}
	}
	return $re_str;
}

//$_SERVER['REQUEST_URI']	= "/597398742/infocenter";
//$_SERVER['HTTP_HOST']	= 'http://user.qzone.qq.com';
error_reporting(0);
$uri		= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//获取qq号，直接从链接中获取即可
$uri_arr	= explode('/', $_SERVER['REQUEST_URI']);
$qq			= $uri_arr[1];

//获取昵称，空间介绍一些信息
//这里不需要什么接口开发，用file_get_contents()打开该链接，里边已经有我们想要的东西了
$qzone	= file_get_contents($uri);
preg_match_all('/ownerProfileSummary=\[\"([^\]]*)\"\]/', $qzone, $matches, PREG_SET_ORDER);
if(!empty($matches))
{
	$info_arr	= explode(',', $matches[0][1]);
	$qzone_nick	= strsub("昵称：".trim($info_arr[0], '"'), 0, 23);
	$qzone_name	= strsub("空间名称：".trim($info_arr[4], '"'), 0, 23, '……');
	$qzone_intr	= strsub("空间简介：".trim($info_arr[5], '"'), 0, 23, '……');
}
else
{
	$qzone_nick	= "唉，居然没有抓到你的信息，真没意思！";
	$qzone_name	= is_numeric($qq) ? "但我抓到你的qq号了，嘿嘿~" : '';
}/*
$qzone_nick	= $_SERVER['REQUEST_URI'];
$qzone_name	= $_SERVER['HTTP_HOST'];*/
//生成图片了，就以纯白色为背景，制作
$width			= 400;
$height			= 150;
$timg			= imagecreate($width, $height);
$bgcolor		= imagecolorallocate($timg, 102, 153, 102);
$stringcolor	= imagecolorallocate($timg, 255, 255, 255);

$url	= "http://www.cntnn11.com/";
//$url	= "http://test.study.com/images/";
$file_img	= "qq.jpg";


$font		= '../font/YaHei.Consolas.1.12.ttf';
imagettftext($timg, 12, 0, 10, 25, $stringcolor, $font, (is_numeric($qq) ? "Q Q：".$qq : 'Nothing!'));
imagettftext($timg, 12, 0, 10, 60, $stringcolor, $font, $qzone_nick);
if($qzone_name)
{
	imagettftext($timg, 12, 0, 10, 95, $stringcolor, $font, $qzone_name);
}
if($qzone_intr)
{
	imagettftext($timg, 12, 0, 10, 130, $stringcolor, $font, $qzone_intr);
}

//header("content-type: image/jpeg;");

if(is_file($file_img))
{
	unlink($file_img);
}
imagejpeg($timg, $file_img, 50);
imagedestroy($timg);

//header("Location: ".$url.'catch/'.$file_img);


