<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';


	function generarCodigo($longitud) {
		 $key = '';
		 $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
		 $max = strlen($pattern)-1;
		 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		 return $key;
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$username=$_POST["username"];
		
		$codi= generarCodigo(10);
		setcookie('link_expire', $codi, time() + 7200);

		echo $codi;

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo usuario
		$sql = "INSERT INTO recovery VALUES (\"$codi\" , \"$username\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}


		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = 2;                      // Enable verbose debug output
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'davidhequ@gmail.com';                     // SMTP username
			$mail->Password   = 'alatreon73';                               // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('davidhequ@gmail.com', 'Mailer');
			$mail->addAddress("$username", 'User');     // Add a recipient
			$mail->addReplyTo('noreply@xtec.cat', 'Information');

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Solicitud de cambio de contraseña';
			$mail->Body    = 'Ha solitado una recuperación de contraseña. Por favor, entre <a href="http://dawjavi.insjoaquimmir.cat/dhernandez/UF1/Ejercicio7/changepass.php?codi='.$codi.'">aquí</a> para completar el cambio.';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			echo 'El correo se ha enviado';
			
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	} else {

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

		<title>Recuperando mail</title>
	</head>

	<body>

		<form action="recuperar_mail.php" method="post">
			Email del usuario:<input type="text" name="username"><br>
			<input type="submit" value="recuperar">

	</body>
</html>

<?php
	}
?>