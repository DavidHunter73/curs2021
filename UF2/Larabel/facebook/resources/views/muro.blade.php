<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Muro de Facebook</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{asset('js/app.js')}}" defet></script>
    <script id="functions" user-id="{{$user_id}}" user-name="{{$user_name}}" src="{{asset('js/functions.js')}}" defer></script>
</head>
<body>
    <div style="float:left; width:90%">
        <h2>Bienvenido {{$user_name}}</h2>
        <p id="whisper">Nadie está escribiendo</p>
        <form id="form" enctype="multipart/form-data" method="post">
            <label>Nuevo mensaje:</label><input type="text" id="mensaje"/>
            <br>
            <label>Imagen JPG/PNG/GIF</label><input type="file" accept=".jpg,.png,.gif" id="imagen">
            <br>
            <button type='button' id="enviar">Enviar</button>
        </form>
        <br>
        <div id="muro" style="border: 3px solid black"></div>
    </div>

    <div style="float:right; width:10%" id="userList" />

</body>
</html>