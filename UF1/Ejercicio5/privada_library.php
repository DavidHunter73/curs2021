<?php

	//Importa la llibreria
	include 'myAdmin_library.php';

	//Id declarado para luego cambiarlo al correcto
	$id = 0;
	//Rol declarado en una variable
	$role = "user";
	//Variable para saber si toda la información fue obtenida para crear un pj
	$creation_error = false;


	/****Función de comprobación de un mail o un password****/
	function Comprobar($valor, $tipo){

		$correct = true;

		if($tipo == "name"){
			//Avisa si se ha introducido un carácter especial en contraseña
			if(!preg_match("/^[a-zA-Z]+$/", $valor)){
				echo"<b style=\"color:#e60000\">La nombre debe tener solo letras.</b><br>";
				$correct = false;
			}

		} else if($tipo == "mail"){
			//Avisa si no se ha introducido a un email
			if(!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
				echo "<b style=\"color:#e60000\">El mail que has introducido no es válido.</b><br>";
				$correct = false;
			}

		} else if($tipo == "password"){
			//Avisa si se ha introducido un carácter especial en contraseña
			if(!preg_match("/^[a-zA-Z0-9]+$/", $valor)){
				echo"<b style=\"color:#e60000\">La contraseña debe tener solo letras y números.</b><br>";
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
		
		//Actualiza la variable de sesion con la base de datos
		BaseDatos();

		//Guarda el id y el rol en la session
		$id = $_COOKIE["recordar_id"];
		$role = $_SESSION["role"] = $_COOKIE["recordar_role"];
		//Da la bienvenida al usuario
		echo "<nav style=\"background-color: #262626;
						       color: white;
							   margin-top:0px; 
							   padding: 10px;\">
				<h4 style=\"text-align:center\">Bienvenido " . $_COOKIE["recordar_name"] . "!</h4>
			  </nav>";
	}

	//Botón de hacer logout
	echo "<form class=\"form-horizontal\" enctype=\"multipart/form-data\" action=\"privada.php\" method=\"post\" id=\"aute\" name=\"logout\">";
		echo "<div style=\"float:left\">";
			echo "<button style=\"width:100px\"id=\"mysubmit\" type=\"submit\" name=\"logout\">Logout</button><br>";
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


		//Si le diste a cambiar el nombre
		if(isset($_REQUEST["n_name"])){
			//Si el nombre está correcto, cambialo
			if (Comprobar($_REQUEST["n_name"], "name") && $_REQUEST["n_name"] != GetInfo("name", $id)){
				$_SESSION["name"] = "";
				$_SESSION["name"] = $_REQUEST["n_name"];
				if (isset($_COOKIE["recordar_name"])){	
					setcookie('recordar_name',null, null);
					setcookie('recordar_name', $_REQUEST["n_name"], time() + 365 * 24 * 60 * 60);
				}

				ModName($_REQUEST["n_name"], $id);
				echo "<b style=\"color:#00b300\">¡Nombre cambiado con éxito!</b><br>";
			}	
		} 

		//Si le diste a cambiar el email
		if (isset($_REQUEST["n_mail"])){
			//Si El mail está correcto, cambialo
			if (Comprobar($_REQUEST["n_mail"], "mail") && $_REQUEST["n_mail"] != GetInfo("email", $id)){
				if(ComprobarEmail($_REQUEST["n_mail"], $id) == "valido"){
					if (isset($_COOKIE["recordar_mail"])){	
						setcookie('recordar_mail',null, null);
						setcookie('recordar_mail', $_REQUEST["n_mail"], time() + 365 * 24 * 60 * 60);
					}

					ModEmail($_REQUEST["n_mail"], $id);
					echo "<b style=\"color:#00b300\">¡Email cambiado con éxito!</b><br>";
				} else {
					echo "<b style=\"color:#e60000\">El email que has introducido lo tiene otro usuario.</b><br>";
				}
			}	
		} 

		//Si le diste a cambiar la contraseña
		if (isset($_REQUEST["n_password"])){
			if($_REQUEST["n_password"] != ""){
				//Si la contraseña está correcta, cambiala
				if (Comprobar($_REQUEST["n_password"], "password") && md5($_REQUEST["n_password"]) != GetInfo("password", $id)){
					if ($_REQUEST["n_password"] == $_REQUEST["rep_n_password"]){
						if (isset($_COOKIE["recordar_password"])){	
							setcookie('recordar_password',null, null);
							setcookie('recordar_password', md5($_REQUEST["n_password"]), time() + 365 * 24 * 60 * 60);
						}

						ModPassword(md5($_REQUEST["n_password"]), $id);
						echo "<b style=\"color:#00b300\">¡Contraseña cambiada con éxito!</b><br>";
					} else {
						echo "<b style=\"color:#e60000\">Las dos contraseñas introducidas són diferentes.</b><br>";
					}
				}
			}
		}
	}


?>

	<div style="background-color:#e6f7ff; padding: 5px; border: 2px solid #00324d; border-radius: 5px">
		<!--Menú de moficiar nombre-->
		<form class="form-horizontal" enctype="multipart/form-data" action="privada.php" method="post" id="mod_nom" name="modificacio_usuari">
			<div class="col-6 col-md-4 offset-3 offset-md-4">
				<h6 style="text-align: center">MODIFICAR DATOS DE LA CUENTA</h6>
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el nombre-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nuevo Nombre</label>
				<input class="col-4 col-md-2" type="text" 
				value="<?php if(isset($_REQUEST["n_name"])){
								echo $_REQUEST["n_name"];
							 } else {
								echo GetInfo("name", $id);
							 }?>" 
				size="30" maxlength="100" name="n_name" id="" />
			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el mail-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nuevo Email</label>
				<input class="col-4 col-md-2" type="text" 
				value="<?php if(isset($_REQUEST["n_mail"])){
								echo $_REQUEST["n_mail"];
							 } else {
								echo GetInfo("email", $id);
							 }?>" 
				size="30" maxlength="100" name="n_mail" id="" />
			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir la contraseña-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nueva Contraseña</label> 
				<input class="col-4 col-md-2" type="password" 
				value=""  
				size="30" maxlength="100" name="n_password" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde repetir la contraseña-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Repetir Contraseña</label> 
				<input class="col-4 col-md-2" type="password" 
				value=""  
				size="30" maxlength="100" name="rep_n_password" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<button class="col-6 col-md-4 offset-3 offset-md-4" id="mysubmit" type="submit">Submit</button><br /><br />
			</div>
		</form>
	</div>

		<br><br>


<!--Parte exclusiva para el administrador-->
<?php
	if($_SESSION["role"] == "admin"){
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Si le diste a editar otro usuario
			if (isset($_REQUEST["user_n_name"])){
				if(isset($_REQUEST["admin_accion"])){
					switch($_REQUEST["admin_accion"]){
						/**Si quieres crear un usuario**/
						case "crear":
						
							if(!Comprobar($_REQUEST["user_n_name"], "name")) $creation_error = true;

							if(!Comprobar($_REQUEST["user_n_mail"], "mail") || 
							   ComprobarEmail($_REQUEST["user_n_mail"], 0) != "valido") $creation_error = true;

							if(!Comprobar($_REQUEST["user_n_password"], "password") || 
							   $_REQUEST["user_n_password"] != $_REQUEST["rep_user_n_password"]) $creation_error = true;

							if(!$creation_error){
								Alta($_REQUEST["user_n_name"], $_REQUEST["user_n_mail"], $_REQUEST["user_n_password"], "user");

								//Guarda el id y el rol en la session
								$id = $_SESSION["login"];
								$role = GetRole($id);

								//Actualiza la variable de sesion con la base de datos
								BaseDatos();

								//Reindica a session lo que debe ser
								$_SESSION["login"] = $id;
								$_SESSION["role"] = $role;

								echo "<b style=\"color:#00b300\">¡Creado con éxito!</b><br>";
							} else {
								echo "<b style=\"color:#e60000\">Por favor, seleccione un usuario.</b><br>";
							}

								break;

						/**Si quieres eliminar un usuario**/
						case "eliminar":
							if(isset($_REQUEST["id_usuarios"])){
								if(isset($_REQUEST["id_usuarios"])){
									Eliminar(GetId($_REQUEST["id_usuarios"]));

									//Guarda el id y el rol en la session
									$id = $_SESSION["login"];
									$role = GetRole($id);

									//Actualiza la variable de sesion con la base de datos
									BaseDatos();

									//Reindica a session lo que debe ser
									$_SESSION["login"] = $id;
									$_SESSION["role"] = $role;

									echo "<b style=\"color:#00b300\">¡Eliminado con éxito!</b><br>";
								} else {
									echo "<b style=\"color:#e60000\">Por favor, seleccione un usuario.</b><br>";
								}
							} else {
								echo "<b style=\"color:#e60000\">Por favor, seleccione un usuario.</b><br>";
							}
							break;

						default:
							break;
					}
				} else{
					if(isset($_REQUEST["id_usuarios"])){
						//Canvia el nombre del usuario elegido
						if($_REQUEST["user_n_name"] != ""){
							if(Comprobar($_REQUEST["user_n_name"], "name")){
								ModName($_REQUEST["user_n_name"], GetId($_REQUEST["id_usuarios"]));

								//Guarda el id y el rol en la session
								$id = $_SESSION["login"];
								$role = GetRole($id);

								//Actualiza la variable de sesion con la base de datos
								BaseDatos();

								//Reindica a session lo que debe ser
								$_SESSION["login"] = $id;
								$_SESSION["role"] = $role;

								echo "<b style=\"color:#00b300\">¡Nombre editado con éxito!</b><br>";
							}
						}

						//Canvia el email del usuario elegido
						if($_REQUEST["user_n_mail"] != ""){
							if(Comprobar($_REQUEST["user_n_mail"], "mail")){
								if(ComprobarEmail($_REQUEST["user_n_mail"], GetId($_REQUEST["id_usuarios"])) == "valido"){
									ModEmail($_REQUEST["user_n_mail"], GetId($_REQUEST["id_usuarios"]));

									//Guarda el id y el rol en la session
									$id = $_SESSION["login"];
									$role = GetRole($id);

									//Actualiza la variable de sesion con la base de datos
									BaseDatos();

									//Reindica a session lo que debe ser
									$_SESSION["login"] = $id;
									$_SESSION["role"] = $role;

									echo "<b style=\"color:#00b300\">¡Email editado con éxito!</b><br>";

								} else {
									echo "<b style=\"color:#e60000\">El email que has introducido lo tiene otro usuario.</b><br>";
								}
							}
						}

						//Canvia la contraseña del usuario elegido
						if($_REQUEST["user_n_password"] != ""){
							if(Comprobar($_REQUEST["user_n_password"], "password")){
								if($_REQUEST["user_n_password"] == $_REQUEST["rep_user_n_password"]){
									ModPassword(md5($_REQUEST["user_n_password"]), GetId($_REQUEST["id_usuarios"]));

									//Guarda el id y el rol en la session
									$id = $_SESSION["login"];
									$role = GetRole($id);

									//Actualiza la variable de sesion con la base de datos
									BaseDatos();

									//Reindica a session lo que debe ser
									$_SESSION["login"] = $id;
									$_SESSION["role"] = $role;

									echo "<b style=\"color:#00b300\">Contraseña editada con éxito!</b><br>";

								} else {
									echo "<b style=\"color:#e60000\">Las dos contraseñas introducidas són diferentes.</b><br>";
								}
							}
						}
					}  else {
						echo "<b style=\"color:#e60000\">Por favor, seleccione un usuario.</b><br>";
					}
				}

			}

		}

?>

		<!--Menú de moficiar usuarios-->
		<form class="form-horizontal" enctype="multipart/form-data" action="privada.php" method="post" id="mod_us" name="modificacio_usuari" style="background-color:#ffe6e6; padding: 5px; border: 2px solid #4d0000; border-radius: 5px;">
			<div class="col-6 col-md-4 offset-3 offset-md-4">
				<h6 style="text-align: center">MODIFICAR USUARIOS</h6>
			</div>

			<div class="col-6 col-md-4 offset-3 offset-md-4">
				<p style="text-align: center">Elige un usuario</p>
			</div>
			<!--Elije a que usuario modificar-->
			<div class="col-2 offset-5">
				<div style="margin-left: 10%;">
					<select name="id_usuarios" size="3">
						<?php
						for($u=0; $u < count($_SESSION["s_id"]); $u++){
							if(GetRole($_SESSION["s_id"][$u]) != "admin"){
								//Printa cada usuario como una opción
								echo "<option>" . $_SESSION["s_mail"][$u] . "</option>";
							}
						}
						?>
					</select>
				</div>
			</div>	

			<br>

			<div class="form-check col-8 offset-4 col-md-7 offset-md-5">
				<!--Espacio donde elegir que accion quieres hacer-->
				<input class="form-radio-input" type="radio" name="admin_accion" value="crear" />	<label class="form-radio-label" style="margin-right: 15px">Crear</label>

				<input class="form-radio-input" type="radio" name="admin_accion" value="eliminar" />		<label class="form-radio-label">Eliminar</label>

			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el nombre-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nuevo Nombre</label>
				<input class="col-4 col-md-2" type="text" 
				value="" 
				size="30" maxlength="100" name="user_n_name" id="" />
			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir el mail-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nuevo Email</label>
				<input class="col-4 col-md-2" type="text" 
				value="" 
				size="30" maxlength="100" name="user_n_mail" id="" />
			</div>


			<hr>


			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde introducir la contraseña-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Nueva Contraseña</label> 
				<input class="col-4 col-md-2" type="password" 
				value=""  
				size="30" maxlength="100" name="user_n_password" id="" /><br />
			</div>

			<div style="float:center" class="form-group form-inline">
				<!--Espacio donde repetir la contraseña-->
				<label style="text-align: right" class="col-3 offset-3 col-sm-2 offset-md-4">Repetir Contraseña</label> 
				<input class="col-4 col-md-2" type="password" 
				value=""  
				size="30" maxlength="100" name="rep_user_n_password" id="" /><br />
			</div>


			<div style="float:center" class="form-group form-inline">
				<button class="col-6 col-md-4 offset-3 offset-md-4" id="mysubmit" type="submit">Submit</button><br /><br />
			</div>


		</form>

<?php
	}
?>