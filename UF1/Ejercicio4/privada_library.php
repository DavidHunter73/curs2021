<?php

	//Si la cookie de recordar mail no existe y no se ha iniciado sesion, vuelve a publica
	if (!isset($_COOKIE["recordar_mail"])){
		if(!isset($_SESSION["login"]) || $_SESSION["login"] == "no"){
			//Dile a la sesion que no se ha hecho login
			$_SESSION["login"] = "no";

			//Ve hacia la pagina publica
			header("Location:publica.php");
		}
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_REQUEST["logout"])){
			//Borra la cookie que recuerda el mail y la contraseña
			setcookie('recordar_mail', null, null);
			setcookie('recordar_password', null, null);

			//Dile a la sesion que no se ha hecho login
			$_SESSION["login"] = "no";

			//Ve hacia la pagina publica
			header("Location:publica.php");
		}
	}

	echo "<!--Botón de hacer logout-->";
	echo "<form enctype=\"multipart/form-data\" action=\"privada.php\" method=\"post\" id=\"aute\" name=\"logout\">";	
		echo "<button id=\"mysubmit\" type=\"submit\" name=\"logout\">Logout</button><br /><br />";
	echo "</form>";

?>