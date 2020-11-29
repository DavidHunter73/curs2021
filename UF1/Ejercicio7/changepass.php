<?php

	include 'myAdmin_library.php';


	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$codi = $_POST["codi"];
		$pass = $_POST["p1"];
		$usuariacanviar = "";

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo usuario
		$sql = "SELECT usuarios.email from recovery inner join usuarios on usuarios.email=recovery.username where recovery.codi=\"$codi\"";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
		$rows = $resultado->num_rows;


		if($rows>0){
			
			if($obj = mysqli_fetch_object($resultado)){
				$usuariacanviar =$obj->email;

				//Petición para obtener el mail y la contraseña de los usuarios
				$sql = "UPDATE usuarios
						SET
							password ='".md5($_POST["p1"])."'
						WHERE
							email = \"$usuariacanviar\";";

				//Si la petición falla, para el programa
				if (!$resultado = $conn->query($sql)){
					die("Error al consultar" . $conn->error);
				}

				echo $sql;
				echo "Contraseña canviada";
			}			

		} else {

			"Por alguna razón algo ha ido mal";

		}

	} else {

		$codi = $_GET["codi"];

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo usuario
		$sql = "SELECT usuarios.email from recovery inner join usuarios on usuarios.email=recovery.username where recovery.codi=\"$codi\"";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
		$rows = $resultado->num_rows;

		if(isset($_COOKIE["link_expire"]) && $_COOKIE["link_expire"] == $codi){
			if($rows>0){
	
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
					<form action="changepass.php" method="post">
			
						<input type="password" name="p1"><br>
						<input type="hidden" name="codi" value="<?=$codi?>">
						<input type="submit" value="canvi">
				
					</form>
				</body>
			</html>


	<?php

			} else {
				echo "Lo sentimos.";
			}
		} else {
			echo "El link ha caducado.";
		}

		mysqli_close($conn);

	}


?>