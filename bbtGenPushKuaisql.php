<?php
// 查询订单相关的数据 procureId,orderId,pushStatus,address,kuaiCode,expressNo,type
// http://test.study.com/bbtGenPushKuaisql.php
error_reporting(E_ALL);
/********** 2016-06-30 *************/
// 由物流人员出库后给出
$orderExpressArr	= [
	'584188609953920'=>'973243933794',
	'585706567565440'=>'973243934692',
	'585709645627520'=>'973243934568',
	'585931551146112'=>'973243934107',
	'585885968793728'=>'973243933800',
	'586035933708416'=>'973243935087',
	'586049233813633'=>'973243935351',
	'586081274265728'=>'973243934707',
	'586189738475648'=>'973243936715',
	'586661419483264'=>'973243934868',
	'586939244609664'=>'973243935281',
	'586943684640896'=>'973243935827',
	'586961359863936'=>'973243936812',
	'587014177554561'=>'973243936919',
	'587174502269056'=>'973243935193',
	'587273325510784'=>'973243935572',
	'588418966716544'=>'973243935775',
	'588318720163968'=>'973243935360',
	'588512272646272'=>'973243935102',
	'588215330799744'=>'973243934877',
	'588524781305984'=>'973243935924',
	'588549173870721'=>'973243936063',
	'588901341102208'=>'973243935784',
	'588922645708928'=>'973243936937',
];

// 通过sql查询、二次处理得出
// select procureId, orderId, 1 as pushStatus, address, 'shunfeng' as kuaiCode, '' as expressNo, '0' as type from bbt_order where orderId IN (584188609953920,585706567565440,585709645627520,585931551146112,585885968793728,586035933708416,586049233813633,586081274265728,586189738475648,586661419483264,586939244609664,586943684640896,586961359863936,587014177554561,587174502269056,587273325510784,588418966716544,588318720163968,588512272646272,588215330799744,588524781305984,588549173870721,588901341102208,588922645708928);
$rowArr	= [
	'     20519 | 584188609953920 |          1 | 上海市 上海市 嘉定区 丰庄西路433弄13号502                                            | shunfeng |           | 0    ',
	'     20982 | 585706567565440 |          1 | 广东省 广州市 白云区 金沙洲万科路星汇金沙一期速递易                                  | shunfeng |           | 0    ',
	'     20985 | 585709645627520 |          1 | 河南省 南阳市 卧龙区 车站南路建业绿色家园                                            | shunfeng |           | 0    ',
	'     21034 | 585885968793728 |          1 | 浙江省 温州市 瓯海区 娄桥街道洲洋路瓯海法院713室                                     | shunfeng |           | 0    ',
	'     21055 | 585931551146112 |          1 | 辽宁省 沈阳市 和平区 昆明北街11-2号241                                               | shunfeng |           | 0    ',
	'     21096 | 586035933708416 |          1 | 河南省 郑州市 金水区 纬五路13号院6号楼157号                                          | shunfeng |           | 0    ',
	'     21101 | 586049233813633 |          1 | 北京市 北京市 丰台区 马家楼路一号院青秀城西区22号楼3单元601                          | shunfeng |           | 0    ',
	'     21111 | 586081274265728 |          1 | 北京市 北京市 海淀区 车公庄西路14号                                                  | shunfeng |           | 0    ',
	'     21151 | 586189738475648 |          1 | 江苏省 南京市 江宁区 天元中路68号东渡青年城9栋1706                                   | shunfeng |           | 0    ',
	'     21300 | 586661419483264 |          1 | 广东省 广州市 天河区 华景新城信华花园5栋2001房                                       | shunfeng |           | 0    ',
	'     21405 | 586939244609664 |          1 | 上海市 上海市 宝山区 华灵路680弄29号501室                                            | shunfeng |           | 0    ',
	'     21406 | 586943684640896 |          1 | 重庆市 重庆市 江北区 鲤鱼池一村62号15-3号                                            | shunfeng |           | 0    ',
	'     21416 | 586961359863936 |          1 | 北京市 北京市 大兴区 康庄路9号                                                       | shunfeng |           | 0    ',
	'     21431 | 587014177554561 |          1 | 浙江省 宁波市 镇海区 东昌路886号（盛达仓储旁）                                       | shunfeng |           | 0    ',
	'     21482 | 587174502269056 |          1 | 上海市 上海市 卢湾区 瑞金南路333弄5号1102室                                          | shunfeng |           | 0    ',
	'     21499 | 587273325510784 |          1 | 福建省 福州市 台江区 五一中路26号电信大楼                                            | shunfeng |           | 0    ',
	'     21543 | 588215330799744 |          1 | 江苏省 苏州市 沧浪区 劳动路金品家园12幢704                                           | shunfeng |           | 0    ',
	'     21562 | 588318720163968 |          1 | 北京市 北京市 通州区 马驹桥宏仁家园3号楼1单元2301                                    | shunfeng |           | 0    ',
	'     21591 | 588418966716544 |          1 | 上海市 上海市 普陀区 洛川路8号501室                                                  | shunfeng |           | 0    ',
	'     21621 | 588512272646272 |          1 | 北京市 北京市 朝阳区 西坝河西里11号楼1106                                            | shunfeng |           | 0    ',
	'     21630 | 588524781305984 |          1 | 浙江省 杭州市 西湖区 教工路18号欧美中心EAC大厦A座C区1701室                           | shunfeng |           | 0    ',
	'     21639 | 588549173870721 |          1 | 广东省 广州市 天河区 黄埔大道中翠湖山庄13号1202                                      | shunfeng |           | 0    ',
	'     21711 | 588901341102208 |          1 | 广东省 广州市 越秀区 大德路111号广东省中医院负二层中药仓库                           | shunfeng |           | 0    ',
	'     21720 | 588922645708928 |          1 | 江苏省 南京市 建邺区 嵩山路128号万达华府西苑1-601                                    | shunfeng |           | 0    ',
];

/********** 2016-07-03 *************/
$orderExpressArr	= [
	//'588504515281024'=>'973250772261',
	//'592550352978049'=>'973250773044',
	//'591896679317632'=>'973250772482',
	//'584021011726464'=>'973250770792',
	'582699422810240'=>'973250770701',
	'584066882797696'=>'973250772340',
	'583397373116544'=>'973250771009',
	'583362508554369'=>'973250771391',
	'582811578695808'=>'973250773141',
	'582659963781248'=>'973250772155',
	'582544595976320'=>'973250772668',
	'582285208060033'=>'973250772922',
	'581554570985600'=>'973250772164',
	'600279854514304'=>'973250807424',
	'583049530638464'=>'973250806817',
	'583045193138304'=>'973250806332',
	'582716308488320'=>'973250805692',
	'582643948978304'=>'973250807937',
	'582617493602432'=>'973250807276',
	'582608430497920'=>'973250805956',
	'582596339105920'=>'973250805407',
	'582388554727552'=>'973250806826',
	'597441091534976'=>'973250806701',
	'597252751622272'=>'973250807858',
	'585498908622976'=>'973250807337',
	'584227642998912'=>'973250805707',
	'584191785566336'=>'973250806183',
	'597240126079104'=>'973250816247',
	'597107860177024'=>'973250815270',
	'596943542222976'=>'973250814309',
	'596647932559488'=>'973250814496',
	'592482709667969'=>'973250816034',
	'592420554571904'=>'973250816529',
	'584410198343808'=>'973250815543',
	'584178795741312'=>'973250815473',
	'584151452352640'=>'973250817312',
	'583295613173888'=>'973250815094',
	'581549685145729'=>'973250816810',
	'583863156572288'=>'973250815164',
	'582796504400000'=>'973250815834',
	'582791939063936'=>'973250816344',
	'582764049891456'=>'973250814502',
	'582535545258112'=>'973250816256',
	'582342698893440'=>'973250816635',
	'581621384937600'=>'973250815368',
	'598004486832256'=>'973250829119',
	'597343606308992'=>'973250828432',
	'597188208394368'=>'973250827483',
	'597037237993600'=>'973250829225',
	'596959821496448'=>'973250827987',
	'596740834427009'=>'973250828114',
	'595519162056833'=>'973250828741',
	'586074633470080'=>'973250826876',
	'585674005807233'=>'973250829030',
	'585673529360512'=>'973250828654',
	'597010436980864'=>'973250827747',
	'609473275461760'=>'973250828062',
	'608117366161536'=>'973250827396',
	'598251357601921'=>'973250838374',
	'598211710648448'=>'973250839457',
	'597391435366528'=>'973250836887',
	'585658040287360'=>'973250837500',
	'585592546885760'=>'973250839315',
	'585589104935040'=>'973250838082',
	'601597489348737'=>'973250838656',
	'601438036689024'=>'973250839933',
	'601082869153920'=>'973250837607',
	'600056499634304'=>'973250837185',
	'600195528884352'=>'973250845586',
	'600037602754688'=>'973250846059',
	'599925177548928'=>'973250845073',
	'599866117226624'=>'973250846350',
	'599796254277760'=>'973250845752',
	'599791366635648'=>'973250844697',
	'599726726250624'=>'973250845295',
	'599657120661632'=>'973250845965',
	'599621308317825'=>'973250844881',
	'599140735484032'=>'973250846068',
	'598389613330560'=>'973250845489',
	'598430128636032'=>'973250846729',
	'598368340607104'=>'973250845674',
	'598327358161024'=>'973250844988',
	'597768779071616'=>'973250846271',
	'584121804554368'=>'973250845392',
	'584109031522432'=>'973250846369',
];
// select procureId, orderId, 1 as pushStatus, address, 'shunfeng' as kuaiCode, '' as expressNo, '0' as type from bbt_order where orderId IN (588504515281024,592550352978049,591896679317632,584021011726464,582699422810240,584066882797696,583397373116544,583362508554369,582811578695808,582659963781248,582544595976320,582285208060033,581554570985600,600279854514304,583049530638464,583045193138304,582716308488320,582643948978304,582617493602432,582608430497920,582596339105920,582388554727552,597441091534976,597252751622272,585498908622976,584227642998912,584191785566336,597240126079104,597107860177024,596943542222976,596647932559488,592482709667969,592420554571904,584410198343808,584178795741312,584151452352640,583295613173888,581549685145729,583863156572288,582796504400000,582791939063936,582764049891456,582535545258112,582342698893440,581621384937600,598004486832256,597343606308992,597188208394368,597037237993600,596959821496448,596740834427009,595519162056833,586074633470080,585674005807233,585673529360512,597010436980864,609473275461760,608117366161536,598251357601921,598211710648448,597391435366528,585658040287360,585592546885760,585589104935040,601597489348737,601438036689024,601082869153920,600056499634304,600195528884352,600037602754688,599925177548928,599866117226624,599796254277760,599791366635648,599726726250624,599657120661632,599621308317825,599140735484032,598389613330560,598430128636032,598368340607104,598327358161024,597768779071616,584121804554368,584109031522432,973250846369);
$rowArr	= [
	'19531 | 581549685145729 |          1 | 上海市 上海市 闵行区 古美路675弄7号601                                                                                 | shunfeng |           | 0',
'19542 | 581554570985600 |          1 | 上海市 上海市 浦东新区 金工路172弄52号301室                                                                            | shunfeng |           | 0',
'19595 | 581621384937600 |          1 | 上海市 上海市 黄浦区 局门路361弄2号401室                                                                               | shunfeng |           | 0',
'19681 | 582285208060033 |          1 | 天津市 天津市 南开区 鞍山西道192号天津大学设计研究总院704                                                              | shunfeng |           | 0',
'19695 | 582342698893440 |          1 | 福建省 厦门市 思明区 莲兴路55号1301室                                                                                  | shunfeng |           | 0',
'19710 | 582388554727552 |          1 | 上海市 上海市 卢湾区 瑞金南路333弄5号1102室                                                                            | shunfeng |           | 0',
'19768 | 582535545258112 |          1 | 上海市 上海市 普陀区 石泉东路168弄102号1204                                                                            | shunfeng |           | 0',
'19776 | 582544595976320 |          1 | 北京市 北京市 海淀区 清华大学动振小楼清华电视台107                                                                     | shunfeng |           | 0',
'19809 | 582596339105920 |          1 | 湖南省 永州市 蓝山县 楠市镇曾得和村                                                                                    | shunfeng |           | 0',
'19813 | 582608430497920 |          1 | 北京市 北京市 海淀区 甘家口19号楼1406                                                                                  | shunfeng |           | 0',
'19818 | 582617493602432 |          1 | 北京市 北京市 大兴区 滨河西里小区8号楼1单元101                                                                         | shunfeng |           | 0',
'19835 | 582643948978304 |          1 | 上海市 上海市 普陀区 白丽路185弄25号1001                                                                               | shunfeng |           | 0',
'19848 | 582659963781248 |          1 | 北京市 北京市 大兴区 滨河西里小区8号楼1单元101                                                                         | shunfeng |           | 0',
'19869 | 582699422810240 |          1 | 广东省 广州市 白云区 鹤龙一路208号YH酒店                                                                               | shunfeng |           | 0',
'19876 | 582716308488320 |          1 | 北京市 北京市 海淀区 闵庄路京香花园166号                                                                               | shunfeng |           | 0',
'19901 | 582764049891456 |          1 | 上海市 上海市 长宁区 番禺路483号1604室                                                                                 | shunfeng |           | 0',
'19917 | 582791939063936 |          1 | 上海市 上海市 松江区 九杜路505弄24号1202室                                                                             | shunfeng |           | 0',
'19922 | 582796504400000 |          1 | 天津市 天津市 和平区 新兴街道犀地郎文名邸5号楼2门2902                                                                  | shunfeng |           | 0',
'19929 | 582811578695808 |          1 | 天津市 天津市 河北区 元纬路仁恒河滨花园10-1-1702                                                                       | shunfeng |           | 0',
'20005 | 583045193138304 |          1 | 辽宁省 盘锦市 双台子区 红旗剧场东烧卖羊汤馆                                                                            | shunfeng |           | 0',
'20009 | 583049530638464 |          1 | 四川省 成都市 新都区 翠微路38号香洲半岛13栋221                                                                         | shunfeng |           | 0',
'20124 | 583295613173888 |          1 | 福建省 厦门市 思明区 嘉禾路295号侨旺大厦9D                                                                             | shunfeng |           | 0',
'20134 | 583362508554369 |          1 | 北京市 北京市 东城区 朝阳门北大街3号五矿广场C座307                                                                     | shunfeng |           | 0',
'20151 | 583397373116544 |          1 | 广西壮族自治区 南宁市 良庆区 五象大道438-1号金江新苑6-B                                                                | shunfeng |           | 0',
'20313 | 583863156572288 |          1 | 北京市 北京市 西城区 西直门南小街官苑8号11-1-1007                                                                      | shunfeng |           | 0',
'20369 | 584021011726464 |          1 | 上海市 上海市 徐汇区 漕溪北路331号中金国际广场A座19楼                                                                  | shunfeng |           | 0',
'20396 | 584066882797696 |          1 | 湖南省 衡阳市 蒸湘区 湖南省衡阳市华新开发区采霞街拓兴学府名苑                                                          | shunfeng |           | 0',
'20429 | 584109031522432 |          1 | 山东省 济南市 长清区 凤凰路3999号                                                                                      | shunfeng |           | 0',
'20436 | 584121804554368 |          1 | 浙江省 绍兴市 上虞市 浙江省绍兴市上虞区崧厦镇吕家埠农商银行                                                            | shunfeng |           | 0',
'20470 | 584151452352640 |          1 | 云南省 昆明市 盘龙区 白龙路金色俊园B幢一单元1502                                                                       | shunfeng |           | 0',
'20497 | 584178795741312 |          1 | 北京市 北京市 通州区 芙蓉东路京贸国际城2号楼2单元3904                                                                  | shunfeng |           | 0',
'20531 | 584191785566336 |          1 | 浙江省 台州市 天台县 九龙大道名士苑2幢5单元601                                                                         | shunfeng |           | 0',
'20573 | 584227642998912 |          1 | 广东省 江门市 蓬江区 胜利北路祥和苑9幢之三302                                                                          | shunfeng |           | 0',
'20686 | 584410198343808 |          1 | 上海市 上海市 浦东新区 张杨路2899号3楼大厅36号窗口（邮政大厦，浦东房地产交易中心）                                     | shunfeng |           | 0',
'20864 | 585498908622976 |          1 | 浙江省 杭州市 上城区 中山中路153号                                                                                     | shunfeng |           | 0',
'20914 | 585589104935040 |          1 | 云南省 昆明市 盘龙区 白龙路金色俊园B幢一单元1502                                                                       | shunfeng |           | 0',
'20915 | 585592546885760 |          1 | 天津市 天津市 南开区 秀川路俊城浅水湾28号楼1103                                                                        | shunfeng |           | 0',
'20936 | 585658040287360 |          1 | 山东省 济南市 槐荫区 张家庄600号                                                                                       | shunfeng |           | 0',
'20953 | 585673529360512 |          1 | 江苏省 南京市 鼓楼区 汉口路61号505室                                                                                   | shunfeng |           | 0',
'20956 | 585674005807233 |          1 | 湖南省 长沙市 开福区 四方坪双拥路左岸春天小区35-202                                                                    | shunfeng |           | 0',
'21106 | 586074633470080 |          1 | 上海市 上海市 徐汇区 虹梅路2125弄2号1201室                                                                             | shunfeng |           | 0',
'21619 | 588504515281024 |          1 | 河南省 郑州市 二七区 陇海中路97号陇海星级花园宝居2B                                                                    | shunfeng |           | 0',
'22109 | 591896679317632 |          1 | 上海市 上海市 闵行区 万源路986弄万源城朗郡13号501                                                                      | shunfeng |           | 0',
'22169 | 592420554571904 |          1 | 北京市 北京市 西城区 百万庄大街甲21号院3号楼2门601                                                                     | shunfeng |           | 0',
'22176 | 592482709667969 |          1 | 上海市 上海市 普陀区 洛川路8号501室                                                                                    | shunfeng |           | 0',
'22196 | 592550352978049 |          1 | 北京市 北京市 朝阳区 管庄部队杨闸干休所新楼四单元412                                                                   | shunfeng |           | 0',
'22521 | 595519162056833 |          1 | 广东省 江门市 蓬江区 胜利北路祥和苑9幢之三302                                                                          | shunfeng |           | 0',
'22581 | 596647932559488 |          1 | 浙江省 宁波市 宁海县 丰泽园18幢2202室                                                                                  | shunfeng |           | 0',
'22594 | 596740834427009 |          1 | 湖南省 怀化市 新晃侗族自治县 财政局508                                                                                 | shunfeng |           | 0',
'22623 | 596943542222976 |          1 | 江苏省 苏州市 吴中区 津梁街128号东湖林语26-502                                                                         | shunfeng |           | 0',
'22631 | 596959821496448 |          1 | 上海市 上海市 浦东新区 上南路3339弄89号402                                                                             | shunfeng |           | 0',
'22638 | 597010436980864 |          1 | 上海市 上海市 普陀区 西康路989弄5号2202室                                                                              | shunfeng |           | 0',
'22641 | 597037237993600 |          1 | 北京市 北京市 朝阳区 成寿寺路136号院1号楼2单元1802室                                                                   | shunfeng |           | 0',
'22649 | 597107860177024 |          1 | 浙江省 金华市 义乌市 稠州北路369号7楼713办公室                                                                         | shunfeng |           | 0',
'22660 | 597188208394368 |          1 | 西藏自治区 拉萨市 城关区 西藏拉萨市江苏东路东城新安居园1区5排                                                          | shunfeng |           | 0',
'22667 | 597240126079104 |          1 | 浙江省 绍兴市 新昌县 城南路80号                                                                                        | shunfeng |           | 0',
'22671 | 597252751622272 |          1 | 山东省 临沂市 兰山区 金四路西段 银凤花园 12-1-401                                                                      | shunfeng |           | 0',
'22690 | 597343606308992 |          1 | 河北省 张家口市 宣化区 开发区御景金辉小区                                                                              | shunfeng |           | 0',
'22697 | 597391435366528 |          1 | 江苏省 南京市 江宁区 万达广场B座808                                                                                    | shunfeng |           | 0',
'22707 | 597441091534976 |          1 | 辽宁省 大连市 甘井子区 龙畔金泉五期 泉水K3区33号楼一单元502                                                            | shunfeng |           | 0',
'22768 | 597768779071616 |          1 | 上海市 上海市 徐汇区 上海市徐汇区宾南路36弄（馨逸公寓）1号楼312室                                                      | shunfeng |           | 0',
'22790 | 598004486832256 |          1 | 辽宁省 大连市 沙河口区 连胜街5-4-3-1                                                                                   | shunfeng |           | 0',
'22837 | 598211710648448 |          1 | 广东省 江门市 蓬江区 胜利北路祥和苑9幢之三302                                                                          | shunfeng |           | 0',
'22859 | 598251357601921 |          1 | 广东省 江门市 蓬江区 胜利北路祥和苑9幢之三302                                                                          | shunfeng |           | 0',
'22894 | 598327358161024 |          1 | 北京市 北京市 石景山区 石景山路22号建行一层营业大厅                                                                    | shunfeng |           | 0',
'22899 | 598368340607104 |          1 | 山东省 济南市 历下区 高新区汇展香格里拉北塔2027                                                                        | shunfeng |           | 0',
'22919 | 598389613330560 |          1 | 浙江省 杭州市 萧山区 瓜沥镇（坎山镇）东社村160户                                                                       | shunfeng |           | 0',
'22915 | 598430128636032 |          1 | 北京市 北京市 西城区 茶源路18号戎晖嘉园5-2-1801                                                                        | shunfeng |           | 0',
'22952 | 599140735484032 |          1 | 上海市 上海市 宝山区 长临路1318弄1号1203                                                                               | shunfeng |           | 0',
'23010 | 599621308317825 |          1 | 上海市 上海市 宝山区 顾村镇菊泉街488弄2号401室                                                                         | shunfeng |           | 0',
'23026 | 599657120661632 |          1 | 上海市 上海市 闵行区 罗秀路1339弄4号501室                                                                              | shunfeng |           | 0',
'23076 | 599726726250624 |          1 | 河南省 郑州市 金水区 河南省郑州市郑东新区天赋路26号绿地老街一期9号楼二单元602室                                        | shunfeng |           | 0',
'23102 | 599791366635648 |          1 | 河南省 郑州市 中原区 棉纺路锦艺国际华都欧尚1-3-1502                                                                    | shunfeng |           | 0',
'23105 | 599796254277760 |          1 | 河南省 郑州市 中原区 棉纺路锦艺国际华都欧尚1-3-1502                                                                    | shunfeng |           | 0',
'23128 | 599866117226624 |          1 | 上海市 上海市 浦东新区 周康路869弄御沁园16栋321号1901室                                                                | shunfeng |           | 0',
'23140 | 599925177548928 |          1 | 江苏省 南京市 秦淮区 大明路九龙新寓5-13-301室                                                                          | shunfeng |           | 0',
'23164 | 600037602754688 |          1 | 江苏省 连云港市 新浦区 龙河南路瑞城嘉园2号楼3201                                                                       | shunfeng |           | 0',
'23167 | 600056499634304 |          1 | 上海市 上海市 闸北区 共和新路2399弄17号楼2502室                                                                        | shunfeng |           | 0',
'23217 | 600195528884352 |          1 | 北京市 北京市 朝阳区 来广营北苑东路临2号中川国际矿业公司                                                               | shunfeng |           | 0',
'23235 | 600279854514304 |          1 | 北京市 北京市 西城区 太平街8号院朱雀门小区23号楼2单元102                                                               | shunfeng |           | 0',
'23344 | 601082869153920 |          1 | 广东省 广州市 番禺区 汉溪大道南国奥园雅典一区18座502                                                                   | shunfeng |           | 0',
'23407 | 601438036689024 |          1 | 上海市 上海市 南汇区 惠南镇城南路1239号                                                                                | shunfeng |           | 0',
'23416 | 601597489348737 |          1 | 上海市 上海市 普陀区 铜川路2060弄1号603室                                                                              | shunfeng |           | 0',
'23978 | 608117366161536 |          1 | 天津市 天津市 西青区 张家窝镇瑞欣家园42-3-602                                                                          | shunfeng |           | 0',
'24083 | 609473275461760 |          1 | 上海市 上海市 黄浦区 上海市黄浦区国货路288号904室                                                                      | shunfeng |           | 0',
];




/************************************************ 处理主程序 ************************************************/
echo '<pre>';

$insertSqlArr	= [];
foreach ($rowArr as $content)
{
	$strArr		= explode("|", $content);
	foreach ($strArr as $k => $v)
	{
		$strArr[$k]	= trim($v);
	}

	$orderId	= $strArr[1];
	if( !empty($orderExpressArr[$orderId]) )
	{
		$strArr[5]		= $orderExpressArr[$orderId];
		$strArr[7]		= date('Y-m-d H:i:s');
print_r($strArr);
		$insertSqlArr[]	= "('{$strArr[0]}', '{$strArr[1]}', '{$strArr[2]}', '{$strArr[3]}', '{$strArr[4]}', '{$strArr[5]}', '{$strArr[6]}', '{$strArr[7]}')";
	}
}

echo "<hr/>";
if( !empty($insertSqlArr) )
{
	$insertSql	= "INSERT INTO order_kuaipush (procureId,orderId,pushStatus,address,kuaiCode,expressNo,type,createTime) VALUES ";
	$insertSql	.= implode(",", $insertSqlArr);
	echo '<p>' . $insertSql . '</p>';
}
	
