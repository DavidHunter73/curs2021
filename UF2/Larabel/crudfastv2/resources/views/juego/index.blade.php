<h1>INDEX DE JUEGOS</h1>

<a href="{{url('/juego/create')}}">Crear Juego</a>
<br><br>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Nombre</th>
            <th>Genero</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>

    <tbody>
        @foreach($juegos as $juego)
        <tr>
            <td>{{$juego->nombre}}</td>
            <td>{{$juego->genero}}</td>
            <td>
                <form action="{{url('/juego/'.$juego->id.'/edit')}}" method="get">
                    @csrf
                    <input type ="submit" value="Editar">
                </form>
            </td>
           
            <td>
                <form action="{{url('/juego/'.$juego->id)}}" method="post">
                    @csrf
                    {{method_field('DELETE')}}
                    <input type ="submit" onclick="return confirm('¿Quieres eliminar el juego?')" value="Eliminar">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>