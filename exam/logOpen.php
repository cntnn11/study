<?php
header("content-type: text/html; charset=utf-8");
echo '<pre>';
$apLogAcc	= 'd:/xampp/apache/logs/access.log';



if(is_file($apLogAcc))
{
	var_dump(file($apLogAcc));
}
else
{
	echo '没有该文件';
}

?>