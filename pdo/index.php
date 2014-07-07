<?php
/**
 *	@DESC PDO数据库连接学习
 *	@author cntnn11
 *	@date 2013-07-13
*/
//声明一个pdo对象
//new PDO($dsn , [$db_user, $db_pwd], $db_drive)
$db_dsn		= "mysql:host=127.0.0.1;dbname=test";
$db_user	= "root";
$db_pwd		= "ms";
$db_drive	= array(
	PDO::ATTR_AUTOCOMMIT	=> 1,
);

try
{
	$pdo_obj	= new PDO($db_dsn, $db_user, $db_pwd, $db_drive);
	//其他连接方式：
	//	1.	将dsn写入一个文件中
	//	2.	在php.ini文件加入以下内容 pdo.dsn.mysqlpdo=$db_dsn
}
catch(PDOException $e)
{
	$e->getMessage();
	exit('<p>连接失败了！</p>');
}

//
/**
 *	@DESC PDO的一些属性
 *	$pdo->getAttribute();	获取
 *	$pad->setAttribute();	设置属性【有些参数是不能通过该函数设置，如autocommit，只能从PDO的第四个参数传入】
 *	可以输出以下常量参数
 *		PDO::ATTR_AUTOCOMMIT		是否自动提交
 *		PDO::ATTR_CASE				指定数据库返回列名（字段名）的大小写 PDO::CASE_LOWER->小写、PDO::CASE_NATURAL->不变、PDO::CASE_UPPER->大写
 *		PDO::ATTR_CLIENT_VERSION	客户端版本
 *		PDO::ATTR_CONNECTION_STATUS	提交状态
 *		PDO::ATTR_DRIVER_NAME		驱动名
 *		PDO::ATTR_ERRMODE			错误模式/级别 PDO::ERRMODE_SILENT->仅设置错误代码、PDO::ERRMODE_WARNING->引发 E_WARNING 错误、PDO::ERRMODE_EXCEPTION:->抛出exceptions异常
 *		PDO::ATTR_ORACLE_NULLS		转换 NULL 和空字符串（在sql语句中，我们尽量将null转换成空字符串防止mysql出错） PDO::NULL_NATURAL->不转换、PDO::NULL_EMPTY_STRING->将空字符串转换成NULL、PDO::NULL_TO_STRING->将NULL转换成空字符串
 *		PDO::ATTR_PERSISTENT		
 *		PDO::ATTR_PREFETCH			
 *		PDO::ATTR_SERVER_INFO		服务器信息
 *		PDO::ATTR_SERVER_VERSION	服务器版本
 *		PDO::ATTR_TIMEOUT			各个驱动有差异，mysql表示超时时间
 */

$pdo_obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);	//设置错误级别
$pdo_obj->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);	//设置返回的字段名为小写
$pdo_obj->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);	//将NUL转化为空字符串
echo '是否自动提交：'.$pdo_obj->getAttribute(PDO::ATTR_AUTOCOMMIT),'<br/>';
echo '服务器信息：'.$pdo_obj->getAttribute(PDO::ATTR_SERVER_INFO),'<br/>';
echo '服务器版本：'.$pdo_obj->getAttribute(PDO::ATTR_SERVER_VERSION),'<br/>';
echo '客户端版本：'.$pdo_obj->getAttribute(PDO::ATTR_CLIENT_VERSION),'<br/>';

/**
 *	@DESC PDOStatement类
 *		对sql的批量操作进行预处理
 */
$stmt	= $pdo_obj->prepare("INSERT INTO `a`(`username`, `age`)VALUES(:username, :age);");
//变种1	$stmt	= $pdo_obj->prepare("INSERT INTO `:table`(`username`, `age`)VALUES(:username, :age);"); $table="a";
//变种2	$stmt	= $pdo_obj->prepare("UPDATE `:table` SET `username`=>':username', `age`=':age' WHERE `id`=':id';"); $table="a";

//执行方式1 使用bindParam()绑定参数
$stmt->bindParam(":username", $username);
$stmt->bindParam(":age", $age);
$username	= 'myname';
$age		= 23;
if($stmt->execute())
{
	echo '插入成功！';
	echo '最后插入的ID：'.$pdo_obj->lastInsertId();
	echo '<pre>';
}
else
{
	echo '插入失败！';
	echo "\tERROR：";
	var_dump($stmt->errorInfo());
}

//执行方式2
$stmt->execute(array(":username"=>'where', ":age"=>5));
echo '插入后的ID：'.$pdo_obj->lastInsertId().'<br/>';
$stmt->execute(array(":username"=>'where are', ":age"=>6));
echo '插入后的ID：'.$pdo_obj->lastInsertId().'<br/>';
$stmt->execute(array(":username"=>'where are you', ":age"=>7));
echo '插入后的ID：'.$pdo_obj->lastInsertId().'<br/>';

/**
 *	@DESC 使用PDO查询SQL
 *		主要两个方法：PDOStatement::fetch() 、 PDOStatement::fetchAll()
*/
$stmt	= $pdo_obj->prepare("SELECT * FROM `a` LIMIT :num");
/*
//TIP：使用bindParam()绑定必须通过引用传值的方式(&$var)进行设置，否则报告错误！
$stmt->bindParam(":num", $num);
$num	= 1;*/

//bindValue()绑定必须传入三个参数，否则报错！(绑定的名字参数, 值, 指定值的类型[PDO::PARAM_INT/PDO::PARAM_STR])
$num	= 3;
$stmt->bindValue(':num', $num, PDO::PARAM_INT);

echo '<pre>';
if($stmt->execute())
{
	$stmt->setFetchMode(PDO::FETCH_ASSOC);	//设置返回的结果集模式，FETCH_NUM:字段和索引、FETCH_ASSOC:只返回字段
	echo '<p>查询成功！结果集</p>';
	echo "<p>-----------------------fetchALL() 返回全部-----------------------</p>";
	//var_dump($stmt->fetchAll());

	echo "<p>-----------------------fetch() 一条条的返回-----------------------</p>";
	while($row = $stmt->fetch())
	{
		var_dump($row);
	}

	echo "<p>-----------------------rowCount() 返回受影响的条数-----------------------</p>";
	var_dump($stmt->rowCount());

	echo "<p>-----------------------columnCount() 返回字段列数-----------------------</p>";
	var_dump($stmt->columnCount());

	/*echo "<p>-----------------------getAttribute() 返回语句的属性 只有Firebird 和 ODBC 支持-----------------------</p>";
	var_dump($stmt->getAttribute(PDO::ATTR_CURSOR_NAME));*/

	echo '<p>一条预处理语句</p>';
	var_dump($stmt->debugDumpParams());
}
else
{
	echo "<p>查询失败</p>";
	var_dump($stmt->debugDumpParams());
	echo '<br/>';
	var_dump($stmt->errorInfo());
}
echo '</pre>';