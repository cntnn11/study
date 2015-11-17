<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
$file_default	= './Readme.md';
$file	= $_GET['file'];
echo '<p>'.$file.'</p>';
$file	= file_exists($file) ? $file : $file_default;
echo '<div style="margin-top:30px;width:100%;height:100%;">';

echo parsedown( $file );

echo '</div>';


/**
 *	@desc 使用parsedown解析markdown文件
*/
function parsedown( $file = '' )
{
	include "./parsedown_extra_master/ParsedownExtra.php";
	$Parsedown	= new ParsedownExtra();
var_dump($Parsedown);
exit();
	$markdown	= file_get_contents($file);
	$html		= $Parsedown->text( $markdown );
	return $html;
}

/**
 *	@desc 使用kramdown方式解析markdown文件
*/
function kramdown( $file = '' )
{
	$command	= ' /usr/bin/kramdown ' . $file;
	$html	= system( $command );
	return $html;
}
