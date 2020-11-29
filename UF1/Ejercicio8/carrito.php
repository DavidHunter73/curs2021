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


	$_SESSION["precio_total"] = 0;


?>

<!DOCTYPE html>
<html>
	  <head>
			<title>Buy cool new product</title>
			<link rel="stylesheet" href="style.css">
			<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
			<script src="https://js.stripe.com/v3/"></script>
	  </head>
	  <body>

			<a href="publica.php">TO PUBLIC</a>

			<?php if(count($_SESSION["c_id"]) >= 1) { ?>
				<section>
					<?php					
						for ($c = 0; $c < count($_SESSION["c_id"]); $c++){
							if($_SESSION["c_id_usuario"][$c] == $_SESSION["login"]){
								if($_SESSION["c_completada"][$c] == 0){
									echo "<br>";
									echo "<div class=\"product\">";
										for($i = 0; $i < count($_SESSION["p_id_image"]); $i++){
											if($_SESSION["p_id_image"][$i] == $_SESSION["c_id_producto"][$c]){
												echo "<img src=\"images/" . $_SESSION["p_image_directory"][$i] . "\" width:\"250px\" height=\"250px\"";
											}
										}
										echo "<alt=\"" . GetInfoProduct("name", $_SESSION["c_id_producto"][$c]) . "\"/>";
										echo "<div class=\"" . GetInfoProduct("description", $_SESSION["c_id_producto"][$c]) . "\">";
											echo  "<h2>" . GetInfoProduct("name", $_SESSION["c_id_producto"][$c]) . "</h2>";
											echo  "<h4>" . GetInfoProduct("price", $_SESSION["c_id_producto"][$c]) . " Euros.</h4>";
										echo	"</div>";
									echo  "</div>";

									$_SESSION["precio_total"] += GetInfoProduct("price", $_SESSION["c_id_producto"][$c]);
								
								}

							}
						}
						echo "<br><br>";
						echo "<h1> Precio total: " . $_SESSION["precio_total"] . "</h1>";

					?>

					<button id="checkout-button">Checkout</button>
				</section>
			<?php } ?>

	  </body>
	  <script type="text/javascript">
			// Create an instance of the Stripe object with your publishable API key
			var stripe = Stripe("pk_test_51HpXn4JBN8VtgqpQdh5tMcTPcV601L0LWBTxA9opRURbBjywWMK6Nf8oG3ZupNtfKjnxxS35m1BJ9MYZ7eUoQ3ML00U7ryoA72");
			var checkoutButton = document.getElementById("checkout-button");
			checkoutButton.addEventListener("click", function () {
			  fetch("create-session.php", {
				method: "POST",
			  })
				.then(function (response) {
				  return response.json();
				})
				.then(function (session) {
				  return stripe.redirectToCheckout({ sessionId: session.id });
				})
				.then(function (result) {
				  // If redirectToCheckout fails due to a browser or network
				  // error, you should display the localized error message to your
				  // customer using error.message.
				  if (result.error) {
					alert(result.error.message);
				  }
				})
				.catch(function (error) {
				  console.error("Error:", error);
				});
			});
	  </script>
</html>