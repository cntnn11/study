<?php
$redis = new Redis();
$redis->connect('127.0.0.1', '6379') OR die('没有服务');

$key	= 'redis';
$redis->set($key, 'hello redis!');

echo $redis->get($key);


