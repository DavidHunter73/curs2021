<h2>Editar Juego</h2>

<form action="{{url('/juego/'.$juego->id)}}" method="post" enctype="multipart/form-data">
{{method_field('PATCH')}}
@include('juego.form')
</form>