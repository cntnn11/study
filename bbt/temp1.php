<?php
/**
 *	@url	http://test.study.com/bbt/temp1.php
*/

echo '<pre>';
/*$orderIds	= [816132410900608,816132545970304,816132554064000,816132583227520,816132630610048,816132656889984,816132681662592,816132684578944,816132746379392,816132796874880,816132844322944,816132876402816,816132922605696,816132928503936,816132949344384,816133050171520,816133090050176,816133116854400,816133149950080,816133154865280,816133161255040,816133243961472,816133273518208,816133275222145,816133349605504,816133366710400,816133422219392,816133489655936,816133653102720,816133699764352,816133838045312,816134003064961,816134003064961,816134081577088,816134150652032,816134487507072,816134513328256,816134633160832,816135247626368,816135274037376,816135278100608,816135372374144,816136122105985,816136315699328,816136315699328,816136349745280,816136427700352,816136427700352,816136923447424,816136965718144,816137237135488,816137852092545,816137968255104,816137968255104,816138122297472,816138166108288,816138312843392,816138592452736,816138592452736,816139410899072,816139751030912,816139816894592,816139824627840,816140091949184,816140139593856,816140155453568,816140155453568,816141058408577,816141141246080,816143111356544,816143981084800,816145588748416,816145774018688,816147184812160,816148314194048,816148991017088,816148991017088,816148991017088,816150764224640,816150764224640,816153511002240,816155979219072,816156723183744,816157107814528,816157612933248,816159740592256,816162968371328,816162968371328,816163191226497,816163773153408,816164420845696,816165267931265,816170471751808,816181772353664,816181772353664,816185894502528,816192201687168,816192955973760,816192955973760,816194284028032,816194508816512,816211900268672,816211900268672,816211915604096,816211915604096,816213615280256,816215386980480,816217408209025,816219843526785,816222781571200,816223213748352,816224310984832,816231387889792,816231387889792,816231387889792,816231571128448,816234794975360,816245644853377,816245644853377,816254029955200,816254029955200,816254029955200,816256667222145,816259859841152,816286697914496,816315161804928,816327433355392,816349049356416,816355874635904,816384819200128,816398492237952,816428157960320,816444875866240,816526891778176,816694464282752,816697633210496,816697633210496,817256145518720,817394517082241,817466162380928,817468553855104,817468553855104,817468553855104,817494732603520,817546277486720,817615768223872,817615768223872,817641536389248,817689078890624,817762096251008,817807139143808,817807139143808,817929314992256,817941654372480,817943814406272,818025425830016,818086604701824,818109340418176,818318001078400,818318949613696,818333860069505,818575041462400,818662319423616,818847874711680,818872797462656,818955766104192,818971902312576,818987286790272,819009178796160,819018138321024,819047636009088,819136993820800,819234031960192,820218723139712,820454339182720,820605568450688,820626879447168,820651608244352,820709826855040,820728498290816,833348346708096,834550474539136,834676978352256,835732180041857,838153447178368,840790406267008,841119455150208,841119455150208,841387671978112,841387671978112,841388076138624,841388076138624,842058918658177,853096266334336,853096266334336,853096266334336];

$diffOrderIds	= [816132517757056,816134477676673,816134620971136,816135191265408,816135743799424,816135971504256,816137617571968,816138826285184,816139013292161,816142576681088,816142576681088,816158744215680,816163756212352,816163992535168,816172578603137,816181822619777,816213615280256,816214846898304,816235144511616,816237923336320,816262119161984,817629272440960,818035260620928,819249923129472,820605568450689];

//$diffOrderIds	= [816132410900608,816132545970304,816132554064000,816132583227520,816132630610048,816132656889984,816132681662592,816132684578944,816132746379392,816132796874880,816132844322944,816132876402816,816132922605696,816132949344384,816133050171520,816133090050176,816133116854400,816133149950080,816133154865280,816133161255040,816133243961472,816133273518208,816133275222145,816133349605504,816133366710400,816133422219392,816133489655936,816133653102720,816133699764352,816133838045312,816134003064961,816134003064961,816134081577088,816134150652032,816134487507072,816134513328256,816134633160832,816135274037376,816135278100608,816135372374144,816136122105985,816136315699328,816136315699328,816136349745280,816136427700352,816136427700352,816136923447424,816136965718144,816137852092545,816137968255104,816137968255104,816138122297472,816138166108288,816138592452736,816138592452736,816139410899072,816139751030912,816139816894592,816139824627840,816140091949184,816140139593856,816140155453568,816140155453568,816141141246080,816143111356544,816145588748416,816147184812160,816148314194048,816148991017088,816148991017088,816148991017088,816150764224640,816150764224640,816155979219072,816156723183744,816157107814528,816162968371328,816162968371328,816163191226497,816163773153408,816165267931265,816170471751808,816181772353664,816181772353664,816185894502528,816192955973760,816192955973760,816194284028032,816211900268672,816211900268672,816211915604096,816211915604096,816213615280256,816217408209025,816219843526785,816222781571200,816231387889792,816231387889792,816231387889792,816231571128448,816234794975360,816245644853377,816245644853377,816254029955200,816254029955200,816254029955200,816256667222145,816286697914496,816315161804928,816327433355392,816349049356416,816355874635904,816384819200128,816398492237952,816428157960320,816444875866240,816526891778176,816694464282752,816697633210496,816697633210496,817256145518720,817394517082241,817466162380928,817468553855104,817468553855104,817468553855104,817494732603520,817546277486720,817615768223872,817615768223872,817641536389248,817689078890624,817690454425729,817690454425729,817762096251008,817807139143808,817807139143808,817929314992256,817941654372480,817943814406272,818025425830016,818086604701824,818109340418176,818318001078400,818318949613696,818333860069505,818575041462400,818662319423616,818847874711680,818872797462656,818955766104192,818971902312576,818987286790272,819009178796160,819018138321024,819047636009088,819136993820800,819234031960192,820218723139712,820454339182720,820605568450688,820626879447168,820651608244352,820709826855040,820728498290816,833348346708096,834550474539136,834676978352256,835732180041857,838153447178368,840790406267008,841119455150208,841119455150208,841388076138624,841388076138624,842058918658177,853096266334336,853096266334336,853096266334336];

foreach ($diffOrderIds as $orderId)
{
	if( !in_array($orderId, $orderIds) )
	{
		echo $orderId . "<br/>";
	}
}*/


/*$procureIds	= [48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48026,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,48054,49145,49228,49285,49497,50541,50541,50541,50541,50541,50541,50541,55802,55802,55802];

print_r( array_unique($procureIds) );
Array
(
    [0] =>   48026
    [101] => 48054
    [162] => 49145
    [163] => 49228
    [164] => 49285
    [165] => 49497
    [166] => 50541
    [173] => 55802
)
*/
