<div class="table-responsive">
    <table class="table" id="personajes-table">
        <thead>
            <tr>
                <th>Nombre</th>
        <th>Data-Nacimiento</th>
        <th>Especie</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($personajes as $personaje)
            <tr>
                <td>{{ $personaje->nombre }}</td>
            <td>{{ $personaje->data-nacimiento }}</td>
            <td>{{ $personaje->especie }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['personajes.destroy', $personaje->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('personajes.show', [$personaje->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('personajes.edit', [$personaje->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
