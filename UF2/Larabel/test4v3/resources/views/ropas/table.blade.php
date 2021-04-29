<div class="table-responsive">
    <table class="table" id="ropas-table">
        <thead>
            <tr>
                <th>Name</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($ropas as $ropa)
            <tr>
                <td>{{ $ropa->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['ropas.destroy', $ropa->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('ropas.show', [$ropa->id]) }}" class='bg-success m-2'>
                            <p class="text-white">Mostrar</p>
                        </a>
                        <a href="{{ route('ropas.edit', [$ropa->id]) }}" class='bg-warning m-2'>
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
