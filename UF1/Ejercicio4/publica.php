<?php
	session_start();

	//Importa la llibreria
	include 'publica_library.php';

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
		//Si se ha dicho que se recuerde el mail, ve directo a la página privada
		if(isset($_COOKIE["recordar_mail"])){
			header("Location:privada.php");
		}

		//Si se le ha pasado información mediante un formulario...
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Si el mail y la contraseña existen y son correctas
			if(isset($_REQUEST["mail"])){
				if($_REQUEST["mail"] == $_SESSION["s_mail"] && $_REQUEST["password"] == $_SESSION["s_password"]){
					//Si le has dicho de recordar el mail
					if (isset($_REQUEST["r_usuari"])){
						//Crea la cookie del mail y la contraseña
						setcookie('recordar_mail', md5($_REQUEST["mail"]), time() + 365 * 24 * 60 * 60);
						setcookie('recordar_password', md5($_REQUEST["password"]), time() + 365 * 24 * 60 * 60);
					}

					//Dile a la sesion que se ha iniciado correctamente
					$_SESSION["login"] = "si";

					//Ve hacia la página privada
					header("Location:privada.php");

				//Si no están correctos
				} else {
					//Avisa si no se ha introducido a un email
					if(!filter_var($_REQUEST["mail"], FILTER_VALIDATE_EMAIL)) {
						echo "<p>El mail que has introducido no es válido.</p>";

					//Avisa si el email no es correcto
					} else if($_REQUEST["mail"] != $_SESSION["s_mail"]){
						echo "<p>El mail que has introducido no es correcto.</p>";
					}

					//Avisa si se ha introducido un carácter especial en contraseña
					if(!preg_match("/^[a-zA-Z0-9.]+$/", $_REQUEST["password"])){
						echo"<p>La contraseña debe tener solo letras y números.</p>";

					//Avisa si la contraseña no es correcta
					} else if($_REQUEST["password"] != $_SESSION["s_password"]){
						echo "<p>La contraseña que has introducido no es correcta.</p>";
					}
				}
			}

			//Si el mail está siendo recordado...
			if (isset($_COOKIE["recordar_mail"])){
				//Ves a la página privada
				header("Location:privada.php");
			}
		}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Autentificació</title>
	</head>

	<body>
		<form enctype="multipart/form-data" action="publica.php" method="post" id="aute" name="autentificacio">

			<!--Espacio donde introducir el mail-->
			<label>Email</label> <input type="text" value="<?php if(isset($_REQUEST["mail"]))echo $_REQUEST["mail"];?>" size="30" maxlength="100" name="mail" id="" /><br />

			<!--Espacio donde introducir la contraseña-->
			<label>Contraseña</label> <input type="text" value="<?php if(isset($_REQUEST["password"]))echo $_REQUEST["password"];?>" size="30" maxlength="100" name="password" id="" /><br />
			
			<!--Checkbox para recordar l'usuari-->
			<input type="checkbox" name="r_usuari" value="1" /> Recordar Usuari<br>
				
			<button id="mysubmit" type="submit">Submit</button><br /><br />
		</form>

	</body>

</html>

<?php
	}
?>