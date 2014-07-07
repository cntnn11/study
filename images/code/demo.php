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

八、锐化
	imagecolorsforindex()
	imagecolorat()	
 *
 *		
 */

function sharp($background, $degree, $save){
	$back=imagecreatefromjpeg($background);

	$b_x=imagesx($back);
	$b_y=imagesy($back);

	$dst=imagecreatefromjpeg($background);
	for($i=0; $i<$b_x; $i++){
		for($j=0; $j<$b_y; $j++){
			$b_clr1=imagecolorsforindex($back, imagecolorat($back, $i-1, $j-1));	
			$b_clr2=imagecolorsforindex($back, imagecolorat($back, $i, $j));

			$r=intval($b_clr2["red"]+$degree*($b_clr2["red"]-$b_clr1["red"]));
			$g=intval($b_clr2["green"]+$degree*($b_clr2["green"]-$b_clr1["green"]));
			$b=intval($b_clr2["blue"]+$degree*($b_clr2["blue"]-$b_clr1["blue"]));

			$r=min(255, max($r, 0));
			$g=min(255, max($g, 0));
			$b=min(255, max($b, 0));

			if(($d_clr=imagecolorexact($dst, $r, $g, $b))==-1){
				$d_clr=Imagecolorallocate($dst, $r, $g, $b);
			}

			imagesetpixel($dst, $i, $j, $d_clr);
		}
	
	}
	imagejpeg($dst, $save);
	imagedestroy($back);
	imagedestroy($dst);
}

sharp("./images/hee.jpg", 20, "./images/hee13.jpg");
