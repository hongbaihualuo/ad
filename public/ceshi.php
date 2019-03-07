<?php
$total = 100; //次
$num = 10;
$count = 0;

for ($i = $num;$i>0;$i--) {
	$p = (int)($total/$i);
	$f = rand(0,1);
	
	if ($i == 1) {
		$a = $total;
	} else {
		
		if ($f) {
			$a = $p - (int)rand(0,$p*4/5);
		} else {
			$a = $p + (int)rand(0,$p*4/5);
		}
		$total = $total-$a;
	}
	$count += $a;
	echo $a.'....'.$f.'</br>';
	
}
var_dump($count);