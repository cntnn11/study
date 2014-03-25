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
	
	$filename="./images/hee.jpg";

	$per=0.3;
	
	list($width, $height)=getimagesize($filename);

	$n_w=$width*$per;
	$n_h=$width*$per;

	$new=imagecreatetruecolor($n_w, $n_h);

	$img=imagecreatefromjpeg($filename);

	imagecopyresized($new, $img,0, 0,0, 0,$n_w, $n_h, $width, $height);

	
	imagejpeg($new, "./images/hee2.jpg");

	imagedestroy($new);
	imagedestroy($img);
