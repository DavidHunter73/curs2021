<?php
	session_start();

	//Importa la llibreria
	include 'publica_library.php';
	//Importa la conexión con phpMyAdmin
	include 'myAdmin_library.php';


	$correct = false;

	//Guarda la base de datos en la sesión
	BaseDatos();

	//Si la politica de cookies no ha sido aceptada aún...
	if (!isset($_COOKIE['politica']) && !isset($_REQUEST["p_accept"])){
		?>
			<!--Forma la petición de la política de cookies-->
			<h1>Acepta nuestra política de cookies para continuar en esta página</h1><br>
			<form enctype="multipart/form-data" action="publica.php" method="post" id="aute" name="politica">	
				<button id="mysubmit" type="submit" name="p_accept">Aceptar</button><br>
				<button id="mysubmit" type="submit" name="p_deny">Rechazar</button><br>
			</form>
		<?php

	//Si la política de cookies ya se ha aceptado...
	} else {
		//Si se ha dicho que se recuerde todo, ve directo a la página privada
		if (isset($_COOKIE["recordar_id"]) &&  
			isset($_COOKIE["recordar_name"]) && 
			isset($_COOKIE["recordar_mail"]) && 
			isset($_COOKIE["recordar_password"]) && 
			isset($_COOKIE["recordar_role"])){

			header("Location:privada.php");
		}

		//Si se le ha pasado información mediante un formulario...
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			//En el caso de que se le haya pasado información para darse de alta
			if (isset($_REQUEST["alta_mail"])){
				//Si el mail y contraseña son correctas y las dos contraseñas son iguales, crea el usuari en phpMyAdmin
				if (ComprobarAlta($_REQUEST["alta_name"], $_REQUEST["alta_mail"], $_REQUEST["alta_password"], false)){
					if($_REQUEST["alta_password"] == $_REQUEST["rep_alta_password"]){
						if(ComprobarEmail($_REQUEST["alta_mail"], 0) == "valido"){
							//Haz el alta hy dile a la sesion que se ha iniciado correctamente
							Alta($_REQUEST["alta_name"], $_REQUEST["alta_mail"], $_REQUEST["alta_password"], "user");
							$_SESSION["login"] = GetId($_REQUEST["alta_mail"]);
							$_SESSION["name"] = $_REQUEST["alta_name"];
							$_SESSION["role"] = "user";

							//Ve hacia la página privada
							header("Location:privada.php");
						} else {
							echo "<b style=\"color:#e60000\">El email que has introducido lo tiene otro usuario.</b><br>";
						}
					} else {
						echo "<b style=\"color:#e60000\">Las dos contraseñas introducidas són diferentes.</b><br>";
					}
				}
			}
			
		}
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

		<title>Publica</title>
	</head>

	<body>
		<!--Menú de Alta-->
		<form class="form-horizontal" enctype="multipart/form-data" action="publica_alta.php" method="post" id="alta" name="alta">
			<div class="col-4 offset-4">
				<p style="text-align: center">ALTA D'USUARI</p>
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el nombre-->
				<label class="col-1 offset-4">Nombre</label> 
				<input class="col-2" type="text" value="<?php if(isset($_REQUEST["alta_name"]))echo $_REQUEST["alta_name"];?>" size="30" maxlength="100" name="alta_name" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el mail-->
				<label class="col-1 offset-4">Email</label> 
				<input class="col-2" type="text" value="<?php if(isset($_REQUEST["alta_mail"]))echo $_REQUEST["alta_mail"];?>" size="30" maxlength="100" name="alta_mail" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir la contraseña-->
				<label class="col-1 offset-4">Contraseña</label> 
				<input class="col-2" type="password" value="<?php if(isset($_REQUEST["alta_password"]))echo $_REQUEST["alta_password"];?>" size="30" maxlength="100" name="alta_password" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir la contraseña-->
				<label class="col-1 offset-4">Repetir Contraseña</label> 
				<input class="col-2" type="password" value="<?php if(isset($_REQUEST["rep_alta_password"]))echo $_REQUEST["rep_alta_password"];?>" size="30" maxlength="100" name="rep_alta_password" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<button class="col-4 offset-4" id="mysubmit" type="submit">Donar-se D'alta</button><br /><br />

			</div><div style="float:center" class="form-group form-inline">
				<a class="col-4 offset-4" href="publica.php">¿Ja tens un compte?</a>
			</div>
		</form>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	</body>

</html>

<?php
	}
?>