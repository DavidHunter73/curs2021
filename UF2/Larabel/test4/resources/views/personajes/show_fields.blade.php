<!-- Nombre Field -->
<div class="col-sm-12">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{{ $personaje->nombre }}</p>
</div>

<!-- Data-Nacimiento Field -->
<div class="col-sm-12">
    {!! Form::label('data-nacimiento', 'Data-Nacimiento:') !!}
    <p>{{ $personaje->data-nacimiento }}</p>
</div>

<!-- Especie Field -->
<div class="col-sm-12">
    {!! Form::label('especie', 'Especie:') !!}
    <p>{{ $personaje->especie }}</p>
</div>

