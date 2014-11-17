<?php
/*
 *	@desc 使用CROCS解决方案，可以解决post、get请求！
 *			缺点：浏览器兼容性（IE9+，firefox25+，chrome30+）
*/
/*header('Access-Control-Allow-Origin: http://test.study.com');
echo '<pre>';
var_dump($_POST);
echo '</pre>';
*/



/**
 *	@desc getJSON获取，只支持get方式
*/
echo json_encode( array('ok'=>'ok', 'msg'=>'成功了！') );
exit();