<?php
	/****Función para guardar todos los datos de la base de datos en la sesión****/
	function BaseDatos(){
		//Conexión a la base de datos
		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_db_prova');

		//Si falla la conexión, para el programa
		if($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
		}

		session_unset();
		session_destroy();
		session_start();


		$_SESSION["s_id"] = [];
		$_SESSION["s_nom"] = [];
		$_SESSION["s_username"] = [];
		$_SESSION["s_password"] = [];

		$_SESSION["s_unique_password"] = [];

		//Petición para obtener las variables de session de los usuarios
		$sql = "SELECT * FROM usuaris_examen";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($usuario = $resultado->fetch_assoc()){
				array_push($_SESSION["s_id"], $usuario["id"]);
				array_push($_SESSION["s_nom"], $usuario["nom"]);
				array_push($_SESSION["s_username"], $usuario["username"]);
				array_push($_SESSION["s_password"], $usuario["password"]);
			}
		}


		//Petición para obtener las variables de session de los usuarios
		$sql = "SELECT * FROM contrasenyes_random";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($usuario = $resultado->fetch_assoc()){
				array_push($_SESSION["s_unique_password"], $usuario["password"]);
			}
		}
	}



	/****Función para modificar el email del usuario****/
	function ModPassword($password, $username){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_db_prova');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE usuaris_examen
				SET
					 password = \"$password\"
				WHERE
					username = \"$username\";";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

	}



	/****Función para guardar contraseña de un solo uso****/
	function SavePassword($password, $username){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_db_prova');

		//Petición para crear el nuevo usuario
		$sql = "INSERT INTO contrasenyes_random VALUES (\"$username\", \"$password\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

	}



	/****Función para eliminar las contraseñas de un solo uso****/
	function DeletePassword($password){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_db_prova');

		//Petición para borrar el rol del usuario correcto
		$sql = "DELETE FROM contrasenyes_random
				WHERE
					password = \"$password\";";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
	}



	/****Función para comprobar si ya existe el email****/
	function ComprovarPassword($password, $username){
		
		//Conexión a la base de datos
		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_db_prova');

		//Si falla la conexión, para el programa
		if($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
		}

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "SELECT * FROM contrasenyes_random
				WHERE username = \"$username\"
				AND password = \"$password\"";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows > 0){	
			return true;
		}

		return false;

	}
	/****Fin de función ComprobarEmail****/

?>
