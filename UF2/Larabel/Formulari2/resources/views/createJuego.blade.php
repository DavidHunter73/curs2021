<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Formulario</title>
	</head>

<body>

<form enctype="multipart/form-data" action="{{url('createTable')}}" method="POST" id="" name="create">
			@csrf

			<div>
				<p>Crear</p>
			</div>

			<div>
				<!--Espacio donde introducir el nombre-->
				<label>Nombre</label> 
				<input type="text" size="30" maxlength="100" name="nombre" id="" />
			</div>

			<div>
				<!--Espacio donde introducir la empresa-->
				<label>Empresa</label> 
				<input type="text" size="30" maxlength="100" name="empresa" id="" />
			</div>

			<div>
				<!--Espacio donde introducir el genero-->
				<label>Genero</label> 
				<input type="text" size="30" maxlength="100" name="genero" id="" />
			</div>

			<div>
				<button id="mysubmit" type="submit">Submit</button>
			</div>

		</form>


</body>

</html>