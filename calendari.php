<table border = "1">
	<tr>
		<td>Lun</td>
		<td>Mar</td>
		<td>Mie</td>
		<td>Jue</td>
		<td>Vie</td>
		<td>Sab</td>
		<td>Dom</td>
	</tr>
<?php

$dia = date("j");
$dia_setm = date("N");
$dias_mes = 0;

for ($d = $dia; $d > 0; $d--){
	if($dia_setm == 1){
		$dia_setm = 7;
	} else if ($dia_setm > 1){
		$dia_setm--;
	}
}

$dia = 1 - $dia_setm;


if(date("n") == "1" || "3" || "5" || "7" || "8" || "10" || "12") $dias_mes = 32;
if(date("n") == "4" || "6" || "8" || "11") $dias_mes == 31;
if(date("n") == "2"){
	if(date("L") == "0") $dias_mes == 29;
	if(date("L") == "1") $dias_mes == 30;
}


	for ($fila = 0; $fila < 6; $fila++) {
		echo"<tr>";

		for ($columna = 0; $columna < 7; $columna++) {
			echo"<td>";
			if($dia > 0 && $dia < $dias_mes)  echo"$dia";
			if($dia >= $dias_mes) echo"<br>";
			echo"</td>";
			$dia++;
		}

		echo"</tr>";
	}

?>

</table>
