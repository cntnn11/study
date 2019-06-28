<?php

global $conn;

require_once "./tempConnRequire.php";

function Fn()
{
	// echo $conn;
	print_r( $GLOBALS['conn'] );
}

Fn();
