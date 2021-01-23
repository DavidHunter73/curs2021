<?php

	session_start();

	include 'myAdmin.php';

	//PHPMAILER
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


	$login = null;
	$nom = null;

	$uno = rand(0, 9); 
	$dos = rand(0, 9); 
	$suma = $uno + $dos; 

	if(isset($_SESSION["login"])) $login = $_SESSION["login"];
	if(isset($_SESSION["nom"])) $nom = $_SESSION["nom"];

	//Crea y actualiza las variables de session de la base de datos
	BaseDatos();

	if($login != null) $_SESSION["login"] = $login;
	if($nom != null) $_SESSION["nom"] = $nom;

	//Si se ha enviado algo como post
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		//Si lo que se ha enviado es el username
		if (isset($_REQUEST["username"])){
			//Mira todas las variables de sesion
			for($u = 0; $u < count($_SESSION["s_id"]); $u++){
				//Si concuerda con una de ellas
				if($_REQUEST["username"] == $_SESSION["s_username"][$u]){	
					if(md5($_REQUEST["password"]) == $_SESSION["s_password"][$u] || ComprovarPassword(md5($_REQUEST["password"]), $_REQUEST["username"])){

						//Crea el login
						$_SESSION["login"] = $_SESSION["s_username"][$u];
						$_SESSION["nom"] = $_SESSION["s_nom"][$u];

						DeletePassword(md5($_REQUEST["password"]));
			
						header("Location:home.php");
					}
				}
			}	
		}



		//Si lo que se ha enviado es para regenerar Contrasenya
		if (isset($_REQUEST["digit"]) && $_REQUEST["digit"] == $_REQUEST["suma"]){
			$username=$_REQUEST["p_username"];
			$codi = generarCodigo(8);

			$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_db_prova');

			//Petición para guardar la contraseña de solo una vez
			/*$sql = "INSERT INTO recovery VALUES (\"$codi\" , \"$username\")";

			//Si la petición falla, para el programa
			if (!$resultado = $conn->query($sql)){
				die("Error al consultar" . $conn->error);
			}*/


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
				$mail->Body    = 'Esta es su nueva contraseña que solo podrá usar una vez <strong>' . $codi . '</strong>';
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$mail->send();
				echo 'El correo se ha enviado';

				SavePassword(md5($codi), $username);
			
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

		<title>PROVA DAVID</title>
	</head>

	<body>

		<!--Menú de Login-->
		<form class="form-horizontal" enctype="multipart/form-data" action="index.php" method="post" id="aute" name="autentificacio">
				
			<div>
				<p>LOGIN</p>
			</div>

			<div>
				<!--Espacio donde introducir el mail-->
				<label>Username</label> 
				<input type="text" value="<?php if(isset($_REQUEST["username"]))echo $_REQUEST["username"];?>" size="30" maxlength="100" name="username" id="" /><br />
			</div>

			<div>
				<!--Espacio donde introducir la contraseña-->
				<label>Password</label> 
				<input type="password" value="<?php if(isset($_REQUEST["password"]))echo $_REQUEST["password"];?>" size="30" maxlength="100" name="password" id="" /><br />
			</div>

			<div>
				<button id="mysubmit" type="submit">Completar Login</button><br /><br />
			</div>
		</form>

		<br><br>

		<!--Menú de Login-->
		<form enctype="multipart/form-data" action="index.php" method="post" id="aute" name="autentificacio">
				
			<div>
				<p>REGENERAR PASSWORD</p>
			</div>

			<div>
				<!--Espacio donde introducir el mail-->
				<label>Username</label> 
				<input type="text" size="30" maxlength="100" name="p_username" id="" /><br />
			</div>

			<div>
				<input type="text" size="30" maxlength="2" name="suma" id="suma" value="<?php echo $suma; ?>" hidden />
				<?php echo $uno . " + " . $dos . " = "; ?>
				<input type="text" size="30" maxlength="2" name="digit" id="digit" />
				<button id="mysubmit" type="submit">Regenerar Password</button><br /><br />
			</div>
		</form>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	</body>

</html>
