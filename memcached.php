<?php 
// header('Content-Type: text/html; charset=utf-8');
// error_reporting(E_ALL);
echo '<p>hello memcached!</p>';
$mem_obj	= new Memcache();
$key		= 'memcache';
$mem_obj->connect('127.0.0.1', '11211') or die('fail!');
//$mem_obj->connect('mc_jkxy_01', 11211) or die('fail~');

$mem_obj->set($key, '<p>memcache is ok！</p>');

var_dump( $mem_obj->get($key) );

var_dump( $mem_obj->get( 'COURSE_LIST_V4_NO_LIMIT' ) );

/*$mem = new Memcache;
$res = $mem->connect("127.0.0.1", 11211);
//Memcache::set方法有四个参数，第一个参数是key，第二个参数是value，第三个参数可选，表示是否压缩保存，第四个参数可选，用来设置一个过期自动销毁的时间。
$mem->set('test','123',0,60);
//Memcache::add方法的作用和Memcache::set方法类似，区别是如果 Memcache::add方法的返回值为false，表示这个key已经存在，而Memcache::set方法则会直接覆写。
$mem->add('test','123',0,60);
//Memcache::get方法的作用是获取一个key值，Memcache::get方法有一个参数，表示key。
$mem->get('test');//输出为'123'
//Memcache::replace 方法的作用是对一个已有的key进行覆写操作，Memcache::replace方法有四个参数，作用和Memcache::set方法的相同。
$mem->replace('test','456',0,60);
//Memcache::delete方法的作用是删除一个key值，Memcache::delete方法有两个参数，第一个参数表示key，第二个参数可选，表示删除延迟的时间。
$mem->delete('test',60);*/


?>
