<?php

// 超时了
sleep(1);

// 正常返回
$result	= array('succ'=>'ok');

echo json_encode($result);
exit('');