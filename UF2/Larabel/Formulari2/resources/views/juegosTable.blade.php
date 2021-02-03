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

<a href="{{route('storeForm')}}">Crear Juego</a>

@foreach ($juegos as $juego)
<div>
    <p>Juego {{$juego->id}}: {{$juego->nombre}}, {{$juego->empresa}}, {{$juego->genero}}</p>
	<a href="{{url('editForm')}}/{{$juego->id}}">Editar</a>
	<a href="{{url('delete')}}/{{$juego->id}}">Eliminar</a>
</div>
<br>
@endforeach





</body>

</html>