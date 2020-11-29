<?php
	
	session_start();

	//Importa la llibreria
	include 'myAdmin_library.php';
	include 'myAdminProductos_library.php';
	include 'myAdminComandas_library.php';


	//Id declarado para luego cambiarlo al correcto
	$id = 0;
	//Rol declarado en una variable
	$role = "user";
	//Variable para saber si toda la información fue obtenida para crear un pj
	$creation_error = false;

	$correct = "";

	//Si la cookie de recordar no existe y no se ha iniciado sesion, vuelve a publica
	if (!isset($_COOKIE["recordar_id"]) || 
		!isset($_COOKIE["recordar_name"]) || 
		!isset($_COOKIE["recordar_mail"]) ||  
		!isset($_COOKIE["recordar_password"]) || 
		!isset($_COOKIE["recordar_role"])){

		if(!isset($_SESSION["login"]) || $_SESSION["login"] == 0){
			//Dile a la sesion que no se ha hecho login
			$_SESSION["login"] = 0;
			$_SESSION["name"] = "";
			$_SESSION["role"] = "";

			setcookie('recordar_id',null, null);
			setcookie('recordar_name',null, null);
			setcookie('recordar_mail', null, null);
			setcookie('recordar_password', null, null);
			setcookie('recordar_role',null, null);

			//Ve hacia la pagina publica
			header("Location:publica.php");

		} else {
			//Guarda el id y el rol en la session
			$id = $_SESSION["login"];
			$role = GetRole($id);

			//Actualiza la variable de sesion con la base de datos
			BaseDatos();

			//Reindica a session lo que debe ser
			$_SESSION["login"] = $id;
			$_SESSION["role"] = $role;

			//Da la bienvenida al usuario
			echo "<nav style=\"background-color: #262626; 
							   color: white;
							   margin-top:0px; 
							   padding: 10px;\">
					<h4 style=\"text-align:center\">Bienvenido " . GetInfo("name", $id) . "!</h4>
				  </nav>";
		}
	} else {
		//Guarda el id y el rol en la session
		$id = $_COOKIE["recordar_id"];
		$role = GetRole($id);

		//Actualiza la variable de sesion con la base de datos
		BaseDatos();

		//Reindica a session lo que debe ser
		$_SESSION["login"] = $id;
		$_SESSION["role"] = $role;

		//Da la bienvenida al usuario
		echo "<nav style=\"background-color: #262626;
						       color: white;
							   margin-top:0px; 
							   padding: 10px;\">
				<h4 style=\"text-align:center\">Bienvenido " . $_COOKIE["recordar_name"] . "!</h4>
			  </nav>";
	}


	echo "<a href=\"publica.php\">TO PUBLIC</a>";

	echo "<h1>Transacciones</h1>";
	for($t = 0; $t < count($_SESSION["t_id"]); $t++){
		if($_SESSION["t_correcta"][$t] == 1){
			$correct = "Correcta";
		} else {
			$correct = "Fallida";
		}
		echo "<p> Id:" . $_SESSION["t_id"][$t] . " / Preu:" . $_SESSION["t_price"][$t] . " / Tipus:" . $correct . "</p>";
	}

	
	echo "<br><br><br>";
	echo "<h3>En todo este tiempo has ganado: " . GetInfo("dinero_ganado", $id) . "</h3>";
	

?>

