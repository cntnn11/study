<?php
/**
 *	@DESC PHP长文本输出
 *	@date 2014-02-10
*/
error_reporting(E_ALL);
$a = '搞乱的';
$long	= <<<HTML
jkashdlfkjahsdlkjhaslkj
asdklfhasldkf
adsjklhaskfdasd
fasdlkjahskjfasd
fasklfgaweofidsf
sdflhsfjdlgsdfg {$a}
alksdfkjas
HTML;

var_dump($long);