<?php
header('Content-Type: text/html; charset=utf-8');
echo '<pre>';
require 'require.php';
echo $require;

require 'require.php';

require_once 'require.php';



echo '<hr />';
include 'include.php';
echo $include;

include 'include.php';
echo $include;
echo '<hr />';
//-------------------------------------------------------------

function __autoload($className)
{
	echo '怎么才让你执行呢？哦，看来是到这就走了';
	echo $className.'<br />';
	require_once $className.'.php';
}
//$obj1 = new myclass1();
$obj2 = new myclass2();



?>