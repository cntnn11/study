<?php
header("content-type:text/html; charset=utf-8");
echo '<pre>';
/**
 *	字符串统计，每个字符按一个长度计算
 *		支持GBK，UTF8
 *	类似mb_strlen()
 *	@author 谭宁宁
 *	@time 2012-08-05
 */	
if( !function_exists('strcount'))
{
	function strcount($string, $char='utf8')
	{
		$count	= strlen($string);
		$i		= 0;	//当前的字节数
		$j		= 0;	//按照字符进行累加
		while ($i<$count)
		{
			//英文及半角特殊字符
			if(ord($string[$i]) >=0 && ord($string[$i]) <=126)
			{	$charset	= 'en';	}
			//汉字及全角字符
			else
			{	$charset	= $char;}

			switch (strtolower($charset))
			{
				case 'gb2312':
				case 'gbk':
					$i		+= 1;
					break;
				case 'utf8':
					$i		+= 2;
					break;
				case 'en':
				default:
					break;
			}
			$j++;
			$i++;
		}
		return $j;
	}
}
else
{	echo '<p>fun strcount exists!</p>';	}

/**
 *	自定义字符串截取函数，防止mb_substr()没有开启
 *	通过用户输入的$char来判断当前汉字的字符集编码
 *	@param int $start 开始的字符数
 *	@param int $offest 偏移量，及从$start开始往后输出多少个字符
 *	@param str $char 使用者手动输入当前的汉字符编码
 *	@author 谭宁宁
 *	@time 2012-08-05
 */	
if( !function_exists('strsub'))
{
	function strsub($string, $start=0, $offest=0, $char='utf8')
	{
		$count	= strlen($string);
		$rs		= '';
		$i		= 0;	//按字节数累计
		$j		= 0;	//按字符数累计
		$size	= 1;	//记录每次substr时的终止位置，汉字需要考虑gbk和utf8两种情况
		while ($i < $count)
		{
			//英文及半角特殊字符
			if(ord($string[$i]) >=0 && ord($string[$i]) <=126)
			{	$charset	= 'en';	}
			//汉字及全角字符
			else
			{	$charset	= $char;}
			
			switch (strtolower($charset))
			{
				case 'gb2312':
				case 'gbk':
					$i		+= 1;
					$size	= 2;
					break;
				case 'utf8':
					$i		+= 2;
					$size	= 3;
					break;
				case 'en':
				default:
					$size	= 1;
					break;
			}
			
			if($j < intval($start+$offest) && $j >= $start)
			{
				$tstart	= intval($i-$size)+1;
				$rs		.= substr($string, $tstart, $size);
			}
			$j++;
			$i++;
		}
		return $rs;
	}
}
else
{	echo '<p>fun strsub exists!</p>';	}

/*$string	= '123456789汉字胡总温中文啊abcdefghijklmn·=-';
echo 'substr()：',substr($string, 9, 3),'<br />';
echo '长度：',strcount($string),'<br />';
echo '截取测试：',strsub($string, 0, 11),'<br />';*/

$fileContent	= file_exists('reg.txt') ? file_get_contents('reg.txt') : '';

$count			= strcount($fileContent);
$page			= !isset($_GET['p']) ? 1 : $_GET['p'];	//获取当前页码，默认为1
$pagesize		= 350;	//每页多少字符
$pagecount		= $count/$pagesize;
$pagecount		= strpos($pagecount, '.') ? intval($pagecount)+1 : intval($pagecount);	//总页码,如果出现小数，那么就得+1页
$start			= $page<=1 ? 0 : ($page-1)*$pagesize;

$fileContent	= strsub($fileContent, $start, $pagesize, 'utf8');
?>

<header>
<style type="text/css">
p
{	margin: 10px; word-wrap: break-word; border:#000 1px solid; padding:5px;	}
p a
{	margin: 5px;	}
</style>
</header>
<body>
<p><?php echo $fileContent; ?></p>

<p>
<?php
echo "共有字符：$count /每页 $pagesize 个&nbsp;&nbsp;";
echo "&nbsp;共 $pagecount 页/当前第 $page 页";

if($page <= 1)
{
	echo '<a>首页</a>';
	echo '<a>上一页</a>';
}
else
{
	$up	= $page-1;
	echo "<a href='/contentpage.php?p=1'>首页</a>";
	echo "<a href='/contentpage.php?p=$up'>上一页</a>";
}

if($page == $pagecount)
{
	echo '<a>下一页</a>';
	echo '<a>尾页</a>';
}
else
{
	$down	= $page+1;
	echo "<a href='/contentpage.php?p=$down'>下一页</a>";
	echo "<a href='/contentpage.php?p=$pagecount'>尾页</a>";
}
?>
</p>

<p>
PHP计算字符串长度，包括计算英文、GBK、UTF-8多种字符集下PHP如何计算字符串长度。英文字符串长度
strlen()是PHP自带的计算英文字符串的函数。

GBK字符串长度
中文字符计算为2个字符，英文字符计算为1个，可以统计中文字符串长度的函数。 function abslength($str){p

<?php
function gbklen($str)
{
	$len	= strlen($str);
	$i		= 0;
	while($i<$len)
	{
		if(preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$str[$i]))
		{
			$i+=2;
		}
		else
		{
			$i+=1;
		}
	}
	return $i;
}
?>

UTF8字符串长度
下面定义的strlen_utf8函数可以统计UTF-8字符串的长度，但不同的是，该函数并不考虑字节，这有些类似 Javascript 中字符串的length方法，一个字符全部按 1 个长度计算。 


<?php // 说明：计算 UTF-8 字符串长度（忽略字节的方案） 
$str = "www.phpq.net-PHP资讯";
echo strlen_utf8($str);


function strlen_utf8($str)
{
	$i = 0;
	$count = 0;
	$len = strlen ($str);
	while ($i < $len)
	{
		$chr = ord ($str[$i]);
		$count++;
		$i++;
		if($i >= $len) break;
		if($chr & 0x80)
		{
			$chr <<= 1;
			while ($chr & 0x80)
			{
				$i++;
				$chr <<= 1;
			}
		}
	}
	return $count;
}

/******************************************************************
* PHP截取UTF-8字符串，解决半字符问题。
* 英文、数字（半角）为1字节（8位），中文（全角）为3字节
* @return 取出的字符串, 当$len小于等于0时, 会返回整个字符串
* @param $str 源字符串
* $len 左边的子串的长度
****************************************************************/
function utf_substr($str,$len)
{
	for($i=0; $i<$len; $i++)
	{
		$temp_str=substr($str,0,1);
		if(ord($temp_str) > 127)
		{
			$i++;
			if($i<$len)
			{
				$new_str[]=substr($str,0,3);
				$str=substr($str,3);
			}
		}
		else
		{
			$new_str[]=substr($str,0,1);
			$str=substr($str,1);
		}
	}
	return join($new_str);
}
?>
</p>
</body>