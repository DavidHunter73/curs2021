<?php

	/****Función para dar de Alta un comanda nueva****/
	function AltaComanda($id_user, $id_product, $price){

		$dia = date("d");
		$mes = date("m");
		$any = date("Y");

		$date = $dia . "/" . $mes . "/" . $any;

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo producto
		$sql = "INSERT INTO comanda (id_usuario, id_producto, precio, data) VALUES ($id_user, $id_product, $price, \"$date\")";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al crear comanda" . $conn->error);
		}
	}/****Fin de función AltaComanda****/


	/****Función para conseguir el id de una comanda****/
	function GetIdComanda($user, $product){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		$id = 0;

		//Petición para borrar el usuario correcto
		$sql = "SELECT id FROM comanda
				WHERE
					id_usuario = \"$user\"
				AND	
					id_producto = \"$product\";";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows == 1){	
			while ($comanda = $resultado->fetch_assoc()){
				$id = $comanda["id"];
			}
		}

		return $id;
	}
	/****Fin de GetIdComanda****/



	/****Función para completar la comanda****/
	function CompletarComanda($id){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE comanda
				SET
					 completada = 1
				WHERE
					id = $id;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al modificar informacion de un producto" . $conn->error);
		}

	}
	/****Fin de CompletarComanda****/



	/****Función para borrar las comandas incompletas****/
	function BorrarComandasIncompletas(){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "DELETE FROM comanda
				WHERE
					completada = 0;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al modificar informacion de un producto" . $conn->error);
		}

	}
	/****Fin de BorrarComandasIncompletas****/



	/****Función para dar de Alta un comanda nueva****/
	function AltaTransaccion($id_user, $price, $correcta){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para crear el nuevo producto
		$sql = "INSERT INTO transacciones (id_usuario, precio, correcta) VALUES ($id_user, $price, $correcta)";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al crear comanda" . $conn->error);
		}
	}/****Fin de función AltaComanda****/




	/****Función para retornar informació****/
	function GetInfoTransaccion($tipus, $id){

	$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

	$info = 0;

	//Petición para el id del usuario
		$sql = "SELECT $tipus FROM transacciones 
				WHERE id = $id";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al consultar" . $conn->error);
		}

		//Si la petición te ha dado uno o más resultados
		if($resultado->num_rows >= 0){	
			while ($transaccion = $resultado->fetch_assoc()){
				$info = $transaccion["$tipus"];
			}
		}

		return $info;
	}
	/****Fin de la funcion GetInfoTransaccion****/



	/****Aumenta la cantidad de dinero de este usuario****/
	function SubirDinero($user, $money){

		$conn = new mysqli('localhost', 'dhernandez', 'dhernandez', 'dhernandez_M07_A5');

		//Petición para obtener el mail y la contraseña de los usuarios
		$sql = "UPDATE usuarios
				SET
					 dinero_ganado = dinero_ganado + $money
				WHERE
					id = $user;";

		//Si la petición falla, para el programa
		if (!$resultado = $conn->query($sql)){
			die("Error al modificar informacion de un producto" . $conn->error);
		}
	
	}
	/****Fin de SubirDinero****/

?>