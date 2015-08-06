<?php
echo '<pre>';
var_dump($_ENV);
var_dump($_SERVER);
echo '</pre>';

$i = 0;
$i++;

$j=$i;
$j++;
echo $j+$i;

echo '<br/>';
echo date('Y年m月d日');
echo '<br/>';
echo substr(md5('svnALYcntnn11'), 0, 12);
echo '<br/>';
echo substr(md5('alyIcpTnn11'), 0, 12);
echo '<br/>';
echo substr(md5('alycntnn11blog'), 0, 12);
echo '<br/>';
echo substr(md5('callmepwd'), 0, 12);
echo '<br/>';
echo substr(md5('isonlyisme'), 0, 8);
echo '<br/>';

if( $_GET['rule'] == 'tnn11' )
{
	phpinfo();
}
else
{
	exit('看毛');
}
