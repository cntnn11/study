<?php 
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
echo '<p>hello memcached!</p>';
$mem_obj	= new Memcache();
$key		= 'memcache';
$mem_obj->connect('127.0.0.1', '11211') or die('fail!');
//$mem_obj->connect('mc_jkxy_01', 11211) or die('fail~');

$mem_obj->set($key, '<p>memcache is ok！</p>');

var_dump( $mem_obj->get($key) );

?>
