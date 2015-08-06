<?php 
error_reporting(E_ALL);
$map	= array();
$server	= new swoole_websocket_server("115.29.45.104", 9501);

$server->on('open', function(swoole_websocket_server $server, $request){
	error_log($request->fd, 3, './log.txt');
});


$server->on( 'message', function(swoole_websocket_server $server, $frame){
	global $client;
	$data	= $frame->data;
	$m		= file_get_contents('./log.txt');
	for( $i=1; $i<=$m; $i++ )
	{
		echo PHP_EOL . ' i is ' . $i . ' data is ' . $data . ' m = ' . $m;
		$server->push($i, $data);
	}
});

$server->on( 'close', function($ser, $fd){
	echo "client {$fd} closed\n";
});
$server->start();


