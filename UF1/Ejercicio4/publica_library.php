<?php

	//Crea la variable de sesion del mail y la contraseña
	$_SESSION["s_mail"] = "hola@gmail.com";
	$_SESSION["s_password"] = "adeu1234";


	//Esta parte mira si has aceptado o rechazado la política de cookies
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_REQUEST["p_accept"])) {
			//Crea la cookie que avisa que ya se han aceptado las politicas de cookies
			setcookie('politica', "si", time() + 365 * 24 * 60 * 60);

			} else if (isset($_REQUEST["p_deny"])) {
			header("Location:https://www.google.com/");
		}
	}

?>