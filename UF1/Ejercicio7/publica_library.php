<?php
	/****Función de comprobación de mail y password****/
	function Comprobar($mail, $password, $login){

		$correct = true;

		//Avisa si no se ha introducido a un email
		if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			echo "<b style=\"color:#e60000\">El mail que has introducido no es válido.</b><br>";
			$correct = false;
		//Avisa si el email no es correcto
		} else if (!in_array($mail, $_SESSION["s_mail"]) && $login){
			echo "<b style=\"color:#e60000\">El mail que has introducido no es correcto.</b><br>";
			$correct = false;
		}

		//Avisa si se ha introducido un carácter especial en contraseña
		if(!preg_match("/^[a-zA-Z0-9]+$/", $password)){
			echo"<b style=\"color:#e60000\">La contraseña debe tener solo letras y números.</b><br>";
			$correct = false;
		//Avisa si la contraseña no es correcta
		} else if (!in_array(md5($password), $_SESSION["s_password"]) && $login){
			echo "<b style=\"color:#e60000\">La contraseña que has introducido no es correcta.</b><br>";
			$correct = false;
		}

		return $correct;

	}
	/****Final de la función Comprobar****/



	/****Función de comprobación de name, mail y password****/
	function ComprobarAlta($name, $mail, $password, $login){

		$correct = true;

		/**Avisa si se ha introducido un carácter especial en nombre**/
		if(!preg_match("/^[a-zA-Z]+$/", $name)){
			echo"<b style=\"color:#e60000\">El nombre debe tener solo letras.</b><br>";
			$correct = false;
		//Avisa si la nombre no es correcto
		} else if (!in_array($name, $_SESSION["s_name"]) && $login){
			echo "<b style=\"color:#e60000\">La contraseña que has introducido no es correcta.</b><br>";
			$correct = false;
		}
		/**Fin de nombre**/

		/**Avisa si no se ha introducido a un email**/
		if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			echo "<b style=\"color:#e60000\">El mail que has introducido no es válido.</b><br>";
			$correct = false;
		//Avisa si el email no es correcto
		} else if (!in_array($mail, $_SESSION["s_mail"]) && $login){
			echo "<b style=\"color:#e60000\">El mail que has introducido no es correcto.</b><br>";
			$correct = false;
		}
		/**Fin de email**/

		/**Avisa si se ha introducido un carácter especial en contraseña**/
		if(!preg_match("/^[a-zA-Z0-9]+$/", $password)){
			echo"<b style=\"color:#e60000\">La contraseña debe tener solo letras y números.</b><br>";
			$correct = false;
		//Avisa si la contraseña no es correcta
		} else if (!in_array(md5($password), $_SESSION["s_password"]) && $login){
			echo "<b style=\"color:#e60000\">La contraseña que has introducido no es correcta.</b><br>";
			$correct = false;
		}
		/**Fin de password**/

		return $correct;

	}
	/****Final de la función ComprobarAlta****/



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