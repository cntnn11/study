<?php
/*
 *   上节课介绍了图像处理，主要是画出各种图形
 *
 *   本节课是图片处理： 缩放，裁剪， 翻转，旋转、透明、锐化等图片操作
 *
 *    一、创建图片资源
 *    	  imagecreatetruecolor(width, height)
 *    	  gif jpg png
 *
 *	  imagecreatefromgif(图片名称);
 *	  imagecreatefrompng(图片名称);
 *	  imagecreatefromjpeg(图片名称);
 *
 *        
 *        图出各种图形（圆形，矩形， 线段， 文字）
 *
 *        imagegif(,图片位置);
 *        imagepng(,);
 *        imagejpeg(,);
 *
 *        imagedestroy(图片资源) 
 *   二、获取图片的属性
 *
 *   	 imagesx(res)
 *   	 imagesy(res)
 *
 *   	 getimagesize(图片名称);  //返回数组， 0==width 1==height 2==type
 *
 *   三、透明处理
 *   	
 *   	 png jpeg透明色都正常， 只有gif不正常
 *
 *   	 imagecolortransparent();
 *   	 imagecolorstotal();
 *   	 imagecolorsforindex();
 *		
 */

function thumn($background, $width, $height, $newfile) {
	list($s_w, $s_h)=getimagesize($background);

	if ($width && ($s_w < $s_h)) {
   	 $width = ($height / $s_h) * $s_w;
	} else {
   	 $height = ($width / $s_w) * $s_h;
	}

	$new=imagecreatetruecolor($width, $height);

	$img=imagecreatefromgif($background);

	$otsc=imagecolortransparent($img);

	if($otsc >=0 && $otst < imagecolorstotal($img)){
		$tran=imagecolorsforindex($img, $otsc);
		
		$newt=imagecolorallocate($new, $tran["red"], $tran["green"], $tran["blue"]);

		imagefill($new, 0, 0, $newt);

		imagecolortransparent($new, $newt);
	}
	

	imagecopyresized($new, $img, 0, 0, 0, 0, $width, $height, $s_w, $s_h);

	imagegif($new, $newfile);

	imagedestroy($new);
	imagedestroy($img);
}

thumn("images/map.gif", 400, 400, "./images/map3.gif");
