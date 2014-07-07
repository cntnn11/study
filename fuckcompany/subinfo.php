<?php 
if(isset($_POST['sub']) && $_POST['sub'] == 'cntnn11')
{
	require_once "conn.php";
	$data['company_name']	= isset($_POST['fuck_company']) ? urlencode($_POST['fuck_company']) : '';
	$data['reason']			= isset($_POST['reason']) ? urlencode($_POST['reason']) : '';
	$data['sub_name']		= isset($_POST['you_name']) ? urlencode($_POST['you_name']) : '';
	$data['other']			= isset($_POST['you_qq']) || isset($_POST['you_email']) ? urlencode($_POST['you_qq']).'-'.urlencode($_POST['you_email']) : '';
	$data['date']			= date('Y-m-d');
	if(insert($data))
	{
		//header("Location: http://www.cntnn11.com/fuckcompany");
		echo "<script>location.href='http://www.cntnn11.com/fuckcompany'</script>";
	}
	exit('回首页吧');
}


?>
<html>
<head>
<meta charset="utf-8" />
<title>程序员不喜欢的公司</title>
<style type="text/css">
body
{ font-family: "微软雅黑";}
label
{ width: 150px; text-align: right; display: inline-block;}
input
{ width: 300px; }
small
{ padding-left: 160px;}
.button
{ width: 100px; }

</style>
<body>
	<h1>为什么不满呢？真的是公司或者老板不行吗？是否是自己做事很烂才遭无视各种欺压呢？</h1>
	<form name="fuck" action="subinfo.php" method="post">
		<p>
			<label>您的姓名：</label>
			<span><input type="text" name="you_name" value="" size="15" /></span>
		</p>
		<p>
			<label>您不满的公司：</label>
			<span><input type="text" name="fuck_company" value="" size="50" /></span>
		</p>
		<p>
			<label>您不满的理由：</label>
			<span><textarea name="reason" style="width:450px; height:75px;"></textarea></span>
			<br/><small>TIP：理由必须详细精确，所有人一看就能明白是什么！不能使用太坏、太狠、耍流氓、就是不好等模糊不清的词！</small>
		</p>
		<p>
			<label>您的QQ：</label>
			<span><input type="text" name="you_qq" size="12" /></span>
		</p>
		<p>
			<label>您的邮箱：</label>
			<span><input type="text" name="you_email" size="30" /></span>
		</p>
		<p>
			<input class="button" type="submit" value="确认提交" />
			<input type="hidden" name="sub" value="cntnn11" />
		</p>
	</form>
</body>
