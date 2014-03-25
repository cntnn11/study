<?php
header("Content-type: image/png");
@session_start();
$im = imagecreate(80,22);
$ii = 4;
$start = 0;
$code  = '';
for ($i=1; $i<=$ii; $i++)
{
    $src = imagecreate(20,22);
    $srcbgcolor  = imagecolorallocate($src, 255,255,255);
    $color = array(imagecolorallocate($src,0,255,0),imagecolorallocate($src,0,0,255),imagecolorallocate($src,255,0,0));
    $srctxtcolor = $color[mt_rand(0,2)];
    //$str="0123456789";
    $text   = mt_rand(0,9);
    $angle  = rand(-20,20);
    $size   = 12;
    $x      = $angle>-20?5:0;
    $code  .= $text;
    imagettftext($src, $size, $angle, $x, 16, $srctxtcolor, "data/font/incite.ttf",$text);
    imagecopy ($im, $src, $start, 0, 0, 0, 20, 30);
    $start += 20;
    imagedestroy($src);
}
$_SESSION['code'] = strtolower($code);
imagepng($im);
imagedestroy($im);
?> 