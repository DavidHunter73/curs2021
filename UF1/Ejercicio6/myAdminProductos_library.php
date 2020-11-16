<?php

	/****Función para dar de Alta un producto nuevo****/
	function AltaProducto($name, $description, $price, $id_user){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo producto
		$sql = "INSERT INTO productos (name, description, price, id_usuario) VALUES (\"$name\", \"$description\", \"$price\", \"$id_user\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
	}/****Fin de función AltaProducto****/



	/****Función para conectar un producto con su categoria****/
	function AltaProducto_Categoria($product, $category){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo producto
		$sql = "INSERT INTO productos_categorias (id_productos, id_categorias) VALUES (\"$product\", \"$category\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
	}/****Fin de función AltaProducto_Categoria****/



	/****Función para crear una imagen de un producto****/
	function AltaImagen($directory, $product){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo producto
		$sql = "INSERT INTO imagenes (directory, id_producto) VALUES (\"$directory\", \"$product\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al insertar una imagen" . $conn->error);
		}
	}/****Fin de función AltaImagen****/



	/****Función para retornar informació****/
	function GetInfoProduct($tipus, $id){

	$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

	$info = 0;

	//Petición para el id del usuario
		$sql = "SELECT $tipus FROM productos 
				WHERE id = $id";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			while ($producto = $resultado->fetch_assoc()){
				$info = $producto["$tipus"];
			}
		}

		return $info;
	}
	/****Fin de la funcion GetInfo****/



	/****Función para retornar el id de un producto****/
	function GetIdProducto($name, $description, $price, $id_user){

	$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

	$id = 0;

	//Petición para el id del usuario
		$sql = "SELECT id FROM productos 
				WHERE name = '$name'
				AND description = '$description'
				AND price = '$price'
				AND id_usuario = '$id_user'";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al buscar id del producto" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows == 1){	
			while ($producto = $resultado->fetch_assoc()){
				$id = $producto["id"];
			}
		}

		return $id;
	}
	/****Fin de la funcion GetIdProducto****/



	/****Función para conseguir el id del producto de una imagen****/
	function GetIdImagen($name){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		$id = 0;

		//Petición para borrar el usuario correcto
		$sql = "SELECT id_producto FROM imagenes
				WHERE
					directory = \"$name\";";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows == 1){	
			while ($imagen = $resultado->fetch_assoc()){
				$id = $imagen["id_producto"];
			}
		}

		return $id;
	}
	/****Fin de GetIdImagen****/



	/****Función para comprobar si ya existe el nombre de esa imagen en el mismo usuario****/
	function ComprobarNombreImagen($name, $id){
		
		//Conexión a la base de datos
		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Si falla la conexión, para el programa
		if($conn->connect_error) {
			die("Conexión fallida: " . $conn->connect_error);
		}

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "SELECT * FROM imagenes
				WHERE directory = \"$name\"
				AND id_producto = $id";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al comprobar imagenes" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows > 0){	
			return false;
		}

		return true;

	}
	/****Fin de función ComprobarNombreImagen****/



	/****Función para modificar un valor del usuario****/
	function ModInfoProducto($valor, $tipus, $id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE productos
				SET
					 $tipus = \"$valor\"
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al modificar informacion de un producto" . $conn->error);
		}

	}
	/****Fin de ModInfoProducto****/



	/****Función para modificar un valor del usuario****/
	function ModCategoryProducto($id_product, $id_category){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE productos_categorias
				SET
					 id_categorias = $id_category
				WHERE
					id_productos = $id_product;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

	}
	/****Fin de ModCategoryProducto****/



	/****Función para eliminar un usuario****/
	function EliminarProducto($id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para borrar el rol del usuario correcto
		$sql = "DELETE FROM productos
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}


		//Petición para borrar el usuario correcto
		$sql = "DELETE FROM productos_categorias
				WHERE
					id_productos = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}


	}
	/****Fin de EliminarProducto****/



	/****Función para eliminar las categorias de un producto****/
	function EliminarCategoriasProducto($id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');


		//Petición para borrar el usuario correcto
		$sql = "DELETE FROM productos_categorias
				WHERE
					id_productos = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
	}
	/****Fin de EliminarCategoriasProducto****/



	/****Función para eliminar una imagen****/
	function EliminarImagen($name, $id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');


		//Petición para borrar el usuario correcto
		$sql = "DELETE FROM imagenes
				WHERE
					id_producto = $id
				AND
					directory = \"$name\";";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}
	}
	/****Fin de EliminarImagen****/



	/****Función para guardar todos los datos de la base de datos en la sesión****/
	function BaseDatosProductos(){
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
	/****Fin de la función BaseDatosProductos****/




?>