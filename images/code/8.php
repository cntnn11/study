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
 *	
 *		
 */

	function mark_text($background, $text, $x, $y){
		$back=imagecreatefromjpeg($background);

		$color=imagecolorallocate($back, 0, 255, 0);
	
		imagettftext($back, 20, 0, $x, $y, $color, "simkai.ttf", $text);

		imagejpeg($back, "./images/hee7.jpg");

		imagedestroy($back);
	}

	mark_text("./images/hee.jpg", "细说PHP", 150, 250);

	function mark_pic($background, $waterpic, $x, $y){
		$back=imagecreatefromjpeg($background);
		$water=imagecreatefromgif($waterpic);
		

		$w_w=imagesx($water);
		$w_h=imagesy($water);

		imagecopy($back, $water, $x, $y, 0, 0, $w_w, $w_h);

		imagejpeg($back,"./images/hee8.jpg");

		imagedestroy($back);
		imagedestroy($water);
	}

	mark_pic("./images/hee.jpg", "./images/gaolf.gif", 50, 200);

