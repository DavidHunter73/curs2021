<?php

	//Importa la llibreria
	include 'myAdmin_library.php';
	include 'myAdminProductos_library.php';

	//Id declarado para luego cambiarlo al correcto
	$id = 0;
	//Rol declarado en una variable
	$role = "user";
	//Variable para saber si toda la información fue obtenida para crear un pj
	$creation_error = false;


	/****Función de comprobación de un valor****/
	function Comprobar($valor, $tipo){

		$correct = true;

		if($tipo == "name"){
			//Avisa si se ha introducido un carácter especial en contraseña
			if(!preg_match("/^[a-zA-Z]+$/", $valor)){
				echo"<b style=\"color:#e60000\">La nombre debe tener solo letras.</b><br>";
				$correct = false;
			}

		} else if($tipo == "price"){
			//Avisa si no se ha introducido a un email
			if(!is_numeric($valor)) {
				echo "<b style=\"color:#e60000\">El mail que has introducido no es válido.</b><br>";
				$correct = false;
			}
		}

		return $correct;

	}
	/****Final de la función Comprobar****/


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
			BaseDatosProductos();

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
		BaseDatosProductos();

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

	//Botón de hacer logout y de volver a privada
	echo "<form class=\"form-horizontal\" enctype=\"multipart/form-data\" action=\"productos.php\" method=\"post\" id=\"aute\" name=\"logout\">";
		echo "<div style=\"float:left\">";
			echo "<button style=\"width:100px\"id=\"mysubmit\" type=\"submit\" name=\"logout\">Logout</button><br>";
		echo "</div>";
		echo "<div style=\"float:right\">";
			echo "<button style=\"width:120px\"id=\"mysubmit\" type=\"submit\" name=\"private\">Editar Cuenta</button><br>";
		echo "</div><br>";
	echo"</form>";


	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		/***LOGOUT***/
		if(isset($_REQUEST["logout"])){
			//Borra las cookies del id, mail y contraseña
			setcookie('recordar_id',null, null);
			setcookie('recordar_name',null, null);
			setcookie('recordar_mail', null, null);
			setcookie('recordar_password', null, null);
			setcookie('recordar_role',null, null);

			//Dile a la sesion que no se ha hecho login
			$_SESSION["login"] = 0;
			$_SESSION["name"] = "";
			$_SESSION["role"] = "";

			//Ve hacia la pagina publica
			header("Location:publica.php");
		}
		/***Fin de LOGOUT***/


		/***GO TO PRIVADA***/
		if(isset($_REQUEST["private"])){
			//Ve hacia la pagina privada
			header("Location:privada.php");
		}
		/***Fin de GO TO PRIVADA***/


		//Si le diste a cambiar el nombre
		if(isset($_REQUEST["name"])){
			//Si el nombre y el preció están correcto, crea el producto
			if (Comprobar($_REQUEST["name"], "name") && Comprobar($_REQUEST["price"], "price")){
				AltaProducto($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $id);

				if(isset($_REQUEST["category"])){
					foreach($_REQUEST["category"] as $category) {
						AltaProducto_Categoria(GetIdProducto($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $id), $category);
					}
				} else {
					AltaProducto_Categoria(GetIdProducto($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $id), 5);
				}
				
				if(isset($_FILES["img"])){
					//Muestra una imagen si se le ha adjuntado
					$dir = "images/";
					$fichero = $dir . basename($_FILES["img"]["name"]);

					if (move_uploaded_file($_FILES["img"]["tmp_name"], $fichero)) {
						if (ComprobarNombreImagen($_FILES["img"]["name"], GetIdProducto($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $id)) == "valido") {
							AltaImagen(basename($_FILES["img"]["name"]), GetIdProducto($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $id));
						}
					}
				}

				//Guarda el id y el rol en la session
				$id = $_SESSION["login"];
				$role = GetRole($id);

				//Actualiza la variable de sesion con la base de datos
				BaseDatos();
				BaseDatosProductos();

				//Reindica a session lo que debe ser
				$_SESSION["login"] = $id;
				$_SESSION["role"] = $role;

				echo "<b style=\"color:#00b300\">¡Producto creado con éxito!</b><br>";
			}
	
			
		} 



		/***BORRA PRODUCTO***/
		if(isset($_REQUEST["delete_product"])){
			EliminarProducto($_REQUEST["delete_product"]);

			//Guarda el id y el rol en la session
			$id = $_SESSION["login"];
			$role = GetRole($id);

			//Actualiza la variable de sesion con la base de datos
			BaseDatos();
			BaseDatosProductos();

			//Reindica a session lo que debe ser
			$_SESSION["login"] = $id;
			$_SESSION["role"] = $role;

		}
		/***Fin de BORRA PRODUCTO***/


		/***BORRA IMAGEN***/
		if(isset($_REQUEST["delete_image"])){
			EliminarImagen($_REQUEST["delete_image"], GetIdImagen($_REQUEST["delete_image"]));

			//Guarda el id y el rol en la session
			$id = $_SESSION["login"];
			$role = GetRole($id);

			//Actualiza la variable de sesion con la base de datos
			BaseDatos();
			BaseDatosProductos();

			//Reindica a session lo que debe ser
			$_SESSION["login"] = $id;
			$_SESSION["role"] = $role;

		}
		/***Fin de BORRA IMAGEN***/
		
	}



?>

	<div style="background-color:#e6f7ff; padding: 5px; border: 2px solid #00324d; border-radius: 5px">
		<!--Menú de crear productos-->
		<form class="form-horizontal" enctype="multipart/form-data" action="productos.php" method="post" id="create_product" name="crear_producte">
			<div class="col-6 col-md-4 offset-3 offset-md-4">
				<h6 style="text-align: center">CREAR UN NUEVO PRODUCTO</h6>
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el nombre-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nombre</label>
				<input class="col-4 col-md-2" type="text" 
				value="<?php if(isset($_REQUEST["name"])){
								echo $_REQUEST["name"];
							 }?>" 
				size="30" maxlength="100" name="name" id="" />
			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el mail-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Descripción</label>
				<textarea class="col-4 col-md-2" rows="4" cols="20"
				value="<?php if(isset($_REQUEST["description"])){
								echo $_REQUEST["description"];
							 }?>" 
				maxlength="200" name="description"></textarea>
			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el nombre-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Precio</label>
				<input class="col-4 col-md-2" type="text" 
				value="<?php if(isset($_REQUEST["price"])){
								echo $_REQUEST["price"];
							 }?>" 
				size="30" maxlength="100" name="price" id="" />
			</div>


			<hr>


			<div class="col-6 col-md-4 offset-3 offset-md-4">
				<p style="text-align: center">Categoría</p>
			</div>

			<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
				<!--Espacio donde elegir que accion quieres hacer-->
				<input type="checkbox" name="category[]" value="1" />	<label style="margin-right: 15px">Consumible</label>

				<input type="checkbox" name="category[]" value="2" />		<label>Herramienta</label>

			</div>

			<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
				<!--Espacio donde elegir que accion quieres hacer-->
				<input type="checkbox" name="category[]" value="3" />	<label style="margin-right: 15px">Deportes</label>

				<input type="checkbox" name="category[]" value="4" />		<label>Entretenimiento</label>

			</div>

			<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
				<!--Espacio donde elegir que accion quieres hacer-->
				<input type="checkbox" name="category[]" value="5"/>	<label style="margin-right: 15px">Otros</label>
			</div>


			<hr>


			<!--Introduce una imagen si eso-->
			<div class="form-check col-8 offset-4 col-md-7 offset-md-4">
				<label>Introducir imagen</label>	<input type="file" id="imagen "name="img" accept=".png, .jpg, .gif, .jpeg"></input>		
			</div>


			<div style="float:center" class="form-group form-inline">
				<button class="col-6 col-md-4 offset-3 offset-md-4" id="mysubmit" type="submit">Submit</button><br /><br />
			</div>
		</form>
	</div>

	<br><br>


<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Si le diste a editar un producto
			if (isset($_REQUEST["product_n_name"])){
				if(isset($_REQUEST["id_productos"])){
					//Canvia el nombre del producto elegido
					if($_REQUEST["product_n_name"] != ""){
						if(Comprobar($_REQUEST["product_n_name"], "name")){
							ModInfoProducto($_REQUEST["product_n_name"], "name", $_REQUEST["id_productos"]);

							//Guarda el id y el rol en la session
							$id = $_SESSION["login"];
							$role = GetRole($id);

							//Actualiza la variable de sesion con la base de datos
							BaseDatos();
							BaseDatosProductos();

							//Reindica a session lo que debe ser
							$_SESSION["login"] = $id;
							$_SESSION["role"] = $role;

							echo "<b style=\"color:#00b300\">¡Nombre cambiado con éxito!</b><br>";
						}
					}

					//Canvia la descripcion del producto elegido
					if($_REQUEST["product_n_description"] != ""){
						ModInfoProducto($_REQUEST["product_n_description"], "description", $_REQUEST["id_productos"]);

						//Guarda el id y el rol en la session
						$id = $_SESSION["login"];
						$role = GetRole($id);

						//Actualiza la variable de sesion con la base de datos
						BaseDatos();
						BaseDatosProductos();

						//Reindica a session lo que debe ser
						$_SESSION["login"] = $id;
						$_SESSION["role"] = $role;

						echo "<b style=\"color:#00b300\">¡Descripción editada con éxito!</b><br>";
					}

					//Canvia el precio del producto elegido
					if($_REQUEST["product_n_price"] != ""){
						if(Comprobar($_REQUEST["product_n_price"], "price")){
							ModInfoProducto($_REQUEST["product_n_price"], "price", $_REQUEST["id_productos"]);

							//Guarda el id y el rol en la session
							$id = $_SESSION["login"];
							$role = GetRole($id);

							//Actualiza la variable de sesion con la base de datos
							BaseDatos();
							BaseDatosProductos();

							//Reindica a session lo que debe ser
							$_SESSION["login"] = $id;
							$_SESSION["role"] = $role;

							echo "<b style=\"color:#00b300\">Precio editado con éxito!</b><br>";
						}
					}

					if(isset($_FILES["product_n_img"])){
						//Muestra una imagen si se le ha adjuntado
						$dir = "images/";
						$fichero = $dir . basename($_FILES["product_n_img"]["name"]);

						if (move_uploaded_file($_FILES["product_n_img"]["tmp_name"], $fichero)) {
							if (ComprobarNombreImagen($_FILES["product_n_img"]["name"], $_REQUEST["id_productos"])) {
								AltaImagen(basename($_FILES["product_n_img"]["name"]), $_REQUEST["id_productos"]);
							}
						}
					}

					//Canvia la categoría del producto elegido
					if(isset($_REQUEST["product_n_category"])){
						
						EliminarCategoriasProducto($_REQUEST["id_productos"]);

						foreach($_REQUEST["product_n_category"] as $n_category) {
							AltaProducto_Categoria($_REQUEST["id_productos"], $n_category);
						}

						//Guarda el id y el rol en la session
						$id = $_SESSION["login"];
						$role = GetRole($id);

						//Actualiza la variable de sesion con la base de datos
						BaseDatos();
						BaseDatosProductos();

						//Reindica a session lo que debe ser
						$_SESSION["login"] = $id;
						$_SESSION["role"] = $role;
					}

					//Guarda el id y el rol en la session
					$id = $_SESSION["login"];
					$role = GetRole($id);

					//Actualiza la variable de sesion con la base de datos
					BaseDatos();
					BaseDatosProductos();

					//Reindica a session lo que debe ser
					$_SESSION["login"] = $id;
					$_SESSION["role"] = $role;

				} else {
					echo "<b style=\"color:#e60000\">Por favor, seleccione un producto.</b><br>";
				}

			}

		}

?>

	<!--Menú de moficiar productos-->
	<form class="form-horizontal" enctype="multipart/form-data" action="productos.php" method="post" id="mod_pr" name="modificacion_producto" style="background-color:#ffe6e6; padding: 5px; border: 2px solid #4d0000; border-radius: 5px;">
		<div class="col-6 col-md-4 offset-3 offset-md-4">
			<h6 style="text-align: center">MODIFICAR PRODUCTOS</h6>
		</div>

		<div class="col-6 col-md-4 offset-3 offset-md-4">
			<p style="text-align: center">Elige un producto</p>
		</div>
		<!--Elije a que producto modificar-->
		<div class="col-2 offset-5">
			<div style="margin-left: 10%;">
				<select name="id_productos" size="3">
					<?php
					for($u=0; $u < count($_SESSION["p_id"]); $u++){
						if(GetInfoProduct("id_usuario", $_SESSION["p_id"][$u]) == $id){
							//Printa cada producto del usuario como una opción
							echo "<option>" . $_SESSION["p_id"][$u] . "</option>";
						}
					}
					?>
				</select>
			</div>
		</div>	


		<hr>


		<div style="float:center" class="form-group form-inline">
			<!--Espacio donde introducir el nombre-->
			<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nuevo Nombre</label>
			<input class="col-4 col-md-2" type="text" 
			value="" 
			size="30" maxlength="100" name="product_n_name" id="" />
		</div>


		<hr>


		<div style="float:center" class="form-group form-inline">
			<!--Espacio donde introducir el mail-->
			<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nueva Descripción</label>
			<textarea class="col-4 col-md-2" rows="4" cols="20"
			value="<?php if(isset($_REQUEST["product_n_description"])){
							echo $_REQUEST["product_n_description"];
						 }?>" 
			maxlength="200" name="product_n_description"></textarea>
		</div>


		<hr>


		<div style="float:center" class="form-group form-inline">
			<!--Espacio donde introducir la contraseña-->
			<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nuevo Precio</label> 
			<input class="col-4 col-md-2" type="text" 
			value=""  
			size="30" maxlength="100" name="product_n_price" id="" /><br />
		</div>

		
		<hr>

		<div class="col-6 col-md-4 offset-3 offset-md-4">
			<p style="text-align: center">Categoría</p>
		</div>

		<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
			<!--Espacio donde elegir que accion quieres hacer-->
			<input class="form-check-input" type="checkbox" name="product_n_category[]" value="1" />	<label class="form-check-label" style="margin-right: 15px">Consumible</label>

			<input class="form-check-input" type="checkbox" name="product_n_category[]" value="2" />		<label class="form-check-label">Herramienta</label>

		</div>

		<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
			<!--Espacio donde elegir que accion quieres hacer-->
			<input class="form-check-input" type="checkbox" name="product_n_category[]" value="3" />	<label class="form-check-label" style="margin-right: 15px">Deportes</label>

			<input class="form-check-input" type="checkbox" name="product_n_category[]" value="4" />		<label class="form-check-label">Entretenimiento</label>

		</div>

		<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
			<!--Espacio donde elegir que accion quieres hacer-->
			<input class="form-check-input" type="checkbox" name="product_n_category[]" value="5" />	<label class="form-check-label" style="margin-right: 15px">Otros</label>
		</div>


		<hr>


		<!--Introduce una imagen si eso-->
		<div class="form-check col-8 offset-4 col-md-7 offset-md-4">
			<label>Nueva imagen</label> <input type="file" id="imagen "name="product_n_img" accept=".png, .jpg, .gif, .jpeg"></input>	
		</div>



		<div style="float:center" class="form-group form-inline">
			<button class="col-6 col-md-4 offset-3 offset-md-4" id="mysubmit" type="submit">Submit</button><br /><br />
		</div>


	</form>

	<br><br>

	<form enctype="multipart/form-data" action="productos.php" method="post" id="el_img" name="eliminar_imagen">
		<h3>Eliminar Imagen</h3>
		<div style="margin-left: 10%;">
			<select name="delete_image" size="3">
				<?php
				for($i=0; $i < count($_SESSION["p_image_directory"]); $i++){
					if(GetInfoProduct("id_usuario", $_SESSION["p_id_image"][$i]) == $id){
						//Printa cada imagen del usuario como una opción
						echo "<option>" . $_SESSION["p_image_directory"][$i] . "</option>";
					}
				}
				?>
			</select>
		</div>

		<div>
			<button id="mysubmit" type="submit">Confirmar eliminación</button><br /><br />
		</div>
	</form>

	<!--COMIENZA LA LISTA DE PRODUCTOS DEL USUARIO-->
	<h2>Lista de tus productos</h2>

<?php

	for($p = 0; $p < count($_SESSION["p_id"]); $p++){
		if($_SESSION["p_id_user"][$p] == $id){
			echo "<h4>" . $_SESSION["p_name"][$p] . "</h4>";
			echo "<p>" . $_SESSION["p_description"][$p] . "</p>";
			
		for($i = 0; $i < count($_SESSION["p_id_image"]); $i++){
			if($_SESSION["p_id_image"][$i] == $_SESSION["p_id"][$p]){
				echo "<img src=\"images/" . $_SESSION["p_image_directory"][$i] . "\" width:\"250px\" height=\"250px\" />";
			}
		}

		echo "<h6>Precio= " . $_SESSION["p_price"][$p] . " Euros.</h6>";
		?>

		<form enctype="multipart/form-data" action="productos.php" method="post" id="el_pr" name="eliminar_producto">
			<div>
				<input type="radio" name="delete_product" value="<?php echo $_SESSION["p_id"][$p] ?>"/>	<label style="margin-right: 15px">Marcar para eliminar producto</label>
			</div>

			<div>
				<button id="mysubmit" type="submit">Confirmar eliminación</button><br /><br />
			</div>
		</form>

		<?php
		}
	}
?>