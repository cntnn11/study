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
 *   四、图片的裁剪
 *   	
 *	imagecopyresized()
 *	imagecopyresampled()
 *
 *  五、加水印（文字， 图片）
 *	
 *	imagettftext();
 *	imagecopy();
 *
 *  六、图片旋转
 *
	imagerotate -- 用给定角度旋转图像
 *  	
 *
 *		
 */

	$back=imagecreatefromjpeg("./images/hee.jpg");

	$new=imagerotate($back, 45, 0);

	imagejpeg($new, "./images/hee9.jpg");
