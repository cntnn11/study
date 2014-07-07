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

    七、图片翻转
    	
    	沿Y轴

	沿X轴
 *
 *		
 */

	function turn_y($background, $newfile){
		$back=imagecreatefromjpeg($background);

		$width=imagesx($back);
		$height=imagesy($back);

		$new=imagecreatetruecolor($width, $height);

		for($x=0; $x < $width; $x++){
			imagecopy($new, $back, $width-$x-1, 0, $x, 0, 1, $height);
		}

		imagejpeg($new, $newfile);

		imagedestroy($back);
		imagedestroy($new);
	}

	function turn_x($background, $newfile){
		$back=imagecreatefromjpeg($background);

		$width=imagesx($back);
		$height=imagesy($back);

		$new=imagecreatetruecolor($width, $height);

		for($y=0; $y < $height; $y++){
			imagecopy($new, $back,0, $height-$y-1, 0, $y, $width, 1);
		}

		imagejpeg($new, $newfile);

		imagedestroy($back);
		imagedestroy($new);
	}

	turn_y("./images/hee.jpg", "./images/hee11.jpg");
	turn_x("./images/hee.jpg", "./images/hee12.jpg");
