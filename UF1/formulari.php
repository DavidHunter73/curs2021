<?php
//Si el formulario ya se ha completado, printa la información
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	//Printa el texto si no está vacío
	if ($_REQUEST["mytext"] == ""){
		echo "Text está buit.<br>";
	} else {
		echo "El valor de text és " . $_REQUEST["mytext"] . "<br>";
	}

	//Printa el radiobutton
	echo "El radiobutton escollit és el " . $_REQUEST["myradio"] . "<br>";	

	//Mira si se ha elegido algún checkbutton. Si la respuesta es si, printalos
	if (isset($_REQUEST["mycheckbox"])){
		foreach($_REQUEST["mycheckbox"] as $check) {
			echo "La checkbox " . $check . " ha sigut marcada<br>";  //concatenem el separador amb l'element
		}
	} else {
		echo("No s'ha marcat ninguna checkbox<br>");
	}

	//Printa el grupo
	echo "El grup escollit és el " . $_REQUEST["myselect"] . "<br>";

	//Printa el area de texto si no está vacía
	if ($_REQUEST["mytextarea"] == ""){	
		echo "Text area está buit.<br>";
	} else {
		echo "El valor de text area és " . $_REQUEST["mytextarea"] . "<br>";
	}

	//Muestra una imagen si se le ha adjuntado
	if ($_REQUEST["imagen"] == ""){
		echo "No se ha adjuntado nada";
	}else{
		echo "Se ha adjuntado el archivo " . $_REQUEST["imagen"];
	}

//Si aún hay que rellenar el formulario, muestralo
} else { 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Exemple de formulari</title>
	</head>

	<body>
		<div style="margin: 30px 10%;">
			<h3>My form</h3>
			<form action="formulari.php" method="post" id="myform" name="myform">

				<label>Text</label> <input type="text" value="" size="30" maxlength="100" name="mytext" id="" /><br /><br />

				<input type="radio" name="myradio" value="1" /> First radio
				<input type="radio" checked="checked" name="myradio" value="2" /> Second radio<br /><br />

				<input type="checkbox" name="mycheckbox[]" value="1" /> First checkbox
				<input type="checkbox" checked="checked" name="mycheckbox[]" value="2" /> Second checkbox<br /><br />

				<label>Select ... </label>
				<select name="myselect" id="">
					<optgroup label="group 1">
						<option value="1" selected="selected">item one</option>
					</optgroup>
					<optgroup label="group 2" >
						<option value="2">item two</option>
					</optgroup>
				</select><br /><br />

				<textarea name="mytextarea" id="" rows="3" cols="30">
					Text area
				</textarea> <br /><br />

				<input type="file" name="imagen"></input><br /><br />

				<button id="mysubmit" type="submit">Submit</button><br /><br />
			</form>
		</div>
	</body>

</html>


<?php
}
?>