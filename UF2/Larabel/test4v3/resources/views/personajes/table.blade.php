<div class="table-responsive">
    <table class="table" id="personajes-table">
        <thead>
            <tr>
                <th>Nom</th>
        <th>Especie</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($personajes as $personaje)
            <tr>
                <td>{{ $personaje->nom }}</td>
            <td>{{ $personaje->especie }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['personajes.destroy', $personaje->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('personajes.show', [$personaje->id]) }}" class='bg-success m-2'>
                            <p class="text-white">Mostrar</p>
                        </a>
                        <a href="{{ route('personajes.edit', [$personaje->id]) }}" class='bg-warning m-2'>
                            <p class="text-white">Editar</p>
                        </a>
                        {!! Form::button('<p class="text-white">Eliminar</p>', ['type' => 'submit', 'class' => 'bg-danger m-2', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
