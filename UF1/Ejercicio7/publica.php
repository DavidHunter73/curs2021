<?php
	session_start();

	//Importa la llibreria
	include 'publica_library.php';
	//Importa la conexión con phpMyAdmin
	include 'myAdmin_library.php';
	include 'myAdminProductos_library.php';
	include 'myAdminComandas_library.php';

	$session = 0;
	$role = "user";
	$correct = false;


	if(isset($_SESSION["login"])) $session = $_SESSION["login"];

	if(isset($_SESSION["role"])) $role = $_SESSION["role"];

	//Guarda la base de datos en la sesión
	BaseDatos();

	$_SESSION["role"] = $role; 
	$_SESSION["login"] = $session;


	//Si la politica de cookies no ha sido aceptada aún...
	if (!isset($_COOKIE['politica']) && !isset($_REQUEST["p_accept"])){
		?>
			<!--Forma la petición de la política de cookies-->
			<h1>Acepta nuestra política de cookies para continuar en esta página</h1><br>
			<form enctype="multipart/form-data" action="publica.php" method="post" id="aute" name="politica">	
				<button id="mysubmit" type="submit" name="p_accept">Aceptar</button><br>
				<button id="mysubmit" type="submit" name="p_deny">Rechazar</button><br>
			</form>
		<?php

	//Si la política de cookies ya se ha aceptado...
	} else {
		//Si se ha dicho que se recuerde el mail, ve directo a la página privada
		if (isset($_COOKIE["recordar_id"]) && 
			isset($_COOKIE["recordar_name"]) && 
			isset($_COOKIE["recordar_mail"]) && 
			isset($_COOKIE["recordar_password"]) && 
			isset($_COOKIE["recordar_role"])){
			
			header("Location:privada.php");
		}

		//Si se le ha pasado información mediante un formulario...
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			//En el caso de que se le haya pasado información para hacer login
			if (isset($_REQUEST["mail"])){
				//Mira si el mail y la contraseña són correctas
				if(Comprobar($_REQUEST["mail"], $_REQUEST["password"], true)){
					//Compara el mail y la contraseña con cada uno de los usuarios.
					for($u = 0; $u < count($_SESSION["s_id"]); $u++){
						if($_REQUEST["mail"] == $_SESSION["s_mail"][$u] && md5($_REQUEST["password"]) == $_SESSION["s_password"][$u]){
							//Si le has dicho de recordar el mail
							if (isset($_REQUEST["r_usuari"])){
								//Crea la cookie del mail y la contraseña
								setcookie('recordar_id',		 $_SESSION["s_id"][$u],			time() + 365 * 24 * 60 * 60);
								setcookie('recordar_name',		 $_SESSION["s_name"][$u],		time() + 365 * 24 * 60 * 60);
								setcookie('recordar_mail',		 $_REQUEST["mail"],				time() + 365 * 24 * 60 * 60);
								setcookie('recordar_password',	 md5($_REQUEST["password"]),	time() + 365 * 24 * 60 * 60);
								setcookie('recordar_role',		 GetRole($_SESSION["s_id"][$u]),time() + 365 * 24 * 60 * 60);
							}

							//Dile a la sesion que se ha iniciado correctamente
							$_SESSION["login"] = $_SESSION["s_id"][$u];
							$_SESSION["name"] = $_SESSION["s_name"][$u];
							$_SESSION["role"] = GetRole($_SESSION["s_id"][$u]);

							//Ve hacia la página privada
							header("Location:privada.php");
						}
					}
				}
			}
			

			if(!isset($_COOKIE["no_borrar_pedidos"])){
				BorrarComandasIncompletas();
			}


			if(isset($_REQUEST["añadeCarrito"])){

				$procesoVenta = false;

				for($c = 0; $c < count($_SESSION["c_id_producto"]); $c++){
					if($_REQUEST["añadeCarrito"] == $_SESSION["c_id_producto"][$c]) $procesoVenta = true;
				}

				if (!$procesoVenta){
					AltaComanda($_SESSION["login"], $_REQUEST["añadeCarrito"], GetInfoProduct("price", $_REQUEST["añadeCarrito"]));
					ModInfoProducto(GetIdComanda($_SESSION["login"], $_REQUEST["añadeCarrito"]), "id_comanda", $_REQUEST["añadeCarrito"]);

					setcookie('no_borrar_pedidos', true, time() + 10);
					echo "Producto añadido al carrito! Realice su compra antes de los 10 minutos para completarla. <br>";

					$session = $_SESSION["login"];
					//Guarda la base de datos en la sesión
					BaseDatos();
					$_SESSION["login"] = $session;
				} else {
					echo "Lo sentimos, el producto está en proceso de venta o vendido. <br>";
				}

			}

		}

		if(isset($_SESSION["login"]) && $_SESSION["login"] != 0){
			echo "<a href=\"carrito.php\">Carrito</a>";
		}

		if($role == "admin"){
			echo "<a href=\"backoffice.php\">Backoffice</a>";
		}

	
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

		<!--Menú de Login-->
		<form class="form-horizontal" enctype="multipart/form-data" action="publica.php" method="post" id="aute" name="autentificacio">
				
			<div class="col-4 offset-4">
				<p style="text-align: center">LOGIN</p>
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el mail-->
				<label class="col-1 offset-4">Email</label> 
				<input class="col-2" type="text" value="<?php if(isset($_REQUEST["mail"]))echo $_REQUEST["mail"];?>" size="30" maxlength="100" name="mail" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir la contraseña-->
				<label class="col-1 offset-4">Contraseña</label> 
				<input class="col-2" type="password" value="<?php if(isset($_REQUEST["password"]))echo $_REQUEST["password"];?>" size="30" maxlength="100" name="password" id="" /><br />
			</div>

			<div class="form-check col-4 offset-4">
				<!--Checkbox para recordar l'usuari-->
				<input class="form-check-input" type="checkbox" name="r_usuari" value="1" /> Recordar Usuari
			</div>

			<div style="float:center" class="form-group form-inline">
				<button class="col-4 offset-4" id="mysubmit" type="submit">Completar Login</button><br /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<a class="col-4 offset-4" href="publica_alta.php">¿No tens un compte?</a>
			</div>
		</form>

		<br><br>

		<form class="form-horizontal" enctype="multipart/form-data" action="publica.php" method="post" id="search" name="busqueda">
			<div class="col-4 offset-4">
				<p style="text-align: center">PRODUCTOS</p>
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir un texto a buscar-->
				<input class="col-4 offset-4" type="text" 
						value="<?php if(isset($_REQUEST["search"])){echo $_REQUEST["search"];}?>" 
						size="30" maxlength="100" name="search" id="" />
						
				<button id="mysubmit" type="submit">Buscar</button><br />

				<div class="col-4 offset-4">
					<select name="categories" size="5">
						<option>Consumible</option>
						<option>Herramienta</option>
						<option>Deportes</option>
						<option>Entretenimiento</option>
						<option>Otros</option>
					</select>
				</div>

			</div>
		</form>		

		<?php

			for($p = 0; $p < count($_SESSION["p_id"]); $p++){

				$canAppear = true;
				$goodCategory = false;
				
				if(isset($_REQUEST["search"])){
					if($_REQUEST["search"] != ""){
						$inName = strpos($_SESSION["p_name"][$p], $_REQUEST["search"]);
						$inDescription = strpos($_SESSION["p_description"][$p], $_REQUEST["search"]);
		
						if($inName === false && $inDescription === false) {$canAppear = false;}
					}
				}


				if(isset($_REQUEST["categories"])){			
					for($c = 0; $c < count($_SESSION["p_id_category"]); $c++){
						if($_SESSION["p_id_product_category"][$c] == $_SESSION["p_id"][$p]){
							if($_REQUEST["categories"] == "Consumible" && $_SESSION["p_id_category"][$c] == 1) $goodCategory = true;
							if($_REQUEST["categories"] == "Herramienta" && $_SESSION["p_id_category"][$c] == 2) $goodCategory = true;
							if($_REQUEST["categories"] == "Deportes" && $_SESSION["p_id_category"][$c] == 3) $goodCategory = true;
							if($_REQUEST["categories"] == "Entretenimiento" && $_SESSION["p_id_category"][$c] == 4) $goodCategory = true;
							if($_REQUEST["categories"] == "Otros" && $_SESSION["p_id_category"][$c] == 5) $goodCategory = true;
						}
					}
				} else {
					$goodCategory = true;
				}

				if($canAppear && $goodCategory){
					if($_SESSION["p_name"][$p])
					echo "<h4>" . $_SESSION["p_name"][$p] . "</h4>";
					echo "<p>" . $_SESSION["p_description"][$p] . "</p>";
			
					for($i = 0; $i < count($_SESSION["p_id_image"]); $i++){
						if($_SESSION["p_id_image"][$i] == $_SESSION["p_id"][$p]){
							echo "<img src=\"images/" . $_SESSION["p_image_directory"][$i] . "\" width:\"250px\" height=\"250px\" />";
						}
					}

					echo "<h6>Precio= " . $_SESSION["p_price"][$p] . " Euros.</h6>";
					if(isset($_SESSION["login"]) && $_SESSION["login"] != 0){
						echo "<form enctype=\"multipart/form-data\" action=\"publica.php\" method=\"post\" id=\"aute\" name=\"carrito\">";
							echo "<button id=\"buy\" type=\"submit\" name=\"añadeCarrito\" value=\"" . $_SESSION["p_id"][$p] ."\">Añadir al carrito</button>";
						echo "</form>";
					}
					echo "<br><br>";
				}
			}
		?>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	</body>

</html>

<?php
	}
?>