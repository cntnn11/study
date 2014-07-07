<?php
header("content-type:text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
function echoHtml($title, $info = '', $content = array(), $tip = '')
{
	$html	= '';
	$html	.= '<h3>'.$title.'</h3>';
	if($info)
	{
		$html	.= "<p>{$info}</p>";
	}
	if(is_array($content) && !empty($content))
	{
		foreach ($content as $key => $row)
		{
			$i	= $key+1;
			$html	.= "<p>\t{$i}：\t{$row}</p>";
		}
	}
	if($tip)
	{
		$html	.= "<p><b>\tTIP：{$tip}</b></p>";
	}
	$html	.= "<hr/><br/>";
	echo $html;
}
/**
 *	生成缩略图
 *	@param $src_img 操作图片文件名
 *	@param $new_img 新的图片文件名
 *	@param $n_w 宽度
 *	@param $n_h 高度
 *	@return resouce 
 *	@author cntnn11
 *	@date 2013-03-10
*/
function thumb($src_img, $new_img, $n_w = 0, $n_h = 0)
{
	if(is_file($src_img))
	{
		list($s_w, $w_h, $s_t)	= getimagesize($src_img);

		//对心图片的宽高进行等比缩放限制，使用固定的公式
		//缩放以原始图片最大的边做为新图片最大的尺寸，另一边则根据以下公式进行等比缩放
		//如果原图的宽度小于高度，那么重新计算新图的宽度，否则重新计算新图的高度
		if($n_w && ($s_w < $s_h))
		{
			$n_w	= ($n_h / $s_h) * $s_h;
		}
		else
		{
			$n_h	= ($n_w / $s_w) * $s_w;
		}

		//开始生成
		$res_img_new	= imagecreatetruecolor($n_w, $n_h);
		switch($s_t)
		{
			case 1:
				$res_img	= imagecreatefromgif($src_img);
				$ext		= 'gif';
				break;
			case 2:
				$res_img	= imagecreatefromjpeg($src_img);
				$ext		= 'jpg';
				break;
			case 3:
				$res_img	= imagecreatefrompng($src_img);
				$ext		= 'png';
				break;
			default:
				echo  '不支持的图片类型';
				return false;
				break;
		}

		imagecopyresampled($res_img_new, $res_img, 0, 0, 0, 0, $n_w, $n_h, $s_w, $s_h);
		//$res_img_new	= imagecreate($n_w, $n_h);
		//imagecopyresized($res_img_new, $res_img, 0, 0, 0, 0, $n_w, $n_h, $s_w, $s_h);
		global $img_new_dir;
		$new_img_file	= $img_new_dir.$new_img.'.'.$ext;
		imagejpeg($res_img_new, $new_img_file);
		//genImage($res_img_new, $new_img_file, $s_t);
		imagedestroy($res_img);
		imagedestroy($res_img_new);
		echo '缩放后的图片：';
		echo '<img src="'.$new_img_file.'" alt="生成的缩略图" ><hr/><br/>';
	}
}
/**
 *	接收传入参数生成一张图片
 *	@param $img_res 处理好的图片资源
 *	@param $img_file 新的图片地址
 *	@param $img_type 图片类型
 *	@return resouce 
 *	@author cntnn11
 *	@date 2013-03-10
*/
function genImage($img_res, $img_file, $img_type = 2)
{
	switch($img_type)
	{
		case 1:
			return imagegif($img_res, $img_file);
			break;
		case 2:
			return imagejpeg($img_res, $img_file);
			break;
		case 3:
			return imagepng($img_res, $img_file);
			break;
		default:
			return '不支持的图片类型';
			break;
	}
}

/*==============================================================================================================================*/
global $img_name,$img_new_dir;
$img_name	= 'testimg.jpg';
$img_new_dir	= 'genimages/';

echo "<p>原始测试图片：‘{$img_name}’</p>";
echo '<img src="'.$img_name.'" alt="测试图片" width="200px" >';


//获取图片资源，在此使用jpg格式做测试图片
$img_sour	= imagecreatefromjpeg('testimg.jpg');

//图片宽高的获取
$title	= "图片宽高度获取";
$info	= "涉及使用函数imagesx(img source) imagesy(img source)";
$content= array(
	'imagesx(image)：传入一个通过imagecreate_()函数创建的图片资源类型做为参数，返回宽度',
	'imagesy(image)：同imagesx，返回高度！',
	'测试图片的原始宽度：'.imagesx($img_sour).'px 原始高度：'.imagesy($img_sour).'px',
);
$tip	= "这两个函数的参数必须是图片资源类型！！";
echoHtml($title, $info, $content, $tip);

//另一种获取图片属性的方法
$title	= "使用getimagesize(图片名);获取图片的属性";
$info	= "该函数返回一个数组，包含了宽度、高度、图片类型信息！只需接收一个文件名即可获取！";
$content= array(
	'使用方式：getimagesize('.$img_name.')',
	'返回一个数组：下标0表示宽度，下标1表示高度，下标2表示图片类型',
	'&nbsp;&nbsp;&nbsp;&nbsp;图片类型说明：1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM',
	'下标从3开始的则为文本类型，可以说是对0、1、2三个下标值的说明',
);
echoHtml($title, $info, $content, $tip);

//图片缩放函数
$title	= "图片缩放，使用效果更好的imagecopyresampled()函数";
$info	= "主要学习等比缩放，因为不对宽高进行约束，那么新生成的图片会变形";
$content= array(
	'imagecopyresampled(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)',
	'参数说明：',
	'&nbsp;&nbsp; dst_image【新图片】 图片资源类型',
	'&nbsp;&nbsp; src_image【要缩略的原始图片】 图片资源类型',
	'&nbsp;&nbsp; dst_x,dst_y,dst_w,dst_h【缩略图片的X轴起点，y轴起点，宽度和高度】 数值类型',
	'&nbsp;&nbsp; src_x,src_y,src_w,src_h【原始图片的X轴起点，y轴起点，宽度和高度】 数值类型',
);
$tip	= "还有一个imagecopyresized()的函数，参数同imagecopyresampled()函数一致，但效果没有他好，不知道为什么？";
echoHtml($title, $info, $content, $tip);

//测试缩略方法
$title	= '写一个thumb()方法，用来等比缩略一张图片';
$info	= '使用imagecopyresampled()函数来使用';
$content= array(
	'首先确定参数：原始图片，缩略图片目标位置，缩略图片的宽度和高度',
	'获取图片的属性，宽高、类型，以创建相应的图片资源',
	'使用固定公式算出新图片等比缩放的宽高',
	'根据图片类型生成新的缩略图片',
	'释放图片资源',
);
$tip	= "生成了黑色的图片，需要解决！！！！！！！！！！！";
echoHtml($titl, $info, $content, $tip);
thumb($img_name, 'suolve1', 500, 500);

//图片透明
/*imagecolortransparent()
imagecolorstotal()
imagecolorsforindex()
imagecolorallocate()
imagefill()*/

imagedestroy($img_sour);