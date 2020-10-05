<?php
//Escribe el mes en el que estás
$mes = date("F");
echo "<h2>$mes</h2>";
?>


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
//Desclaracion de las variables del dia actual, dia de la setamna actual y de cuandos dias tiene el mes
$dia = date("j");
$dia_setm = date("N");
$dias_mes = date("t");

//Esto determina que dia de la semana era el día 1 del mes
for ($d = $dia; $d > 0; $d--){
	if($dia_setm == 1){
		$dia_setm = 7;
	} else if ($dia_setm > 1){
		$dia_setm--;
	}
}

//Después de saber que dia de la semana era el dia 1, modifico la variable dia para usarla en el programa
$dia = 1 - $dia_setm;


//El cuerpo del programa, donde genero la tabla y la relleno con los número de los días
	for ($fila = 0; $fila < 6; $fila++) {
		echo"<tr>";
		for ($columna = 0; $columna < 7; $columna++) {
			//Si este es el día de hoy, pintalo de amarillo
			if($dia == date("j")){
				?>
				<td style = "background-color:yellow">
				<?php
			} else {
				echo"<td>";
			}
			
			//Se asegura de no pintar dias del 0 hacia abajo y del mas alto del mes
			if($dia > 0 && $dia <= $dias_mes)  echo"$dia";
			if($dia > $dias_mes) echo"<br>";
			echo"</td>";
			$dia++;
		}

		echo"</tr>";
	}

?>

</table>
