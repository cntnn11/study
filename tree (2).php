<?php 
header('Content-Type: text/html; charset=utf-8');
/**
 +------------------------------------------------
* 通用的树型类
+------------------------------------------------
* @author yangyunzhou@foxmail.com
+------------------------------------------------
* @date 2010年11月23日10:09:31
+------------------------------------------------
*/
class Tree
{

	/**
	 +------------------------------------------------
	 * 生成树型结构所需要的2维数组
	 +------------------------------------------------
	 * @author yangyunzhou@foxmail.com
	 +------------------------------------------------
	 * @var Array
	 */
	var $arr = array();

	/**
	 +------------------------------------------------
	 * 生成树型结构所需修饰符号，可以换成图片
	 +------------------------------------------------
	 * @author yangyunzhou@foxmail.com
	 +------------------------------------------------
	 * @var Array
	 */
	var $icon = array('│','├',' └');

	/**
	 * @access private
	 */
	var $ret = '';

	/**
	 * 构造函数，初始化类
	 * @param array 2维数组，例如：
	 * array(
	 *      1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
	 *      2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
	 *      3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
	 *      4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
	 *      5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
	 *      6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
	 *      7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二')
	 *      )
	 */
	function tree($arr=array())
	{
		$this->arr = $arr;
		$this->ret = '';
		return is_array($arr);
	}

	/**
	 * 得到父级数组
	 * @param int
	 * @return array
	 */
	function get_parent($myid)
	{
		$newarr = array();
		if(!isset($this->arr[$myid])) return false;
		$pid = $this->arr[$myid]['parentid'];
		$pid = $this->arr[$pid]['parentid'];
		if(is_array($this->arr))
		{
			foreach($this->arr as $id => $a)
			{
				if($a['parentid'] == $pid) $newarr[$id] = $a;
			}
		}
		return $newarr;
	}

	/**
	 * 得到子级数组
	 * @param int $myid
	 * @return array
	 */
	function get_child($myid)
	{
		$a = $newarr = array();
		if(is_array($this->arr))
		{
			foreach($this->arr as $id => $a)
			{
				//如果当前 parentid 等于传进来的$myid，那么赋给一个数组
				if($a['parentid'] == $myid)
				{
					$newarr[$id] = $a;
				}
			}
		}
		return $newarr ? $newarr : false;
	}

	/**
	 * 得到当前位置数组
	 * @param int
	 * @return array
	 */
	function get_pos($myid,&$newarr)
	{
		$a = array();
		if(!isset($this->arr[$myid])) return false;
		$newarr[] = $this->arr[$myid];
		$pid = $this->arr[$myid]['parentid'];
		if(isset($this->arr[$pid]))
		{
			$this->get_pos($pid,$newarr);
		}
		if(is_array($newarr))
		{
			krsort($newarr);
			foreach($newarr as $v)
			{
				$a[$v['id']] = $v;
			}
		}
		return $a;
	}

	/**
	 * -------------------------------------
	 *  得到树型结构
	 * -------------------------------------
	 * @author yangyunzhou@foxmail.com
	 * @param $myid 表示获得这个ID下的所有子级
	 * @param $str 生成树形结构基本代码, 例如: "<option value=\$id \$select>\$spacer\$name</option>" //这个可以让用户自定义生成何种的树结构
	 * @param $sid 被选中的ID, 比如在做树形下拉框的时候需要用到
	 * @param $adds
	 * @param $str_group
	 */
	function get_tree($myid, $str = '', $sid = 0, $adds = '', $str_group = '')
	{
		$number	=1;
		$child	= $this->get_child($myid);
		if(is_array($child))
		{
			$total = count($child);
			foreach($child as $id=>$a)
			{
				$j=$k='';
				if($number==$total)
				{
					$j .= $this->icon[2];
				}
				else
				{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer		= $adds ? $adds.$j : '';
				$selected	= $id == $sid ? 'selected' : '';//当前遍历的id=$sid，那么赋予选中状态
				@extract($a);
				$parentid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
				$this->ret	.= $nstr;
				$this->get_tree($id, $str, $sid, $adds.$k.'&alt;',$str_group);
				
				$number++;
			}
		}
		return $this->ret;
	}

	/**
	 * 同上一方法类似,但允许多选
	 */
	function get_tree_multi($myid, $str, $sid = 0, $adds = '')
	{
		$number=1;
		$child = $this->get_child($myid);
		if(is_array($child))
		{
			$total = count($child);
			foreach($child as $id=>$a)
			{
				$j=$k='';
				if($number==$total)
				{
					$j .= $this->icon[2];
				}
				else
				{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';

				$selected = $this->have($sid,$id) ? 'selected' : '';
				@extract($a);
				eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree_multi($id, $str, $sid, $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $this->ret;
	}

	function have($list,$item){
		return(strpos(',,'.$list.',',','.$item.','));
	}

	/**
	 +------------------------------------------------
	 * 格式化数组
	 +------------------------------------------------
	 * @author yangyunzhou@foxmail.com
	 +------------------------------------------------
	 */
	function getArray($myid=0, $sid=0, $adds='')
	{
		$number	= 1;
		$child	= $this->get_child($myid);
		if(is_array($child))
		{
			$total = count($child);
			//遍历当前ID的子ID数组
			foreach($child as $id => $a)
			{
				$j = $k = '';
				if($number == $total)
				{
					//如果当前$number循环完了，走一圈了，那么输出一个图标，为第2种标志，表示每层的最后一级
					$j	.= $this->icon[2];
				}
				else
				{
					//$number还没走完，使用第一种标志，表示每层的中间列
					$j	.= $this->icon[1];
					//放出第一种标志，表示每行的第一列，但目前还不知道$adds表示'空格'
					$k	= $adds ? $this->icon[0] : '';
				}
				//表示空格$adds+标识符$icon
				$spacer	= $adds ? $adds.$j : '';

				@extract($a);
				$a['name']	= $spacer.' '.$a['name'];
				$this->ret[$a['id']]	= $a;
				$fd = $adds.$k.'&nbsp;';
				//echo $id,' - ',$sid,' - ',$fd,'<br />';
				$this->getArray($id, $sid, $fd);
				$number++;
			}
		}
		
		return $this->ret;
	}
}
?>

<?php
$data	= array(
	1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
	2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
	3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
	4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
	5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
	6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
	7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二')
);
echo '<pre>';
$tree = new Tree();	// new 之前请记得包含tree文件!
$tree->tree($data);	// 数据格式请参考 tree方法上面的注释!
 
// 如果使用数组, 请使用 getArray方法
$getArr	= $tree->getArray();

// 下拉菜单选项使用 get_tree方法
$getTree	= $tree->get_tree(0, '<option value=\$id \$select>\$spacer\$name</option>');
?>