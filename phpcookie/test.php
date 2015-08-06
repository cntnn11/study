<?php
header("content-type: text/html; charset=utf-8");
/**
 *	cookie重新学习和测试
 *	@date 2012-12-08
*/

//output_buffering 开启缓冲区的命令配置
//ob_start() 将后边将要输出的内容放入一个缓冲区
//sleep()

setcookie('test', '存一个cookie！');

?>

<script type="text/javascript">
	console.log( document.cookie );
</script>
