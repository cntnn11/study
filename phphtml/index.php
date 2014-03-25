<?php
header("content-type:text/html; charset=utf-8");
/**
 *	PHP页面静态化
 *	@time 2012-12-23
 *	@author cntnn11
*/
?>
<header>
<title>PHP页面静态化</title>
</header>
<body>
<h3>设置下php.ini文件</h3>
<p>1.	output_buffer: off</p>
<hr>
<h3>一些函数</h3>
<p>1.	ob_start();	//开启缓存</p>
<p>2.	ob_get_contents();	//获取缓存里的内容</p>
<p>3.	ob_clean();	//清空output_burffer的缓存内容</p>
<p>4.	ob_end_clean();	//清空缓存里的内容，同时关闭缓冲空间'ob_start()'</p>
<p>5.	ob_end_flush();	//把缓中区的内容输出，然后关闭</p>
<p>6.	ob_flush();	//输出ob内容，并清空，但不关闭</p>



<h3></h3>

</body>


