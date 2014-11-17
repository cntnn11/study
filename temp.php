<?php

$str	= '<span class="current-comment-page”>[3213]</span>';

$preg	= '/<span class=\"current\-comment\-page\”>\[(\d*)\]<\/span>/';
preg_match_all($preg, $str, $matches);
echo '<pre>';

var_dump($matches);

?>