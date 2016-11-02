<?php 
/**
 *	@desc	修复出库回调，transferId数据没有写入的BUG。
 *			这里生成一条sql语句
 *			http://test.study.com/bbt/repireExpressCallback.php
*/
echo '<pre>';
/*$conn	= mysqli_connect('online-slave-02.c9qvc7ixh1mw.rds.cn-north-1.amazonaws.com.cn:3396', 'root', '0f55921d37ecd11333bbf56f2dc2ae73');
if( !$conn )
{
	exit('<hr/> conn fail! ');
}

mysqli_set_charset('UTF8');
mysqli_select_db('bbt', $conn);*/

$fileListStr	= 'apiSendStockOut.log.2016080204 apiSendStockOut.log.2016080205 apiSendStockOut.log.2016080207 apiSendStockOut.log.2016080208 apiSendStockOut.log.2016080209 apiSendStockOut.log.2016080210 apiSendStockOut.log.2016080211 apiSendStockOut.log.2016080213 apiSendStockOut.log.2016080216 apiSendStockOut.log.2016080218 apiSendStockOut.log.2016080222 apiSendStockOut.log.2016080223 apiSendStockOut.log.2016080301 apiSendStockOut.log.2016080302 apiSendStockOut.log.2016080303 apiSendStockOut.log.2016080305 apiSendStockOut.log.2016080306 apiSendStockOut.log.2016080307 apiSendStockOut.log.2016080309 apiSendStockOut.log.2016080311 apiSendStockOut.log.2016080313 apiSendStockOut.log.2016080315 apiSendStockOut.log.2016080321 apiSendStockOut.log.2016080323 apiSendStockOut.log.2016080401 apiSendStockOut.log.2016080403 apiSendStockOut.log.2016080404 apiSendStockOut.log.2016080406 apiSendStockOut.log.2016080407 apiSendStockOut.log.2016080408 apiSendStockOut.log.2016080409 apiSendStockOut.log.2016080410 apiSendStockOut.log.2016080411 apiSendStockOut.log.2016080417 apiSendStockOut.log.2016080418 apiSendStockOut.log.2016080423 apiSendStockOut.log.2016080501 apiSendStockOut.log.2016080502 apiSendStockOut.log.2016080503 apiSendStockOut.log.2016080506 apiSendStockOut.log.2016080507 apiSendStockOut.log.2016080508 apiSendStockOut.log.2016080509 apiSendStockOut.log.2016080510 apiSendStockOut.log.2016080513 apiSendStockOut.log.2016080514 apiSendStockOut.log.2016080515 apiSendStockOut.log.2016080516 apiSendStockOut.log.2016080517 apiSendStockOut.log.2016080523 apiSendStockOut.log.2016080601 apiSendStockOut.log.2016080602 apiSendStockOut.log.2016080603 apiSendStockOut.log.2016080605 apiSendStockOut.log.2016080607 apiSendStockOut.log.2016080609 apiSendStockOut.log.2016080611 apiSendStockOut.log.2016080612 apiSendStockOut.log.2016080613 apiSendStockOut.log.2016080614 apiSendStockOut.log.2016080615 apiSendStockOut.log.2016080616 apiSendStockOut.log.2016080623 apiSendStockOut.log.2016080701 apiSendStockOut.log.2016080702 apiSendStockOut.log.2016080704 apiSendStockOut.log.2016080707 apiSendStockOut.log.2016080708 apiSendStockOut.log.2016080709 apiSendStockOut.log.2016080710 apiSendStockOut.log.2016080717 apiSendStockOut.log.2016080723 apiSendStockOut.log.2016080801 apiSendStockOut.log.2016080802 apiSendStockOut.log.2016080803';

$updSql			= [];
$fileListArr	= explode(" ", $fileListStr);
foreach ($fileListArr as $key => $fileName)
{
	$fileContent	= file_get_contents( '/Users/cntnn11/www/webwork/bonbon/worklog/20160808_物流回调BUG修改/' . $fileName);
	$fileContentList= explode("\n", $fileContent);
	foreach ($fileContentList as $content)
	{
		$content		= str_replace([" ", "\s"], " ", $content);
		$fileContentArr	= explode(" ", $content);
		if( !empty($fileContentArr[6]) )
		{
			$jsonDataArr	= json_decode($fileContentArr[6], true);
			foreach ($jsonDataArr as $stockflow)
			{
				$updSql[$stockflow['stock_id']]	= " UPDATE `stock_flow` SET `transferId`='{$stockflow['transfer_id']}' WHERE `id`={$stockflow['stock_id']};";
			}
		}
	}

}

echo implode("\n", $updSql);

/*UPDATE `stock_flow` SET `transferId`='0996839557' WHERE `id`=65514;
UPDATE `stock_flow` SET `transferId`='1978755291' WHERE `id`=65522;
UPDATE `stock_flow` SET `transferId`='0694364329' WHERE `id`=65524;
UPDATE `stock_flow` SET `transferId`='2143614729' WHERE `id`=65536;
UPDATE `stock_flow` SET `transferId`='1996835328' WHERE `id`=65538;
UPDATE `stock_flow` SET `transferId`='1207176181' WHERE `id`=65540;
UPDATE `stock_flow` SET `transferId`='1336220156' WHERE `id`=65628;
UPDATE `stock_flow` SET `transferId`='0119262183' WHERE `id`=65630;
UPDATE `stock_flow` SET `transferId`='1071752678' WHERE `id`=65632;
UPDATE `stock_flow` SET `transferId`='1006268208' WHERE `id`=65634;
UPDATE `stock_flow` SET `transferId`='0410374629' WHERE `id`=65636;
UPDATE `stock_flow` SET `transferId`='0083500754' WHERE `id`=65664;
UPDATE `stock_flow` SET `transferId`='1432656072' WHERE `id`=65668;
UPDATE `stock_flow` SET `transferId`='1017414449' WHERE `id`=65684;
UPDATE `stock_flow` SET `transferId`='1473493720' WHERE `id`=65686;
UPDATE `stock_flow` SET `transferId`='0113159241' WHERE `id`=65694;
UPDATE `stock_flow` SET `transferId`='0143822234' WHERE `id`=65696;
UPDATE `stock_flow` SET `transferId`='0465561292' WHERE `id`=65698;
UPDATE `stock_flow` SET `transferId`='0676245871' WHERE `id`=65716;
UPDATE `stock_flow` SET `transferId`='0632415533' WHERE `id`=65722;
UPDATE `stock_flow` SET `transferId`='1476486436' WHERE `id`=65724;
UPDATE `stock_flow` SET `transferId`='1998560489' WHERE `id`=65726;
UPDATE `stock_flow` SET `transferId`='1782505565' WHERE `id`=65728;
UPDATE `stock_flow` SET `transferId`='0700266391' WHERE `id`=65730;
UPDATE `stock_flow` SET `transferId`='0280952824' WHERE `id`=65732;
UPDATE `stock_flow` SET `transferId`='1551078831' WHERE `id`=65734;
UPDATE `stock_flow` SET `transferId`='0961048788' WHERE `id`=65746;
UPDATE `stock_flow` SET `transferId`='1726970731' WHERE `id`=65748;
UPDATE `stock_flow` SET `transferId`='1960105154' WHERE `id`=65796;
UPDATE `stock_flow` SET `transferId`='1347803099' WHERE `id`=65798;
UPDATE `stock_flow` SET `transferId`='1890503812' WHERE `id`=65800;
UPDATE `stock_flow` SET `transferId`='0231467405' WHERE `id`=65802;
UPDATE `stock_flow` SET `transferId`='0592458864' WHERE `id`=65804;
UPDATE `stock_flow` SET `transferId`='0176230791' WHERE `id`=65810;
UPDATE `stock_flow` SET `transferId`='0488776517' WHERE `id`=65814;
UPDATE `stock_flow` SET `transferId`='0748386021' WHERE `id`=65818;
UPDATE `stock_flow` SET `transferId`='2138496551' WHERE `id`=65820;
UPDATE `stock_flow` SET `transferId`='0188292190' WHERE `id`=66044;
UPDATE `stock_flow` SET `transferId`='0537439972' WHERE `id`=66046;
UPDATE `stock_flow` SET `transferId`='0765417244' WHERE `id`=66048;
UPDATE `stock_flow` SET `transferId`='0952392267' WHERE `id`=66050;
UPDATE `stock_flow` SET `transferId`='1269331442' WHERE `id`=66052;
UPDATE `stock_flow` SET `transferId`='0065707435' WHERE `id`=66054;
UPDATE `stock_flow` SET `transferId`='1680753215' WHERE `id`=66056;
UPDATE `stock_flow` SET `transferId`='1941177984' WHERE `id`=66058;
UPDATE `stock_flow` SET `transferId`='1857143536' WHERE `id`=66060;
UPDATE `stock_flow` SET `transferId`='0178021566' WHERE `id`=66098;
UPDATE `stock_flow` SET `transferId`='1793709202' WHERE `id`=66150;
UPDATE `stock_flow` SET `transferId`='0505613549' WHERE `id`=66162;
UPDATE `stock_flow` SET `transferId`='0583787855' WHERE `id`=66216;
UPDATE `stock_flow` SET `transferId`='0648315259' WHERE `id`=66240;
UPDATE `stock_flow` SET `transferId`='1403617759' WHERE `id`=66295;
UPDATE `stock_flow` SET `transferId`='1608494491' WHERE `id`=66323;
UPDATE `stock_flow` SET `transferId`='1674473870' WHERE `id`=66325;
UPDATE `stock_flow` SET `transferId`='0740290510' WHERE `id`=66331;
UPDATE `stock_flow` SET `transferId`='1725050583' WHERE `id`=66333;
UPDATE `stock_flow` SET `transferId`='1095798638' WHERE `id`=66375;
UPDATE `stock_flow` SET `transferId`='0095425719' WHERE `id`=66401;
UPDATE `stock_flow` SET `transferId`='1390766423' WHERE `id`=66403;
UPDATE `stock_flow` SET `transferId`='0821162608' WHERE `id`=66407;
UPDATE `stock_flow` SET `transferId`='0220628541' WHERE `id`=66413;
UPDATE `stock_flow` SET `transferId`='0565507155' WHERE `id`=66447;
UPDATE `stock_flow` SET `transferId`='0458860610' WHERE `id`=66469;
UPDATE `stock_flow` SET `transferId`='0084871165' WHERE `id`=66487;
UPDATE `stock_flow` SET `transferId`='2068151702' WHERE `id`=66489;
UPDATE `stock_flow` SET `transferId`='0353797649' WHERE `id`=66491;
UPDATE `stock_flow` SET `transferId`='1136237916' WHERE `id`=66493;
UPDATE `stock_flow` SET `transferId`='1876987270' WHERE `id`=66495;
UPDATE `stock_flow` SET `transferId`='0279613194' WHERE `id`=64157;
UPDATE `stock_flow` SET `transferId`='1550276794' WHERE `id`=66405;
UPDATE `stock_flow` SET `transferId`='1773782109' WHERE `id`=66515;
UPDATE `stock_flow` SET `transferId`='0281623249' WHERE `id`=66521;
UPDATE `stock_flow` SET `transferId`='0267769778' WHERE `id`=66537;
UPDATE `stock_flow` SET `transferId`='0333509064' WHERE `id`=63825;
UPDATE `stock_flow` SET `transferId`='1230216854' WHERE `id`=66547;
UPDATE `stock_flow` SET `transferId`='2019150679' WHERE `id`=66583;
UPDATE `stock_flow` SET `transferId`='0406507801' WHERE `id`=64187;
UPDATE `stock_flow` SET `transferId`='1907671610' WHERE `id`=66591;
UPDATE `stock_flow` SET `transferId`='0581896858' WHERE `id`=66593;
UPDATE `stock_flow` SET `transferId`='0831105785' WHERE `id`=66609;
UPDATE `stock_flow` SET `transferId`='1531479150' WHERE `id`=66615;
UPDATE `stock_flow` SET `transferId`='0873455801' WHERE `id`=66623;
UPDATE `stock_flow` SET `transferId`='0308514947' WHERE `id`=66633;
UPDATE `stock_flow` SET `transferId`='0558024791' WHERE `id`=66635;
UPDATE `stock_flow` SET `transferId`='1337341207' WHERE `id`=66637;
UPDATE `stock_flow` SET `transferId`='1825184432' WHERE `id`=66639;
UPDATE `stock_flow` SET `transferId`='1760928156' WHERE `id`=66657;
UPDATE `stock_flow` SET `transferId`='1206478601' WHERE `id`=66659;
UPDATE `stock_flow` SET `transferId`='0517745676' WHERE `id`=66665;
UPDATE `stock_flow` SET `transferId`='1009946900' WHERE `id`=66667;
UPDATE `stock_flow` SET `transferId`='2038897511' WHERE `id`=66669;
UPDATE `stock_flow` SET `transferId`='1655482826' WHERE `id`=66671;
UPDATE `stock_flow` SET `transferId`='0446367516' WHERE `id`=66673;
UPDATE `stock_flow` SET `transferId`='1621307208' WHERE `id`=66675;
UPDATE `stock_flow` SET `transferId`='1068257234' WHERE `id`=66695;
UPDATE `stock_flow` SET `transferId`='0378049744' WHERE `id`=66699;
UPDATE `stock_flow` SET `transferId`='1516559982' WHERE `id`=66701;
UPDATE `stock_flow` SET `transferId`='1502652399' WHERE `id`=66705;
UPDATE `stock_flow` SET `transferId`='1369471199' WHERE `id`=66709;
UPDATE `stock_flow` SET `transferId`='1909974589' WHERE `id`=66711;
UPDATE `stock_flow` SET `transferId`='0087600093' WHERE `id`=66713;
UPDATE `stock_flow` SET `transferId`='0420136129' WHERE `id`=66715;
UPDATE `stock_flow` SET `transferId`='1255610615' WHERE `id`=66703;
UPDATE `stock_flow` SET `transferId`='0640489777' WHERE `id`=66782;
UPDATE `stock_flow` SET `transferId`='0659293844' WHERE `id`=66784;
UPDATE `stock_flow` SET `transferId`='1062063716' WHERE `id`=66800;
UPDATE `stock_flow` SET `transferId`='0423335806' WHERE `id`=66802;
UPDATE `stock_flow` SET `transferId`='0450943643' WHERE `id`=66892;
UPDATE `stock_flow` SET `transferId`='0939462815' WHERE `id`=66896;
UPDATE `stock_flow` SET `transferId`='1162570155' WHERE `id`=66878;
UPDATE `stock_flow` SET `transferId`='1090834457' WHERE `id`=66794;
UPDATE `stock_flow` SET `transferId`='1573090776' WHERE `id`=66796;
UPDATE `stock_flow` SET `transferId`='1052659124' WHERE `id`=66798;
UPDATE `stock_flow` SET `transferId`='0824939097' WHERE `id`=66808;
UPDATE `stock_flow` SET `transferId`='0085187359' WHERE `id`=66846;
UPDATE `stock_flow` SET `transferId`='0299335326' WHERE `id`=66854;
UPDATE `stock_flow` SET `transferId`='0383605776' WHERE `id`=66866;
UPDATE `stock_flow` SET `transferId`='1840575549' WHERE `id`=66872;
UPDATE `stock_flow` SET `transferId`='0880578438' WHERE `id`=66876;
UPDATE `stock_flow` SET `transferId`='0546001179' WHERE `id`=66898;
UPDATE `stock_flow` SET `transferId`='0376673371' WHERE `id`=66916;
UPDATE `stock_flow` SET `transferId`='1142391246' WHERE `id`=66379;
UPDATE `stock_flow` SET `transferId`='0673303542' WHERE `id`=66441;
UPDATE `stock_flow` SET `transferId`='0705370311' WHERE `id`=66471;
UPDATE `stock_flow` SET `transferId`='1298033973' WHERE `id`=66651;
UPDATE `stock_flow` SET `transferId`='0877972290' WHERE `id`=66733;
UPDATE `stock_flow` SET `transferId`='1574755525' WHERE `id`=66759;
UPDATE `stock_flow` SET `transferId`='1911741471' WHERE `id`=66790;
UPDATE `stock_flow` SET `transferId`='1014444354' WHERE `id`=66792;
UPDATE `stock_flow` SET `transferId`='1927954368' WHERE `id`=66926;
UPDATE `stock_flow` SET `transferId`='0120402570' WHERE `id`=66928;
UPDATE `stock_flow` SET `transferId`='1414716130' WHERE `id`=66930;
UPDATE `stock_flow` SET `transferId`='1052331217' WHERE `id`=67064;
UPDATE `stock_flow` SET `transferId`='1692679110' WHERE `id`=67074;
UPDATE `stock_flow` SET `transferId`='1211965845' WHERE `id`=67076;
UPDATE `stock_flow` SET `transferId`='0315407107' WHERE `id`=64433;
UPDATE `stock_flow` SET `transferId`='0657996152' WHERE `id`=64445;
UPDATE `stock_flow` SET `transferId`='0131935468' WHERE `id`=64455;
UPDATE `stock_flow` SET `transferId`='1340141814' WHERE `id`=64461;
UPDATE `stock_flow` SET `transferId`='1605849242' WHERE `id`=64473;
UPDATE `stock_flow` SET `transferId`='1921294092' WHERE `id`=64479;
UPDATE `stock_flow` SET `transferId`='1632327200' WHERE `id`=64523;
UPDATE `stock_flow` SET `transferId`='1802890247' WHERE `id`=67078;
UPDATE `stock_flow` SET `transferId`='0923239881' WHERE `id`=67084;
UPDATE `stock_flow` SET `transferId`='0888083828' WHERE `id`=67090;
UPDATE `stock_flow` SET `transferId`='0381156088' WHERE `id`=67112;
UPDATE `stock_flow` SET `transferId`='1110677966' WHERE `id`=67116;
UPDATE `stock_flow` SET `transferId`='2071443425' WHERE `id`=67126;
UPDATE `stock_flow` SET `transferId`='1873736370' WHERE `id`=67128;
UPDATE `stock_flow` SET `transferId`='0795598908' WHERE `id`=67130;
UPDATE `stock_flow` SET `transferId`='0066662423' WHERE `id`=67134;
UPDATE `stock_flow` SET `transferId`='1648771819' WHERE `id`=67136;
UPDATE `stock_flow` SET `transferId`='1821368773' WHERE `id`=67138;
UPDATE `stock_flow` SET `transferId`='0474913855' WHERE `id`=67142;
UPDATE `stock_flow` SET `transferId`='0197417502' WHERE `id`=67144;
UPDATE `stock_flow` SET `transferId`='1183495766' WHERE `id`=67170;
UPDATE `stock_flow` SET `transferId`='0369896393' WHERE `id`=67190;
UPDATE `stock_flow` SET `transferId`='0731651215' WHERE `id`=67196;
UPDATE `stock_flow` SET `transferId`='1669826186' WHERE `id`=67202;
UPDATE `stock_flow` SET `transferId`='1111314178' WHERE `id`=67204;
UPDATE `stock_flow` SET `transferId`='1671809773' WHERE `id`=67206;
UPDATE `stock_flow` SET `transferId`='0172666666' WHERE `id`=67208;
UPDATE `stock_flow` SET `transferId`='0084068252' WHERE `id`=67212;
UPDATE `stock_flow` SET `transferId`='2024678100' WHERE `id`=67218;
UPDATE `stock_flow` SET `transferId`='0804268785' WHERE `id`=67220;
UPDATE `stock_flow` SET `transferId`='0319055358' WHERE `id`=67222;
UPDATE `stock_flow` SET `transferId`='1649430150' WHERE `id`=67224;
UPDATE `stock_flow` SET `transferId`='1970700647' WHERE `id`=67230;
UPDATE `stock_flow` SET `transferId`='1821718710' WHERE `id`=67306;
UPDATE `stock_flow` SET `transferId`='1328706664' WHERE `id`=67312;
UPDATE `stock_flow` SET `transferId`='2127503063' WHERE `id`=67314;
UPDATE `stock_flow` SET `transferId`='0812100660' WHERE `id`=67318;
UPDATE `stock_flow` SET `transferId`='0985533989' WHERE `id`=67344;
UPDATE `stock_flow` SET `transferId`='1771054042' WHERE `id`=67352;
UPDATE `stock_flow` SET `transferId`='0070844079' WHERE `id`=67358;
UPDATE `stock_flow` SET `transferId`='1687100960' WHERE `id`=67378;
UPDATE `stock_flow` SET `transferId`='1828771139' WHERE `id`=67382;
UPDATE `stock_flow` SET `transferId`='1712000098' WHERE `id`=67386;
UPDATE `stock_flow` SET `transferId`='1676591358' WHERE `id`=67424;
UPDATE `stock_flow` SET `transferId`='1950516368' WHERE `id`=67428;
UPDATE `stock_flow` SET `transferId`='0085395584' WHERE `id`=67436;
UPDATE `stock_flow` SET `transferId`='1243286371' WHERE `id`=67438;
UPDATE `stock_flow` SET `transferId`='0432562494' WHERE `id`=67440;
UPDATE `stock_flow` SET `transferId`='1959470561' WHERE `id`=67442;
UPDATE `stock_flow` SET `transferId`='0928183053' WHERE `id`=67444;
UPDATE `stock_flow` SET `transferId`='0061804477' WHERE `id`=67446;
UPDATE `stock_flow` SET `transferId`='1435296655' WHERE `id`=67448;
UPDATE `stock_flow` SET `transferId`='0112086167' WHERE `id`=67450;
UPDATE `stock_flow` SET `transferId`='1680576006' WHERE `id`=67452;
UPDATE `stock_flow` SET `transferId`='1064990648' WHERE `id`=67454;
UPDATE `stock_flow` SET `transferId`='1679331192' WHERE `id`=67458;
UPDATE `stock_flow` SET `transferId`='1327239017' WHERE `id`=67460;
UPDATE `stock_flow` SET `transferId`='0301929293' WHERE `id`=67478;
UPDATE `stock_flow` SET `transferId`='0653131918' WHERE `id`=67482;
UPDATE `stock_flow` SET `transferId`='1375729486' WHERE `id`=67484;
UPDATE `stock_flow` SET `transferId`='0416073996' WHERE `id`=67486;
UPDATE `stock_flow` SET `transferId`='0424198240' WHERE `id`=67488;
UPDATE `stock_flow` SET `transferId`='1094103600' WHERE `id`=67490;
UPDATE `stock_flow` SET `transferId`='1795656738' WHERE `id`=67492;
UPDATE `stock_flow` SET `transferId`='1745064317' WHERE `id`=67494;
UPDATE `stock_flow` SET `transferId`='1276223280' WHERE `id`=67496;
UPDATE `stock_flow` SET `transferId`='1797776809' WHERE `id`=67498;
UPDATE `stock_flow` SET `transferId`='2039753048' WHERE `id`=67510;
UPDATE `stock_flow` SET `transferId`='1297067547' WHERE `id`=67520;
UPDATE `stock_flow` SET `transferId`='1762806442' WHERE `id`=67524;
UPDATE `stock_flow` SET `transferId`='1219838171' WHERE `id`=67539;
UPDATE `stock_flow` SET `transferId`='1029216908' WHERE `id`=67541;
UPDATE `stock_flow` SET `transferId`='1400851161' WHERE `id`=67543;
UPDATE `stock_flow` SET `transferId`='1590124715' WHERE `id`=67545;
UPDATE `stock_flow` SET `transferId`='1560195809' WHERE `id`=67547;
UPDATE `stock_flow` SET `transferId`='0456177475' WHERE `id`=67549;
UPDATE `stock_flow` SET `transferId`='0821069980' WHERE `id`=67551;
UPDATE `stock_flow` SET `transferId`='0452079162' WHERE `id`=67553;
UPDATE `stock_flow` SET `transferId`='0627434609' WHERE `id`=67555;
UPDATE `stock_flow` SET `transferId`='2073809678' WHERE `id`=67557;
UPDATE `stock_flow` SET `transferId`='0107240686' WHERE `id`=67559;
UPDATE `stock_flow` SET `transferId`='1344745544' WHERE `id`=67561;
UPDATE `stock_flow` SET `transferId`='0581139203' WHERE `id`=67563;
UPDATE `stock_flow` SET `transferId`='1602187183' WHERE `id`=67565;
UPDATE `stock_flow` SET `transferId`='1913230704' WHERE `id`=67567;
UPDATE `stock_flow` SET `transferId`='1943447137' WHERE `id`=67569;
UPDATE `stock_flow` SET `transferId`='1801506894' WHERE `id`=67571;
UPDATE `stock_flow` SET `transferId`='1489217635' WHERE `id`=67573;
UPDATE `stock_flow` SET `transferId`='1933064381' WHERE `id`=67575;
UPDATE `stock_flow` SET `transferId`='2110713077' WHERE `id`=67577;
UPDATE `stock_flow` SET `transferId`='0471090052' WHERE `id`=67587;
UPDATE `stock_flow` SET `transferId`='1424265870' WHERE `id`=67605;
UPDATE `stock_flow` SET `transferId`='0365083540' WHERE `id`=67695;
UPDATE `stock_flow` SET `transferId`='1411033803' WHERE `id`=67697;
UPDATE `stock_flow` SET `transferId`='1995601129' WHERE `id`=67701;
UPDATE `stock_flow` SET `transferId`='0050871739' WHERE `id`=67703;
UPDATE `stock_flow` SET `transferId`='0242780307' WHERE `id`=67739;
UPDATE `stock_flow` SET `transferId`='1777338708' WHERE `id`=67763;
UPDATE `stock_flow` SET `transferId`='0469909124' WHERE `id`=67765;
UPDATE `stock_flow` SET `transferId`='1844185207' WHERE `id`=67767;
UPDATE `stock_flow` SET `transferId`='1584053195' WHERE `id`=67777;
UPDATE `stock_flow` SET `transferId`='1859580407' WHERE `id`=67779;
UPDATE `stock_flow` SET `transferId`='1161283511' WHERE `id`=67815;
UPDATE `stock_flow` SET `transferId`='1236203145' WHERE `id`=67817;
UPDATE `stock_flow` SET `transferId`='0769613276' WHERE `id`=67835;
UPDATE `stock_flow` SET `transferId`='0786010417' WHERE `id`=67837;
UPDATE `stock_flow` SET `transferId`='1998746267' WHERE `id`=67839;
UPDATE `stock_flow` SET `transferId`='0472832792' WHERE `id`=67841;
UPDATE `stock_flow` SET `transferId`='1258824353' WHERE `id`=67843;
UPDATE `stock_flow` SET `transferId`='0969304538' WHERE `id`=67845;
UPDATE `stock_flow` SET `transferId`='1870439999' WHERE `id`=67847;
UPDATE `stock_flow` SET `transferId`='0258703210' WHERE `id`=67851;
UPDATE `stock_flow` SET `transferId`='1371511275' WHERE `id`=67861;
UPDATE `stock_flow` SET `transferId`='1664989685' WHERE `id`=64149;
UPDATE `stock_flow` SET `transferId`='1248049796' WHERE `id`=64153;
UPDATE `stock_flow` SET `transferId`='0786259703' WHERE `id`=67945;
UPDATE `stock_flow` SET `transferId`='1119295113' WHERE `id`=67951;
UPDATE `stock_flow` SET `transferId`='1931303301' WHERE `id`=67953;
UPDATE `stock_flow` SET `transferId`='1347051696' WHERE `id`=65414;
UPDATE `stock_flow` SET `transferId`='0871304337' WHERE `id`=67961;
UPDATE `stock_flow` SET `transferId`='1133050915' WHERE `id`=67963;
UPDATE `stock_flow` SET `transferId`='1749394351' WHERE `id`=67985;
UPDATE `stock_flow` SET `transferId`='0723400433' WHERE `id`=67991;*/

