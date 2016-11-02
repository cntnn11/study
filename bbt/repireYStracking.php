<?php 
/**
 *	@desc	修复宜送没有物流信息的。
 *			处理方案： 推送到快递100中获取物流信息。
 *			http://test.study.com/bbt/repireYStracking.php
 *	@date	2016-07-23 14:19:35
*/
echo '<pre>';
$conn	= mysqli_connect('online-master-order-slave.c9qvc7ixh1mw.rds.cn-north-1.amazonaws.com.cn:3396', 'root', '0f55921d37ecd11333bbf56f2dc2ae73');
if( !$conn )
{
	exit('<hr/> conn fail! ');
}

mysqli_set_charset($conn, 'UTF8');
mysqli_select_db($conn, 'bbt');


/*$data	= [
	'type'		=> 2,
	'orderId'	=> $orderId,
	'procureId'	=> $procureId,
	'pushStatus'=> 1,
	'address'	=> empty($order_info['data']['address']) ? '' : $order_info['data']['address'],
	'kuaiCode'	=> $init['core_conf']['expressIdArr'][$value['outExpressId']]['kuaiCode'],
	'expressNo'	=> $value['outExpressNo'],
	'createTime'=> date('Y-m-d H:i:s'),
];*/


$kuaidi100InsSql	= "INSERT INTO `order_kuaipush` (`type`, `orderId`, `procureId`, `pushStatus`, `address`, `kuaiCode`, `expressNo`, `createTime`) VALUES ";
$createTime			= date('Y-m-d H:i:s');
// 宜送美国部分EMS未推送路线运单号推送
$sql				= "SELECT id,transferId,orderId,procureId,flowStatus,succTime,outExpressId,outExpressNo,warehouseId from stock_flow where outExpressId>0 AND flowType=2 and stat=0 and flowStatus=90 and orderId in (select orderId from bbt_order where stat=0 and expressStatus>=20 and orderId not in (select orderId from order_tracking where source=2) and orderId in (select orderId from order_item where refundId=0 and stat=0) ) and succTime<='2016-07-18 23:59:59' and warehouseId IN (9) order by id desc limit 100;";

$yisongUSADataSql	= getSql($conn, $sql, $createTime);
echo $kuaidi100InsSql . $yisongUSADataSql;
/*
INSERT INTO `order_kuaipush` (`type`, `orderId`, `procureId`, `pushStatus`, `address`, `kuaiCode`, `expressNo`, `createTime`) VALUES ('2', '623613577265281', '25674', '1', '四川省 成都市 新都区 香樟林8-1-5', 'ems', 'CY003237788US', '2016-07-23 07:02:19'),('2', '626898618581120', '26269', '1', '上海市 上海市 普陀区 武威东路788弄47/401', 'ems', 'CY003338150US', '2016-07-23 07:02:19'),('2', '626907642298496', '26271', '1', '广东省 佛山市 顺德区 碧桂园西苑鸣翠谷一期26号', 'ems', 'CY003337928US', '2016-07-23 07:02:19'),('2', '628139268145280', '26326', '1', '上海市 上海市 浦东新区 高青路4567弄25号1101室', 'ems', 'CY003344699US', '2016-07-23 07:02:19'),('2', '628351596331136', '26331', '1', '上海市 上海市 闵行区 马桥镇 元江路6600弄 绿城玫瑰园219室，201100', 'ems', 'CY003336233US', '2016-07-23 07:02:19'),('2', '629299851952256', '26393', '1', '浙江省 杭州市 上城区 清泰南苑17幢2单元301', 'ems', 'CY003345368US', '2016-07-23 07:02:19'),('2', '629302542336128', '26394', '1', '浙江省 杭州市 上城区 清泰南苑17幢2单元301', 'ems', 'CY003345371US', '2016-07-23 07:02:19'),('2', '626567777124480', '26227', '1', '四川省 成都市 金牛区 金房苑东路48号', 'ems', 'CY003344212US', '2016-07-23 07:02:19'),('2', '626577094279297', '26231', '1', '上海市 上海市 闵行区 沪光路555弄100号', 'ems', 'CY003340096US', '2016-07-23 07:02:19'),('2', '624138592583808', '26048', '1', '吉林省 长春市 南关区 吉林省长春市南环城路中海水岸馨都b6-303   ', 'ems', 'CY003344402US', '2016-07-23 07:02:19'),('2', '623313887002752', '25622', '1', '北京市 北京市 朝阳区 五里桥二街一号院4号楼0421（北京像素北区）', 'ems', 'CY003337097US', '2016-07-23 07:02:19'),('2', '623665868308609', '25697', '1', '四川省 成都市 双流县 四川省机场集团有限公司办公室', 'ems', 'CY003337295US', '2016-07-23 07:02:19'),('2', '623669270282368', '25700', '1', '上海市 上海市 嘉定区 嘉定镇迎园路400号新成路街道', 'ems', 'CY003337429US', '2016-07-23 07:02:19'),('2', '621056611385473', '25240', '1', '四川省 成都市 金牛区 国际商贸城荷花池中药材市场', 'ems', 'CY003343910US', '2016-07-23 07:02:19'),('2', '620953815613568', '25189', '1', '北京市 北京市 东城区 广渠门北里甲73号丽水湾畔3号楼204', 'ems', 'CY003345283US', '2016-07-23 07:02:19'),('2', '620969056895104', '25200', '1', '上海市 上海市 浦东新区 唐镇南曹路901弄5号楼302', 'ems', 'CY003345204US', '2016-07-23 07:02:19');
*/
echo "<hr/><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>";


// 宜送日本仓EMS未推送出库运单号修复。
$sql	= "SELECT id,transferId,orderId,procureId,flowStatus,succTime,outExpressId,outExpressNo,warehouseId from stock_flow where outExpressId>0 AND flowType=2 and stat=0 and flowStatus=90 and orderId in (select orderId from bbt_order where stat=0 and expressStatus>=20 and orderId not in (select orderId from order_tracking) and orderId in (select orderId from order_item where refundId=0 and stat=0) ) and succTime<='2016-07-20 23:59:59' and warehouseId=11 order by id desc limit 100;";
$yisongJPADataSql	= getSql($conn, $sql, $createTime);
echo $kuaidi100InsSql . $yisongJPADataSql;
/* 已执行
INSERT INTO `order_kuaipush` (`type`, `orderId`, `procureId`, `pushStatus`, `address`, `kuaiCode`, `expressNo`, `createTime`) VALUES ('2', '655110498222208', '28718', '1', '北京市 北京市 朝阳区 北京市朝阳区来广营东路9号长岛澜桥12-101', 'ems', 'EJ512727908JP', '2016-07-23 07:02:19'),('2', '653570203287680', '28519', '1', '江苏省 苏州市 太仓市 东仓南路18号世纪苑望雪园4-304', 'ems', 'EJ512728165JP', '2016-07-23 07:02:19'),('2', '654535473954944', '28631', '1', '北京市 北京市 海淀区 复兴路甲23号临5院东旭集团', 'ems', 'EJ512728041JP', '2016-07-23 07:02:19'),('2', '654654610964608', '28638', '1', '安徽省 合肥市 蜀山区 望江西路万科金色名郡11栋1804', 'ems', 'EJ512727823JP', '2016-07-23 07:02:19'),('2', '654821375639680', '28655', '1', '广东省 广州市 番禺区 南村镇兴南大道368号万科红郡花园三期六街9号', 'ems', 'EJ512728038JP', '2016-07-23 07:02:19'),('2', '651842901868672', '28399', '1', '辽宁省 大连市 中山区 五惠路21号（大连瑞诗酒店）', 'ems', 'EJ512727942JP', '2016-07-23 07:02:19'),('2', '653509849120896', '28504', '1', '贵州省 贵阳市 南明区 青年路东宝花园2栋1单元5楼2号', 'ems', 'EJ512728015JP', '2016-07-23 07:02:19'),('2', '651566000668801', '28389', '1', '浙江省 宁波市 江东区 东部新城昌乐路258号东南大厦1103室', 'ems', 'EJ512727810JP', '2016-07-23 07:02:19'),('2', '651102041800833', '28373', '1', '江苏省 南京市 建邺区 乐山路199号仁恒江湾城二期9幢901', 'ems', 'EJ512727854JP', '2016-07-23 07:02:19'),('2', '651399846920320', '28369', '1', '上海市 上海市 浦东新区 高科西路2763弄312号303室', 'ems', 'EJ512727925JP', '2016-07-23 07:02:19'),('2', '653399161929856', '28466', '1', '北京市 北京市 西城区 复兴门内大街18号国家开发银行', 'ems', 'EJ512727911JP', '2016-07-23 07:02:19'),('2', '653474712649856', '28495', '1', '河北省 廊坊市 广阳区 银河北路华苑小区17号楼5单元', 'ems', 'EJ512727995JP', '2016-07-23 07:02:19'),('2', '654371235397760', '28615', '1', '上海市 上海市 金山区 石化板桥东路1480弄6号105', 'ems', 'EJ512728007JP', '2016-07-23 07:02:19'),('2', '650973933994112', '28322', '1', '广东省 广州市 越秀区 东风西路148号嘉和苑二座2106房', 'ems', 'EJ512727956JP', '2016-07-23 07:02:19'),('2', '649665837006976', '28266', '1', '广东省 广州市 天河区 体育西路天河北街侨苑小区12号201', 'ems', 'EJ512728086JP', '2016-07-23 07:02:19'),('2', '648635981004928', '28135', '1', '福建省 厦门市 思明区 禾祥西路太湖新城193号503室', 'ems', 'EJ512727837JP', '2016-07-23 07:02:19'),('2', '645095200292992', '27756', '1', '北京市 北京市 朝阳区 来广营东路长岛澜桥32-102', 'ems', 'EJ512727236JP', '2016-07-23 07:02:19'),('2', '646208513867904', '27847', '1', '江苏省 苏州市 张家港市 杨舍镇蓝波金典25幢701', 'ems', 'EJ512727695JP', '2016-07-23 07:02:19'),('2', '646500029005952', '27913', '1', '北京市 北京市 朝阳区 甘露园南里25号朝阳园7号楼3e', 'ems', 'EJ512727426JP', '2016-07-23 07:02:19'),('2', '646521929203840', '27921', '1', '北京市 北京市 东城区 东四十条甲22号南新仓商务大厦A座903', 'ems', 'EJ512727117JP', '2016-07-23 07:02:19'),('2', '643689236070528', '27643', '1', '广东省 汕头市 澄海区 登峰路国驰货运中心19号天宝公司', 'ems', 'EJ512727664JP', '2016-07-23 07:02:19'),('2', '643566323007616', '27602', '1', '上海市 上海市 浦东新区 长岛路1560弄17号2206室', 'ems', 'EJ512727196JP', '2016-07-23 07:02:19'),('2', '643295681446016', '27530', '1', '湖北省 武汉市 江夏区 东湖高新技术开发区高新四路19号联想（武汉）产业基地', 'ems', 'EJ512726981JP', '2016-07-23 07:02:19'),('2', '643132238725248', '27518', '1', '北京市 北京市 朝阳区 北京市朝阳区来广营东路9号长岛澜桥12-101', 'ems', 'EJ512726978JP', '2016-07-23 07:02:19'),('2', '643181742817409', '27524', '1', '上海市 上海市 浦东新区 林鸣路326弄88号', 'ems', 'EJ512727179JP', '2016-07-23 07:02:19'),('2', '642181169479808', '27419', '1', '黑龙江省 哈尔滨市 呼兰区 利民区哈师大家属楼32栋1单元1101', 'ems', 'EJ512727103JP', '2016-07-23 07:02:19'),('2', '642006067675264', '27393', '1', '北京市 北京市 通州区 九棵树当代名筑家园101号楼2122', 'ems', 'EJ512727412JP', '2016-07-23 07:02:19'),('2', '643511895425152', '27570', '1', '上海市 上海市 闵行区 万源路580弄4号2401', 'ems', 'EJ512727148JP', '2016-07-23 07:02:19'),('2', '643666648498304', '27634', '1', '北京市 北京市 朝阳区 五里桥二街一号院4号楼0421（北京像素北区）', 'ems', 'EJ512727430JP', '2016-07-23 07:02:19'),('2', '645641635725440', '27805', '1', '天津市 天津市 河东区 卫国道凤溪花园15-2-202', 'ems', 'EJ512728024JP', '2016-07-23 07:02:19'),('2', '640893243064448', '27343', '1', '广东省 深圳市 龙岗区 平湖街道融湖中心城2e1605', 'ems', 'EJ512726964JP', '2016-07-23 07:02:19'),('2', '639981321191552', '27214', '1', '福建省 福州市 台江区 福建省福州市台江区国货西路17号群升国际J区兴业银行', 'ems', 'EJ512726995JP', '2016-07-23 07:02:19'),('2', '642333554081920', '27442', '1', '浙江省 温州市 乐清市 柳市镇柳青北路192-196号', 'ems', 'EJ512727085JP', '2016-07-23 07:02:19'),('2', '643485509124224', '27574', '1', '湖南省 娄底市 冷水江市 财富中心2单元', 'ems', 'EJ512727001JP', '2016-07-23 07:02:19'),('2', '639951598649472', '27210', '1', '浙江省 嘉兴市 秀城区 纺工路香缇御峰80-502', 'ems', 'EJ512727046JP', '2016-07-23 07:02:19'),('2', '639749442699392', '27177', '1', '甘肃省 兰州市 城关区 雁儿湾路399号', 'ems', 'EJ512727015JP', '2016-07-23 07:02:19'),('2', '639834883915905', '27191', '1', '北京市 北京市 海淀区 西二旗领秀新硅谷C区23-701', 'ems', 'EJ512727409JP', '2016-07-23 07:02:19'),('2', '639873394901120', '27201', '1', '山东省 东营市 东营区 格林星城8号楼', 'ems', 'EJ512727125JP', '2016-07-23 07:02:19'),('2', '642906354155648', '27491', '1', '上海市 上海市 闵行区 东川路811弄76号交大闵行幼儿园东川分园', 'ems', 'EJ512727899JP', '2016-07-23 07:02:19'),('2', '643132238463104', '27516', '1', '北京市 北京市 朝阳区 北京市朝阳区来广营东路9号长岛澜桥12-101', 'ems', 'EJ512727960JP', '2016-07-23 07:02:19'),('2', '643445830287488', '27551', '1', '上海市 上海市 虹口区 吴家湾路98号', 'ems', 'EJ512727987JP', '2016-07-23 07:02:19'),('2', '638063238152320', '27062', '1', '北京市 北京市 海淀区 交大东路21号院1号楼603', 'ems', 'EJ512727284JP', '2016-07-23 07:02:19'),('2', '637166042611840', '26966', '1', '江苏省 苏州市 昆山市 创业路666号 吉田国际10-2101', 'ems', 'EJ512726669JP', '2016-07-23 07:02:19'),('2', '639111825752192', '27091', '1', '北京市 北京市 丰台区 蒲芳路9号GOGO新世代小区2号楼2210室', 'ems', 'EJ512726805JP', '2016-07-23 07:02:19'),('2', '636950364160128', '26939', '1', '甘肃省 张掖市 高台县 高台县人民医院', 'ems', 'EJ512726672JP', '2016-07-23 07:02:19'),('2', '636558805598336', '26906', '1', '广东省 广州市 番禺区 大龙街清河东路美心翡翠明庭4座2梯804', 'ems', 'EJ512726765JP', '2016-07-23 07:02:19'),('2', '640860250144897', '27337', '1', '浙江省 宁波市 江东区 百丈东路819弄华侨城30号402', 'ems', 'EJ512726709JP', '2016-07-23 07:02:19'),('2', '635147123589248', '26811', '1', '北京市 北京市 昌平区 北京市昌平区北七家天权路金色漫香苑9栋1-702', 'ems', 'EJ512726880JP', '2016-07-23 07:02:19'),('2', '635055819128960', '26777', '1', '浙江省 台州市 路桥区 秀水铭苑一期北大门G11幢一单元', 'ems', 'EJ512726686JP', '2016-07-23 07:02:19'),('2', '639631860367489', '27169', '1', '江苏省 镇江市 句容市 开发区梅花小区18幢201', 'ems', 'EJ512727443JP', '2016-07-23 07:02:19'),('2', '639617446314112', '27171', '1', '广东省 广州市 天河区 兴民路168号利雅湾B2－1601', 'ems', 'EJ512727338JP', '2016-07-23 07:02:19'),('2', '639822214463616', '27187', '1', '北京市 北京市 朝阳区 科荟路51号院美伦堡小区5--1--1302', 'ems', 'EJ512726933JP', '2016-07-23 07:02:19'),('2', '633941675802752', '26700', '1', '福建省 泉州市 丰泽区 新华北路中骏西湖一号10#1803', 'ems', 'EJ512726831JP', '2016-07-23 07:02:19'),('2', '323446935257344', '3263', '1', '黑龙江省 哈尔滨市 南岗区 哈西大街117号辰能溪树庭院A14栋2单元301', 'ems', 'EJ470091083JP', '2016-07-23 07:02:19');
*/

echo "<hr/><p>END</p>";

function getSql($conn, $sql, $createTime)
{
	$succ	= 0;
	$kuaidi100DataSql	= '';
	$query	= mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($query))
	{
		if( !empty($row['orderId']) && !empty($row['procureId']) && !empty($row['outExpressNo']) )
		{
			$succ+=1;
			$address			= getOrderAddress($conn, $row['orderId']);
			$kuaidi100DataSql	.= "('2', '{$row['orderId']}', '{$row['procureId']}', '1', '{$address}', 'ems', '{$row['outExpressNo']}', '{$createTime}'),";
		}
		else
		{
			echo "<p>异常：" . json_encode($row) . "</p>";
		}
	}
	echo "<p>成功： {$succ}</p>";
	return $kuaidi100DataSql;
}

function getOrderAddress($conn, $orderId)
{
	$address	= '';
	$orderSql	= "SELECT orderId,address,userId FROM `bbt_order` WHERE `orderId`='{$orderId}' ORDER BY `createTime` DESC LIMIT 1;";
	$orderQuery	= mysqli_query($conn, $orderSql);
	while ($orderInfo = mysqli_fetch_assoc($orderQuery))
	{
		$address	= !empty($orderInfo['address']) ? $orderInfo['address'] : '';
	}
	return $address;
}



