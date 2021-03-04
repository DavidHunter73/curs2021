<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{asset('js/app.js')}}" defet></script>
    <script id="functions" user-id="{{$user_id}}" user-name="{{$user_name}}" src="{{asset('js/functions.js')}}" defer></script>
</head>
<body>
    <h2>Bienvenido {{$user_name}}</h2>
    <p id="whisper">Nadie está escribiendo</p>
    <form id="form" enctype="multipart/form-data" method="post">
        <label>Nuevo mensaje:</label><input type="text" id="mensaje"/>
        <button type='button' id="enviar">Enviar</button>
    </form>
    <br>
    <div id="muro" style="border: 3px solid black"></div>
</body>
</html>