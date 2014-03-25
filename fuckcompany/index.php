<?php
/**
 *	@DESC 不受欢迎的公司名单
 *	@author cntnn11
 *	@date 2013-07-30
*/
header("content-type:text/html; charset=utf8");
error_reporting(0);
require_once "conn.php";

$lists	= getlist();
?>

<html>
<head>
<title>程序员不喜欢的公司</title>
<meta charset="utf-8">
<meta name="keywords" content="程序员不欢迎公司 皮包公司 不靠谱公司 拖欠工资">
<meta name="description" content="">
<style type="text/css">
body{
	font-family: "微软雅黑";
	text-align: center;
}
.table th,.table td{
	border-top: 1px solid #DDDDDD;
	line-height: 18px;
	padding: 8px;
	text-align: left;
	vertical-align: top;
}
.toolTable{
	border: medium none;
	border-collapse: collapse;
	line-height: 36px;
	margin: 10px 0 20px;
	text-align: center;
}
.toolTable th{
	color: #006CBF;
	text-align: center;
}
.toolTable td{
	text-align: center;
}
.separateColor{
	background-color: #F4F4F4;
}

</style>
</head>
<body>
<h1>让程序员们伤心的公司名单</h1>
<p>1.&nbsp;&nbsp;&nbsp;&nbsp;信息必须准确，不得夸大，不能有个人感情色彩，是什么就是什么</p>
<p>2.&nbsp;&nbsp;&nbsp;&nbsp;必须有让所有人一看就明的原由，不能是‘太流氓’，‘不人道’，‘管理严’，‘老板傻X’之类模糊不清的词</p>
<p><a href="subinfo.php">点击此处提交你的不满</a></p>
<table width="100%" cellspacing="0" cellpadding="0" class="toolTable table"> 
	<theader>
	<tr>
		<th style="width:20%;" class="separateColor">公司名</th>
		<th style="width:50%">理由</th>
		<th style="width:15%;" class="separateColor">添加日期(yyyy-mm-dd)</th>
		<th style="width:15%;">提供人</th>
	</tr>
	</theader>
	<tbody>
	<?php foreach ($lists as $id => $row):?>
	<tr>
		<td class="separateColor"><?php echo urldecode($row['company_name']);?></td>
		<td><?php echo urldecode($row['reason']);?></td>
		<td class="separateColor"><?php echo urldecode($row['date']);?></td>
		<td><?php echo urldecode($row['sub_name']);?></td>
	</tr>
	<?php endforeach;?>
	</tbody>
</table>
<script type="text/javascript">
 var obj=document.getElementById("tb");
 for(var i=0;i<obj.rows.length;i++){  //循环表格行设置鼠标事件：丁学 http://www.cnblogs.com/dingxue
   obj.rows[i].onmouseover=function(){this.style.background="#0EF";}
   obj.rows[i].onmouseout=function(){this.style.background="";}
 }
</script>