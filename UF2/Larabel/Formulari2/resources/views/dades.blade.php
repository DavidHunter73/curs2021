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
		<p>Tu archivo:</p> <a href="http://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/Formulari2/storage/app/public/{{$file}}">Link</a>
		<p>Tu imagen:</p> <img src="http://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/Formulari2/storage/app/public/{{$image}}"/>

		<br>

		<a href="{{route('form')}}">Volver al formulario</a>

    </body>
</html>