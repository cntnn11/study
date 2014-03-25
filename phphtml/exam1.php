<?php
ob_start();
echo '<p>first</p>';
header("content-type:text/html; charset='utf-8'");
echo '<p>two</p>';
//ob_flush();
echo '<p>three</p>';
ob_end_flush();

echo ob_get_contents();

?>