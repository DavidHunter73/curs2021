<?php

	/****Función para darse de Alta****/
	function Alta($name, $mail, $password, $role){

		$password = md5($password);

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo usuario
		$sql = "INSERT INTO usuarios (id, name, email, password) VALUES (null, \"$name\", \"$mail\", \"$password\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Petición para crear el rol del nuevo usuario
		$sql = "INSERT INTO rol (id_usuario, role) VALUES (null, \"$role\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
	}/****Fin de función Alta****/


	/****Función para comprobar si ya existe el email****/
	function ComprobarEmail($mail, $id){
		
		//Conexión a la base de datos
		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Si falla la conexión, para el programa
		if($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
		}

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "SELECT * FROM usuarios";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($usuario = $resultado->fetch_assoc()){
				if($mail == $usuario["email"]){
					if($id != $usuario["id"]){
						return "error";
					}
				}
			}
		}

		return "valido";

	}
	/****Fin de función ComprobarEmail****/



	/****Función para retornar el id****/
	function GetId($mail){

	$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

	$id = 0;

	//Petición para el id del usuario
		$sql = "SELECT id FROM usuarios 
				WHERE email = \"$mail\"";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			while ($usuario = $resultado->fetch_assoc()){
				$id = $usuario["id"];
			}
		}

		return $id;
	}
	/****Fin de la funcion GetId****/



	/****Función para retornar informació****/
	function GetInfo($tipus, $id){

	$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

	$info = 0;

	//Petición para el id del usuario
		$sql = "SELECT $tipus FROM usuarios 
				WHERE id = $id";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			while ($usuario = $resultado->fetch_assoc()){
				$info = $usuario["$tipus"];
			}
		}

		return $info;
	}
	/****Fin de la funcion GetInfo****/



	/****Función para retornar el rol del usuario****/
	function GetRole($id){

	$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

	$role = 0;

	//Petición para el id del usuario
		$sql = "SELECT role FROM rol 
				WHERE id_usuario = $id";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			while ($usuario = $resultado->fetch_assoc()){
				$role = $usuario["role"];
			}
		}

		return $role;
	}
	/****Fin de la funcion GetRole****/



	/****Función para modificar el email del usuario****/
	function ModName($name, $id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE usuarios
				SET
					 name = \"$name\"
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

	}
	/****Fin de ModName****/



	/****Función para modificar el email del usuario****/
	function ModEmail($mail, $id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE usuarios
				SET
					 email = \"$mail\"
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

	}
	/****Fin de ModEmail****/


	/****Función para modificar la contraseña del usuario****/
	function ModPassword($password, $id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE usuarios
				SET
					password = \"$password\"
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

	}
	/****Fin de ModPassword****/



	/****Función para eliminar un usuario****/
	function Eliminar($id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para borrar el rol del usuario correcto
		$sql = "DELETE FROM rol
				WHERE
					id_usuario = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}


		//Petición para borrar el usuario correcto
		$sql = "DELETE FROM usuarios
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}


	}
	/****Fin de Eliminar****/



	/****Función para guardar todos los datos de la base de datos en la sesión****/
	function BaseDatos(){
		//Conexión a la base de datos
		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Si falla la conexión, para el programa
		if($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
		}

		session_unset();
		session_destroy();
		session_start();

		$_SESSION["s_id"] = [];
		$_SESSION["s_name"] = [];
		$_SESSION["s_mail"] = [];
		$_SESSION["s_password"] = [];

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "SELECT * FROM usuarios";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($usuario = $resultado->fetch_assoc()){
				array_push($_SESSION["s_id"], $usuario["id"]);
				array_push($_SESSION["s_name"], $usuario["name"]);
				array_push($_SESSION["s_mail"], $usuario["email"]);
				array_push($_SESSION["s_password"], $usuario["password"]);
			}
		}


		$_SESSION["p_id"] = [];
		$_SESSION["p_name"] = [];
		$_SESSION["p_description"] = [];
		$_SESSION["p_price"] = [];
		$_SESSION["p_id_user"] = [];

		$_SESSION["p_id_category"] = [];
		$_SESSION["p_id_product_category"] = [];

		$_SESSION["p_id_image"] = [];
		$_SESSION["p_image_directory"] = [];

		//Petición para obtener todo de los productos
		$sql = "SELECT * FROM productos";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($producto = $resultado->fetch_assoc()){
				array_push($_SESSION["p_id"], $producto["id"]);
				array_push($_SESSION["p_name"], $producto["name"]);
				array_push($_SESSION["p_description"], $producto["description"]);
				array_push($_SESSION["p_price"], $producto["price"]);
				array_push($_SESSION["p_id_user"], $producto["id_usuario"]);
			}
		}



		//Petición para obtener la categoria de los productos
		$sql = "SELECT * FROM productos_categorias";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($producto = $resultado->fetch_assoc()){
				array_push($_SESSION["p_id_category"], $producto["id_categorias"]);
				array_push($_SESSION["p_id_product_category"], $producto["id_productos"]);
			}
		}



		//Petición para obtener todo de los productos
		$sql = "SELECT * FROM imagenes";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			//Por cada fila...
			while ($imagen = $resultado->fetch_assoc()){
				array_push($_SESSION["p_id_image"], $imagen["id_producto"]);
				array_push($_SESSION["p_image_directory"], $imagen["directory"]);
			}
		}

	}
	/****Fin de la función BaseDatos****/




?>