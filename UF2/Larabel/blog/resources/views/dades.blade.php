<?php use Illuminate\Support\Facades\Auth; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Dadas Recogidas</title>
	</head>

	<body>

		<p>Tu nombre es: {{$name}}</p>
		<p>Tu mail es: {{$mail}}</p>
		<p>Tu NIF es: {{$nif}}</p>
		<p>Tu contraseña es: {{$password}}</p>

		<br>

		<a href="{{route('form')}}">Volver al formulario</a>

    </body>
</html>