<?php
header("content-type:text/html; charset=utf-8");
class test
{
	public $num	= 100;
	public $name= 'name';
	private $isset;
	private $unset;

	function __construct()
	{
		echo '构造函数<br />';
	}

	function getClassName()
	{
		echo "当前类名：";
		var_dump(__CLASS__);
	}

	function getFunNameByClass()
	{
		echo '当前类所执行的方法名：';
		var_dump(__METHOD__);
	}

	function getFilePath()
	{
		echo "当前执行脚本文件绝对路径：";
		var_dump(__FILE__);
	}

	function getFunName()
	{
		echo '当前方法名：';
		var_dump(__FUNCTION__);
	}

	/**
	 *	克隆方法
	 *	当你执行clone对象的时候，自动运行
	*/
	function __clone()
	{
		$this->num	+= 100;
	}

	/**
	 *	输出字符串
	*/
	function __toString()
	{
		return '这是学习魔术方法的类！';
	}

	/**
	 *	类对象未知方法的的补救措施
	 *	@param $methodName string 未知方法名
	 *	@param $argArr array 未知方法名传入的参数
	*/
	function __call($methodName, $argArr)
	{
		$line	= __LINE__;
		echo "<h4 style='color:#f00;'>\tERROR!</h4>";
		echo "<p style='color:#f00;'>\t遇到未知错误，当前".__CLASS__."类里边不存 '{$methodName}'方法名<br/>\t位于".$_SERVER['SCRIPT_FILENAME']."页面第".$line."行出现</p>\r\n";
	}

	/**
	 *	检测类的属性是否已声明时调用
	 *		个人理解为操作私人属性
	 *	@param $var string 属性名
	*/
	function __isset($var)
	{
		$varArr	= array('num', 'name');
		if(in_array($var, $varArr))
		{
			$reStr	= __CLASS__."类的 {$var} 属性已声明：他的值是：".$this->$var.'<br/>';
		}
		//返回私有属性已声明，但是你获取不到他的值
		elseif (in_array($var, array_keys(get_object_vars($this))))
		{
			$reStr	= __CLASS__."类的 {$var} 属性已经声明了。他的值别想让我告诉你<br/>";
		}
		else
		{	$reStr	= __CLASS__."类里边不存在 {$var} 属性。走开吧<br/>";	}
		echo $reStr;
	}

	/**
	 *	销毁一个属性时会执行该函数
	 *	@param $var string 属性名
	 *		我们不让外部删除私有属性
	*/
	function __unset($var)
	{
		$priVar	= array('isset', 'unset');
		if(in_array($var, $priVar))
		{	echo "这是属性！不允许销毁！<br/>";	}
		else
		{
			unset($this->$var);
			echo '销毁 {$var} 属性成功<br/>';
		}
	}

	function __get($var)
	{
		echo '怎样才让你执行呢？';
		echo '如果输出或打印了未知的属性，私有的属性，受保护的属性，那么我就会被执行';
	}

	/**
	 *	使用serialize()函数执行
	*/
	function __sleep()
	{
		echo '__sleep';
	}

	/**
	 *	反序列化时会执行该函数
	 *	使用unserialize()函数时执行	
	*/
	function __wakeup()
	{
		echo '__wakeup()';
	}
}
echo '<pre>';
$test = new test();

/**
 *	魔术常量的学习
 *	@2012-11-28
*/
echo "<h3>__CLASS__ 获取当前类名</h3>";
$test->getClassName();
echo "<p>\t当前类名：string(4) \"test\"</p>";
echo "<hr /><br/>";

echo "<h3>__METHOD__ 获取类名已经该类正在执行的方法</h3>";
$test->getFunNameByClass();
echo "<p>\t当前类所执行的方法名：string(23) \"test::getFunNameByClass\"</p>";
echo "<hr /><br/>";

echo "<h3>__FUNCTION__ 获取当前执行的函数名</h3>";
$test->getFunName();
echo "<p>\t当前方法名：string(10) \"getFunName\"</p>";
echo "<hr /><br/>";

echo "<h3>__FILE__ 获取当前执行脚本的绝对路径</h3>";
$test->getFilePath();
echo "<p>\t当前执行脚本文件绝对路径：string(34) \"E:\www\study\magic\magic_const.php\"</p>";
echo "<p>引入一个外部文件，在外部文件里输出__FILE__，会输出哪个路径呢</p>";
include 'include.php';
echo "<p>\t他还是输出了引入文件的绝对路径：include引入文件的绝对路径：E:\www\study\magic\include.php</p>";
echo "<p>\t网站更目录获取：path = dirname(__FILE__);</p>";
echo "<p>\t\twin下返回的路径为 C:\www\examp，所以这里我们一般把'\'替换成'/' code:str_replace('\\', '/', dirname(__FILE__))</p>";
echo "<p>\t\t __DIR__=dirname(__FILE__) 不过，该魔术方法只在5.3版本后有效</p>";
echo "<hr /><br/>";
/**
 *	魔术方法的学习
 *	@2012-11-28
*/
echo "<h3>__clone() 克隆方法</h3>";
echo "<p>\t配合clone关键词使用 当你执行clone对象的时候，自动运行</p>";
echo "<p>\t\t可以理解为新对象的构造方法</p>";
$testClone	= clone $test;
echo '原版的：',$test->num,'<br />';
echo '克隆后的：',$testClone->num,'<br />';
echo "<hr /><br/>";

echo "<h3>__toString() 输出字符串</h3>";
echo "<p>当你echo一个object对象时，会执行该方法</p>";
echo "<p>TIP:只能是字符串。最后必须return！</p>";
echo $test;
echo "<hr /><br/>";

echo "<h3>__call() </h3>";
echo "<p>执行某个类对象里的未知方法时会调用该函数</p>";
$test->testCall('asd', 'param1');
echo "<hr /><br/>";

echo "<h3>__isset()</h3>";
echo "<p>检测一个类里边的属性是否声明时调用该方法</p>";
echo isset($test->name);
echo "<hr /><br/>";

echo "<h3>__unset()</h3>";
echo "<p>删除某个属性时就执行他了</p>";

?>