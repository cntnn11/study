<?php
/**
 *	@desc 补充消息数据，临时的。
*/
$conn	= mysqli_connect('10.0.0.5', 'root', '123456');
mysqli_select_db($conn, 'jkxy_msg_v1');
mysqli_set_charset($conn, 'utf8');


$s_time	= strtotime('2015-09-01 00:00:00');
$e_time	= time();


// 开班1、作业批改2、任务进阶3、直播通知4。其中，作业批改内容需要拼接API接口链接返回
$msg		= [
	'1'	=> [
		'title'		=> '开班提醒',
		'content'	=> '你参加的《Web大前端工程师就业班一期》将于【2015-09-01】开班，请安排好时间，提前做好听课准备。',
		'object_id'	=> '1',
		'extra'		=> '',
	],
	'2'	=> [
		'title'		=> '作业已批改',
		'content'	=> '你所提交的【任务2，第一个作业，第3版本】老师已经批改完成，得分为【93】分，很不错哦！',
		'object_id'	=> '2',
		'extra'		=> '{"hw_id":"26","hw_seq":"1","tk_seq":"2","hwr_id":"281"}',
	],
	'3'	=> [
		'title'		=> '任务进阶',
		'content'	=> '恭喜你，你参加的《Web大前端工程师就业班一期》课程「任务5」申请未通过，最终等级评分为A，很不错哦，请到web端学习中心详情页查看详情。',
		'object_id'	=> '3',
		'extra'		=> '',
	],
	'4'	=> [
		'title'		=> '直播通知',
		'content'	=> '本周直播课将于【2015-08-06 16：00】开始，请安排好时间，提前做好听课准备。',
		'object_id'	=> '4',
		'extra'		=> '',
	]
];

$insert_sql	= 'INSERT INTO `jkxy_msg_job` (`sender_id`, `receiver_id`, `extra`, `content`, `object_type`, `object_id`, `is_read`, `is_delete`, `created_at`, `updated_at`) VALUES';
$data_sql	= [];
for($i = $s_time; $i<$e_time; $i+=43200)
{

	$msg_type_data	= $msg[rand(1,4)];

	$sender_id		= 0;
	$receiver_id	= 2930302;
	$extra			= $msg_type_data['extra'];
	$title			= $msg_type_data['title'];
	$content		= $msg_type_data['content'];
	$object_type	= 'job';
	$object_id		= $msg_type_data['object_id'];
	$is_read		= 0;
	$is_delete		= 0;
	$created_at		= date( 'Y-m-d H:', $i) . rand(0, 59) . ':' . rand(0, 59);
	$updated_at		= $created_at;
	$data_sql[]		= "('{$sender_id}', '{$receiver_id}', '{$extra}', '{$content}', '{$object_type}', '{$object_id}', '{$is_read}', '{$is_delete}', '{$created_at}', '{$updated_at}')";
}
$sql	= $insert_sql	. implode(',', $data_sql) . ';';
echo $sql;
/*$sql	= "select * from `jkxy_msg_job` limit 1";
$query	= mysqli_query($conn, $sql);
echo '<pre>';
while($row = mysqli_fetch_array($query))
{
	print_r($row);
}*/

