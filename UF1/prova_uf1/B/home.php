<?php

	session_start();

	include 'myAdmin.php';

	if(!isset($_SESSION["login"]) || !isset($_SESSION["nom"])){
		header("Location:index.php");
	}
	
	//Si se ha enviado algo como post
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_REQUEST["logout"])){
			session_unset();
			session_destroy();
			session_start();
			header("Location:index.php");
		}

		if (isset($_REQUEST["new_password"])){
			ModPassword(md5($_REQUEST["new_password"]), $_SESSION["login"]);
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

		<p>Bon día <?php echo $_SESSION["nom"]; ?></p>

		<!--Menú de Logout-->
		<form class="form-horizontal" enctype="multipart/form-data" action="home.php" method="post" id="out" name="logout">
			<div>
				<button name="logout" type="submit">Logout</button><br /><br />
			</div>
		</form>

		<!--Menú de Login-->
		<form class="form-horizontal" enctype="multipart/form-data" action="home.php" method="post" id="mod_pass" name="modificar_password">
				
			<div>
				<p>MODIFICAR PASSWORD</p>
			</div>

			<div>
				<input type="password" size="30" maxlength="100" name="new_password" id="" />
				<button id="mysubmit" type="submit">Modificar</button><br /><br />
			</div>
		</form>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	</body>

</html>
