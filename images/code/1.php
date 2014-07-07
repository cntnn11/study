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
 *
 */

	$img=imagecreatefromgif("./images/map.gif");
	$red= imagecolorallocate($img, 255, 0, 0);
	
	imageline($img, 0, 0, 100, 100, $red);
	
	imageellipse($img, 200, 100, 100, 100, $red);

	imagegif($img, "./images/map2.gif");

	imagedestroy($img);
