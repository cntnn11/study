<?php
/**
 *	@desc 数据组key生成的源文件 & 生成规则
*/

function genAuth( $str )
{
	$md	= md5(md5(md5($str)));
	return $md;
}

$auth['test']	= genAuth( 'jkxy_test' );
$auth['press']	= genAuth( 'ldd_press' );
$auth['www']	= genAuth( 'cjt_www' );
$auth['admin']	= genAuth( 'lgj_admin' );
$auth['wiki']	= genAuth( 'xb_wiki' );
$auth['e']		= genAuth( 'lxl_event' );
$auth['app']	= genAuth( 'ftx_api' );

echo '<pre>';
var_export($auth);

