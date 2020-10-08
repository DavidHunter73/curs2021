<?php

$linea_num = 0;

for ($i = 0; $i <1000; $i++) {
	if ($linea_num < 50){
		echo "M'agrada programar en PHP<br>";
		$linea_num++;
	} else {
		echo "<br>";
		$linea_num = 0;
	}
}

?>
