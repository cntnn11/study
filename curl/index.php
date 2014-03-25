<?php
header("content-type:text/html; chrset=utf-8");
date_default_timezone_set('Asia/Chongqing');
set_time_limit(0);
/**
 *	@DESC CURL初步使用
 *	@author cntnn11
 *	@date 2013-05-17
 */
/**
 *	@DESC 先给出需要用curl的相关函数，从手册上复制的
 *		不过，我没有用到所有函数，只用了curl_init()，curl_setopt()，curl_exec()，curl_close();
 *		■curl_close — 关闭一个cURL会话
 *		■curl_copy_handle — 复制一个cURL句柄和它的所有选项
 *		■curl_errno — 返回最后一次的错误号
 *		■curl_error — 返回一个保护当前会话最近一次错误的字符串
 *		■curl_exec — 执行一个cURL会话
 *		■curl_getinfo — 获取一个cURL连接资源句柄的信息
 *		■curl_init — 初始化一个cURL会话
 *		■curl_multi_add_handle — 向curl批处理会话中添加单独的curl句柄
 *		■curl_multi_close — 关闭一组cURL句柄
 *		■curl_multi_exec — 解析一个cURL批处理句柄
 *		■curl_multi_getcontent — 如果设置了CURLOPT_RETURNTRANSFER，则返回获取的输出的文本流
 *		■curl_multi_info_read — 获取当前解析的cURL的相关传输信息
 *		■curl_multi_init — 返回一个新cURL批处理句柄
 *		■curl_multi_remove_handle — 移除curl批处理句柄资源中的某个句柄资源
 *		■curl_multi_select — 等待所有cURL批处理中的活动连接
 *		■curl_setopt_array — 为cURL传输会话批量设置选项
 *		■curl_versionrl_setopt — 设置一个cURL传输选项
 *		■curl_version — 获取cURL版本信息
*/
//==============================================================================
/**
 *	@DESC 1.简单的初步使用
 *		随便抓取一张网页，我用博客园做实验吧，就抓取首页 www.cnblogs.com
*/
$url	= "http://www.cnblogs.com";
/**
 *	首先使用curl_init();初始化
*/
	/*$test1	= curl_init($url);	//初始化一个curl资源
	$cnblogs	= curl_exec($test1);//执行他，并用一个变量接收返回的信息。这个信息就是我们访问网页时在页面上的内容
	curl_close($test1);
	echo $cnblogs;*/
//----OK，搞定！这是最简单的案例了。
	/*
	还有另一种方法，如下所示。不过我不用，你用吗？
	$test2	= curl_init();
	curl_setopt($test2, CURLOPT_URL, $url);
	$cnblogs	= curl_exec($test2);
	curl_close($test2);
	echo $cnblogs;
	*/
/**
 *	上述这种抓取可以直接用file_get_contents()函数来执行，代码少，简单，还省事。
 *	---------------------------简单的使用方式完毕---------------------------
*/


/**
 *	@DESC 使用curl做上边那种请求实在是太大材小用了，我们要进阶下，模拟个表单提交。
 *		嗯。。。。
 *		找谁做测试呢？
 *		还是模拟登录下php100，然后发个小帖子，在灌水区发。嘿嘿
*/
//1.	先找到登录页面地址，最好是单独页面的，当然找到他的ajax提交链接也可行。这个看你喜欢
$url	= 'http://bbs.php100.com/login.php?nowtime='.time().'&verify=f2bf350a';//复制的完整点嘛，nowtime字面意思是时间，所以给他一个时间戳。verify我就直接复制了
$php100	= curl_init($url);
//组织post表单数据。 tip：在这里传递给curl_setopt的post参数是一串url参数字符串！用‘&’分开的字符串
$post_data	= array(
	'ajax'	=> 1,
	'jumpurl'	=> 'http://bbs.php100.com/index.php',
	'lgt'	=> 0,
	'pwpwd'	=> 'cnpower1',
	'pwuser'=> 'cntnn11',
	'step'	=> 2,
);
curl_setopt($php100, CURLOPT_POST, 1);	//如果你想PHP去做一个正规的HTTP POST，设置这个选项为一个非零值。这个POST是普通的 application/x-www-from-urlencoded 类型，多数被HTML表单使用。
curl_setopt($php100, CURLOPT_POSTFIELDS, http_build_query($post_data));//这一个就是你要发送的post数据，要字符串格式的
//OK！post参数有了，我们可能需要一个头信息

//	header头信息是一个数组，这个你可以直接通过抓包工具或者firebug来获取，不了解http协议的直接照抄吧（我也是这么干的）。
$header	= array(
	'Accept	text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
	'Accept-Encoding	gzip, deflate',
	'Accept-Language	zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
	'Connection	keep-alive',
	'Host	bbs.php100.com',
	'Referer	http://bbs.php100.com/',
	'User-Agent	Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
	'Content-Length	97',
	'Content-Type	application/x-www-form-urlencoded',
);
curl_setopt($php100, CURLOPT_HEADER, 0);			//参数说明：设置成非零数就是在页面将头信息做为数据流输出来
curl_setopt($php100, CURLOPT_HTTPHEADER, $header);	//设置一个header中传输内容的数组。

//一般网站登录后会存一个cookie文件，那我们如果要发帖子就必须登录，所以我们需要保留这个cookie文件，用他去告诉被请求的网站，我现在是登录状态
$cookie_file	= tempnam('E:\www\study\curl', 'cookie');	//生成一个唯一文件。tempnam()具体用法查手册 (一定要输入一个绝对路径)
curl_setopt($php100, CURLOPT_COOKIEJAR,  $cookie_file);//将cookie信息存入我们生成的文件 CURLOPT_COOKIEJAR：连接关闭以后，存放cookie信息的文件名称
curl_setopt($php100, CURLOPT_RETURNTRANSFER, 0);	//在启用CURLOPT_RETURNTRANSFER时候将获取数据返回 这个直接在页面上输出还是手动输出 curl_exec()获取到的信息，没啥要求的可以不用加这句。 TRUE为不输出，0则直接输出

$login	= curl_exec($php100);	//执行。我理解为访问。嘿嘿~
curl_close($php100);
//现在我们已经获取到cookie文件，也看到cookie信息，那就说明我们成功了一半，接下来是测试发个帖，看看成不成

//我在他的水区板块发个内容（其他地方怕被封啊）
//这是水区发帖的链接 http://bbs.php100.com/post.php?fid=17
//先真实发一篇帖子，看看他都发送了哪些信息
//组织post表单数据 这里面这么多参数你得确定是不是固定的，还是每个发帖页面都不同，有的网站就用到hash码，这里的_hexie每张页面就不一样，所以你得去页面抓取这些数据
$getPostData	= curl_init("http://bbs.php100.com/post.php?fid=17");
curl_setopt($getPostData, CURLOPT_COOKIEFILE, $cookie_file);//这里的cookie_file就是我们模拟登录时保存的cookie文件。
curl_setopt($getPostData, CURLOPT_RETURNTRANSFER, 1);
$ftpage	= curl_exec($getPostData);
curl_close($getPostData);
//看到下边这些hidden没，我们正则一个个的抓吧。正则怎么写，我不说了，给不会的一个学习网址 http://manual.phpv.net/regular_expression.html
$post_data	= array();
echo "<pre>";
if($ftpage !== FALSE)
{
	$post_field	= array('step', 'pid', 'action', 'fid', 'tid', 'special', '_hexie', 'magicname', 'magicid', 'verify', 'cyid', 'ajax', 'iscontinue', 'p_sub_type');
	//我很懒，直接一个循环搞定所有
	foreach ($post_field as $field)
	{
		$pattern	= "/<input type=\"hidden\" value=\"(?<{$field}>[^>]*?)\" name=\"{$field}\" \/>/";
		preg_match_all($pattern, $ftpage, $matches, PREG_SET_ORDER);
		$post_data[$field]	= $matches[0][$field];
	}
	$post_data['p_type']	= '50';	//当然，有些值是固定的，比如p_type在这里就是你要发帖的类型，我选择‘只想灌水’类型，value=50
	$post_data['article']	= '笑话一则';
	$post_data['atc_content']	= '公司举行跳绳比赛，五分钟内跳得最多的冠军，奖金一千元。获奖的女孩很兴奋，拿到奖金后马上改了QQ个性签名:五分钟赚了一千块！太捧了！
后来有了朋友回复：那个男人真快！';
}
else
{
	echo "没有抓取到数据！";
	exit('stop!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
}


//OK，正式发帖！$ftl=发帖了
$ftl	= curl_init("http://bbs.php100.com/post.php?fid=17");
curl_setopt($ftl, CURLOPT_POST, 1);
curl_setopt($ftl, CURLOPT_POSTFIELDS, $post_data);	//post数据
curl_setopt($ftl, CURLOPT_COOKIEFILE, $cookie_file);	//cookie文件，这个很重要，登录通行证
curl_setopt($ftl, CURLOPT_HEADER, 0);	//头信息还是要的
$header = array(
	"POST /post.php?fid=17&nowtime=".time()."&verify=66e5c8a8 HTTP/1.1",
	"Host: bbs.php100.com",
	"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0",
	"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
	"Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3",
	"Accept-Encoding: gzip, deflate",
	"Referer: http://bbs.php100.com/post.php?fid=17",
	"Connection: keep-alive",
);
curl_setopt($ftl, CURLOPT_HTTPHEADER, $header);	//模拟个头信息
curl_setopt($ftl, CURLOPT_RETURNTRANSFER, 1);	//这个如果不设置，那么会默认将获取到的信息输出在页面上
$result = curl_exec($ftl);
curl_close($ftl);

//差不多到此结束了，以上只是个小实例，等多让你知道怎么用，具体用法还得自己去慢慢研究。
//ps:其实我这个发帖失败了






