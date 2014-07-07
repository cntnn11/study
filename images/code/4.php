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
 *    
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

	$img=imagecreatefromjpeg($background);

	imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $s_w, $s_h);

	imagejpeg($new, $newfile);

	imagedestroy($new);
	imagedestroy($img);
}

thumn("images/hee.jpg", 200, 200, "./images/hee3.jpg");
