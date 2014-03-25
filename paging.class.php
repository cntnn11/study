<?php
/**
 * @date 2008-05-19 
 * @author ChangGuofeng
 * @access 分页类
 * @prompt 可对数组（一维、二维）和普通文本进行分页
 * @prompt 传参变量名默认为'page'
 * @prompt 使用方法:
 * @var value('每页容纳信息条数(数组)/每页容纳字体数(文本)', '分页内容');
 * @var pick($action);  //输出内容方法($action有俩个协议，str是获取内容，a是获取链接)
 * */
class Paging 
{
	
	private $size		= 10; // 预计分页数
	private $content	= NULL; // 预分页内容
	private $page		= NULL; // 输入页数
	private $error1		= 'Input parameter error or is empty.'; // 错误提示1
	private $error2		= 'This page can not be greater than the total page'; // 错误提示2
	
	public function __construct() 
	{
		$this->page = $this->page();
	}

	public function pick($action) 
	{		
		return $this->filter($action);
	}

	#初始化参数 size 每页分页数，content 需要分页的内容
	public function value($content, $size=20)
	{
		$this->size = $size;
		$this->content = $content;
	}
	
	private function page()
	{
        //自动获取页数参数
		return (isset($_REQUEST['page'])) ? ((int)$_REQUEST['page'] <= 0) ? 1 : (int)$_REQUEST['page'] : 1;
	}
	
	private function url()
	{
		//自动构造url完整链接
		$url = preg_replace('/&page=[0-9]/i', NULL, $_SERVER['QUERY_STRING']);  //接去掉url里面的'&page=0-9'
		return "{$_SERVER['PHP_SELF']}?{$url}";
	}
	
	private function filter($action) 
	{
		// 对必须输入的参数进行检测，防止空参数造成方法抛出错误
		if (($this->size or $this->content) == NULL) 
		{
			return $this->error1; // 抛出错误
		}
		else if(!in_array($action, array('str', 'a')))
		{
			return 'action error!';
		}
		else
		{
			return $this->is_content ($action);
		}
	}
	
	private function is_content($action) 
	{
		// 依据输入内容类型选择分页方法
		if (is_array ( $this->content )) 
		{			
			return $this->arr ($action); // 数组分页
		} 
		else 
		{
			return $this->text ($action); // 文本分页
		}
	}
	
	private function arr($action) 
	{
		// 对数组进行分页
		$pnum = ceil ( count ( $this->content ) / $this->size ); // 计算每页大小
		$page = $this->page > $pnum ? $pnum : $this->page;
		$newarr = array_slice ( $this->content, (($page - 1) * $this->size), $this->size ); // 输出数组
		return $action == 'str' ? $newarr : $this->a($pnum);
	}
	
	private function text($action) 
	{
		// 对文本进行分页
		$strlen = ceil ( strlen ( $this->content ) / $this->size ); // 计算总页数
		$page = $this->page > $strlen ? $strlen : $this->page;
		$prePageLen = strlen ( $this->subStrs ( $page - 1 ) ); // 截取字符起始数字
		$currentPageLen = strlen ( $this->subStrs ( $page ) ); // 截取字符结束数字
		$str = substr ( $this->content, $prePageLen, $currentPageLen - $prePageLen ); // 截取字符
		return $action == 'str' ? $str : $this->a($strlen);
	}
	
	private function subStrs($page) 
	{
		// 如果为汉字就截取俩个字符，如果为其他就截取一个字符
		$string = NULL;
		$len = $page * $this->size;
		for($i = 0; $i < $len; $i ++)
		{
			if (ord ( substr ( $this->content, $i, 1 ) ) > 0xa0) 
			{
				$string .= substr ( $this->content, $i, 2 );
				$i ++;
			} 
			else 
			{
				$string .= substr ( $this->content, $i, 1 );
			}
		}
		return $string;
	}
	
	private function a($num)
	{
		//上一页计算:一：当前页数小于等于0，为1；二：当前页-1大于总页数，为1
		//下一页计算:一：当前页数+1大于总页数，为当前最大页数；
		// $num获取总分页数
		$url = $this->url();
		$end_page = ($this->page == 1) ? 1 : (($this->page - 1) > $num) ? 1 : ($this->page - 1); // 上一页
		$to_page = (($this->page + 1) > $num) ? $num : ($this->page + 1); // 下一页
		$page_str = "{$this->page}/{$num}
		&nbsp;&nbsp;
		<a href='{$url}&page=1'>首页</a>
		&nbsp;&nbsp;
		<a href='{$url}&page={$end_page}'>上一页</a>
		&nbsp;&nbsp;
		<a href='{$url}&page={$to_page}'>下一页</a>
		&nbsp;&nbsp;
		<a href='{$url}&page={$num}'>末页</a>";
		return $page_str;
	}
	
	public function __destruct() 
	{
		unset ( $this->content, $this->page );
	}

}
header("content-type: text/html; charset=utf-8");

$content	= file_get_contents('reg.txt');
$p			= new Paging();

$p->value($content, 252);
$url    = $p->pick('str');
echo $url,'<br />';
