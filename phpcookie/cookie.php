<?php
session_start();
header("content-type: text/html; charset=utf-8");
echo '<pre>';

/**
 *	Cookie学习
 *	2012-08-23
 *	2012-11-25
*/

/*
 *	补充
 *		如果开启ob_start()
 *			可以把响应内容放入缓冲区，在达到一定量后在输出。
 *			php配置文件开启：output_buffering on
*/

echo '<h3>COOKIE设置</h3>';
echo '<p>setcookie(name, [value, expire, path, domain, secure])</p>';
echo '<p>1.	name -> cookie的变量名， 可以通过$_COOKIE[\'cookiename\']调用变量名为Cookiename的Cookie</p>';
echo '<p>2.	value -> cooke变量的值，保存在客户端。 可以通过$_COOKIE[values]获取名为 values 的值。[和上一个有区别吗？]</p>';
echo '<p>3.	expire -> 过期时间，格式为标准的UNIX时间标记，单位秒。该值为0，那么COOKIE将永久有效，除非手动删除。但是浏览器一旦关闭，将会自动删除该cookie。</p>';
echo '<p>4.	path -> 该cookie在服务器里有效使用的路径</p>';
echo '<p>5.	domain -> cookie的有效域名，能在哪些域名下有效使用。baidu.com则设置为baidu.com</p>';
echo '<p>6.	secure -> 是否只能通过HTTPS链接有效。 默认为0，http和https都有效。</p>';
echo '<p><b>由于COOKIE是HTTP头标组成，所以必须最先输出，在session_start()之前。</b><p>';
echo '<p>setcookie</p>';
echo '<br/><hr/><br/>';

echo '<h3>删除COOKIE</h3>';
echo '<p>方法一：使用setCookie()删除</p>';
echo '<p>	将setCookie的第二个参数设置为空，过期时间小于系统当前时间即可。 exp:setCookie(\'cname\', \'\', time()-1)</p>';
echo '<p>方法二：客户端手动删除cookie文件[该方法可行性基本为0]</p>';
echo '<br/><hr/><br/>';

echo '<h3>练习：使用cookie实现自动登录</h3>';


echo "<h3>控制SESSION的生命周期</h3>";
echo '<p>session_set_cookie_params(lifetime, path, domain, secure)</p>';
echo '<p>1.lifetime: cookie的生存期 单位：秒</p>';
echo '<p>2.path: cookie的有效路径，可以用\'/\'</p>';
echo '<p>3.domain: cookie的作用域</p>';
echo '<p>4.secure: 在安全的范围内被发送 默认为true</p>';

$time	= 1*60;
//session_set_cookie_params($time);
//$_SESSION['id']	= 'CNTNN11';
echo "<p>SESSION周期秒数：{$time} 内容：<b>{$_SESSION['id']}</b> - 如果超过{$time}秒，\$_SESSION['id']的内容将不显示</p>";
echo '<br/><hr/><br/>';

echo "<h3>session_regenerate_id() 更新服务器端的session_id！</h3>";


echo "<h3>更改session的默认存储位置</h3>";
echo '<p>session_save_path(path)</p>';
echo '<p>1.	path->真实的session路径，保证该目录有读写权限</p>';
echo '<br/><hr/><br/>';

echo '<h3>session缓存函数</h3>';
echo '<p>session_cache_limiter()</p>';
echo '<p>参数1：nocache -> 不设置缓存</p>';
echo '<p>参数2：private -> 私有方式</p>';
echo '<p>参数3：private_no_expire -> 私有方式，但不过期</p>';
echo '<p>参数4：public -> 公有方式</p>';
echo '<p>使用方法：session_cache_limiter(nocache/private/private_no_expire/public)</p>';
echo '<br/><hr/><br/>';

echo '<h3>session缓存时间函数</h3>';
echo '<p>session_cache_expire(params)</p>';
echo '<p>1.	params可填可不填。 设置SESSION的过期时间，单位为分钟。 默认180分钟</p>';
echo '<p>使用方法：session_cache_expire(666)</p>';
echo '<p><b>TIP:session_cache_limiter和session_cache_expire必须在session_start()之前调用！！！</b></p>';

echo '<br/><hr/><br/>';

echo '<h3>SESSION数据库存储</h3>';
echo '<p>session_set_save_handler(open, close, read, write, destroy, gc)</p>';
echo '<p>该函数有6个参数，传入6个自定义函数/回调函数</p>';
echo '<p>1.	open : open(save_path, session_name) 找到session存储地址，取出变量名称。 用于打开数据库连接</p>';
echo '<p>2.	close : close() 关闭数据库连接。 mysql_close()</p>';
echo '<p>3.	read : read(key) 读取session的键值，key对应session_id。 向数据库中查询该session_id的内容</p>';
echo '<p>4.	write : write(key, data)写入session值，data为session_id的值。 向数据库中写入新的session数据</p>';
echo '<p>5.	destroy : destroy(key) 注销session_id的值。 类似于unset($_SESSION[\'id\'])</p>';
echo '<p>6.	gc : gc(expiry_time) 清除过期session记录</p>';
echo '<p>TIP:数据库中每条记录对应一个session_id，如果是数组格式，可以将数组序列化，以字符串格式存入数据库</p>';
echo '<br/><hr/><br/>';

?>