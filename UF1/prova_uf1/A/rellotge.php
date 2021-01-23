<?php

	$hora = date("G");
	$minuto = date("i");
	$segundo = date("s");

	for($h = 0; $h < 24; $h++){
		if($h == $hora){
			echo "<strong>".$h." </strong>";
		} else {
			echo $h." ";
		}
	}

	echo "<br>";

	for($m = 0; $m < 60; $m++){
		if($m == $minuto){
			echo "<strong>".$m." </strong>";
		} else {
			echo $m." ";
		}
	}

	echo "<br>";

	for($s= 0; $s < 60; $s++){
		if($s == $segundo){
			echo "<strong>".$s." </strong>";
		} else {
			echo $s." ";
		}
	}
?>