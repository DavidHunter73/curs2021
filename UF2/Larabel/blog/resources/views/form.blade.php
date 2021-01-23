<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Formulario</title>
	</head>

	<script>
		$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
	</script>

	<body>

		<!--Menú de Login-->
		<form enctype="multipart/form-data" action="{{route('postform')}}" method="POST" id="form" name="formulario">
			@csrf

			<div>
				<p>Dades</p>
			</div>

			<div>
				<!--Espacio donde introducir el nombre-->
				<label>Nombre</label> 
				<input type="text" size="30" maxlength="100" name="name" id="" />
			</div>

			<div>
				<!--Espacio donde introducir el mail-->
				<label>Mail</label> 
				<input type="text" size="30" maxlength="100" name="mail" id="" />
			</div>

			<div>
				<!--Espacio donde introducir el NIF-->
				<label>NIF</label> 
				<input type="password" size="30" maxlength="100" name="nif" id="" />
			</div>

			<div>
				<!--Espacio donde introducir la contraseña-->
				<label>Contraseña</label> 
				<input type="password" size="30" maxlength="100" name="password" id="" />
			</div>

			<div>
				<label>Fichero de máximo 1MB</label>
				<input type="file" id="" name="file" accept="" />
			</div>

			<div>
				<label>Imagen de mínimo 1920x1080</label>
				<input type="file" id="" name="image" accept=".png, .jpg" />
			</div>

			<div>
				<button id="mysubmit" type="submit">Submit</button>
			</div>

		</form>
	</body>
</html>