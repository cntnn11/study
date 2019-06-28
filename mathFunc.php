<?php

$max = 10;
$s = $w = $x = $y = 0;
for( $i=0; $i<$max; $i++ )
{
	$funcRes = (4*$i) + (4*$i) + (3*$i);
	if( $funcRes == 33 )
	{
		$s = $i;
		echo '__s=' . $s . PHP_EOL;
		break;
	}
}

echo PHP_EOL;

for( $i=0; $i<$max; $i++ )
{
	$funcRes = (2*$i) + $i + $i;
	if( $funcRes == 24 )
	{
		$w = $i;
		echo '__w=' . $w . PHP_EOL;
		break;
	}
}

echo PHP_EOL;
for($i=0; $i<$max; $i++ )
{
	for($j=0; $j<$max; $j++)
	{
		$funcRes	= ($i+$s+$j+$s+$w) + ($i+$s+$j) + ($i+$j+$w+$s);
		if( $funcRes == 30 )
		{
			$x = $i;
			$y = $j;
			echo '__x=' . $x . '; __y=' . $y . PHP_EOL;
		}
	}
}

echo PHP_EOL.'----------------'.PHP_EOL;
echo 'res1:' . ( ($s) + ($w+$w) * (0+$s+2+$w+$s) ) . PHP_EOL;
echo 'res2:' . ( ($s) + ($w+$w) * (1+$s+1+$w+$s) ) . PHP_EOL;
echo 'res3:' . ( ($s) + ($w+$w) * (2+$s+0+$w+$s) ) . PHP_EOL;

exit(PHP_EOL . 'THE END' . PHP_EOL);
