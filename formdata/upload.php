<?php

$files = $_FILES;



header("Content-type: application/json");
echo json_encode([
	'code'	=> 0,
	'msg'	=> 'test-ok',
	'data'	=> $files,
], JSON_UNESCAPED_SLASHES);
