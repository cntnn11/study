<?php
/**
 *	@url	http://test.study.com/bbt/temp4.php
*/

$more	= [1000042178019456,1000042178740352,1000043004428416,1000043054694528,1000043366154368,1000043378540672,1000044000968832,1000044339331200,1000044650627200,1000044996722816,1000045301301376,1000045317095552,1000046265663616,1000046987542656,1000048047587456,1000048354033792,1000049662656640,1000050000887936,1000050163941504,1000050387550336,1000051108937856,1000051595739265,1000055647928448,1000056502222977,1000057096306817,1000062725619840,1000066545123456,1000078537261184,1000104462483584,1000130805203072,1000173084835968,1000216378114176,1000247253631104,1000280101585024,1000327721615488,1000375621714048,1000411917484160,1000045270204544,1000046871904384,1000048483729536,1000049269637248,1000051529023616,1000054300606592,1000054745596033,1000055840800896,1000057082740864,1000057192251520,1000058692632705,1000059108229249,1000060167192704,1000064254935168,1000078078705792,1000080674586753,1000104817492096,1000149693661313,1000161505149056,1000417460224128,1000479905022080,1000491054792832,1000526994210944,1000532530823296,1000558536425600,1000711356186752,1001117671653504,1001659956658304,1001892928159872,1001921057620096,1002015575998592,1002047456444544,1002260470726785,1002301242245248,1002465242054784,1002759175831680,1003229674471553,1004657868865665,1005976179900544,1005988853874816,1006029341261952,1006158955741312,974001375445120,974819237920896,980561017831552,987880600076416,994840413667457,995182008598656,996324642390144,1000109670662272,1000112767565952,1000135006322816,1000164335321216,1000203791401088,1000267263180928,1000308047773824,1000369748738176,1000382058037376,1000489225617536,1000502302081152,1000640776732800,1000832374734976,1001387394826368,1001803221893248,1001873865638016,1001920050299008,1002188177834112,1002288522068096,1002446087192704,1002975256412288,1002986054877312,1003033951240320,1003398607011968,1004831582486656,1005757864673408,1005794796896385,1005864023523456,1005877831237760,1005881061638272,1006042865107072,1006060777275520,1006129940856960,1019058839945344,977018187939968,977541606473856,979143788331136,979244629885056,979244828426368,980272410165376,981859597123712,982110441209984,1000148966244480,1005433773949056,984751180120192,993923840278656,1010361757663360,1011432433418369,1012614539149441,1050511640461440,1050522066681984,1050527728992384,1050533435375744,1050546771820672,1053226283794560];

$small	= [1000042178019456,1000043054694528,1000043366154368,1000043378540672,1000044339331200,1000044996722816,1000045301301376,1000048354033792,1000048483729536,1000049269637248,1000049662656640,1000051108937856,1000051529023616,1000055647928448,1000055840800896,1000056502222977,1000058692632705,1000059108229249,1000060167192704,1000064254935168,1000066545123456,1000078078705792,1000080674586753,1000104817492096,1000135006322816,1000148966244480,1000149693661313,1000161505149056,1000173084835968,1000216378114176,1000267263180928,1000280101585024,1000308047773824,1000369748738176,1000382058037376,1000417460224128,1000479905022080,1000489225617536,1000491054792832,1000502302081152,1000526994210944,1000532530823296,1000640776732800,1000711356186752,1000832374734976,1001387394826368,1001803221893248,1001873865638016,1001920050299008,1001921057620096,1002446087192704,1002465242054784,1002975256412288,1002986054877312,1003033951240320,1003229674471553,1003398607011968,1004831582486656,1005433773949056,1005794796896385,1005877831237760,1005976179900544,1006042865107072,1019058839945344,974001375445120,974819237920896,977018187939968,977541606473856,979244629885056,979244828426368,980272410165376,980561017831552,982110441209984,984751180120192,993923840278656,995182008598656,996324642390144,1000042178740352,1000203791401088,1002188177834112,1010361757663360,1011432433418369,1012614539149441,1050511640461440,1050533435375744,1053226283794560,1000043004428416,1000046987542656,1000050163941504,1000054745596033,1000057096306817,1000104462483584,1000130805203072,1000164335321216,1001117671653504,1001659956658304,1002047456444544,1002288522068096,1002301242245248,1005757864673408,1005864023523456,1005881061638272,1006129940856960,979143788331136,981859597123712,1002260470726785,1000078537261184,1006158955741312,987880600076416,1000109670662272,1000247253631104];

echo "<pre>";
$result	= array_diff($more, $small);

echo implode(",", $result);
// 1000044000968832,1000044650627200,1000045317095552,1000046265663616,1000048047587456,1000050000887936,1000050387550336,1000051595739265,1000062725619840,1000327721615488,1000375621714048,1000411917484160,1000045270204544,1000046871904384,1000054300606592,1000057082740864,1000057192251520,1000558536425600,1001892928159872,1002015575998592,1002759175831680,1004657868865665,1005988853874816,1006029341261952,994840413667457,1000112767565952,1006060777275520,1050522066681984,1050527728992384,1050546771820672


