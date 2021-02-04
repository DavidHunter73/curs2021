<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control','maxlength' => 80,'maxlength' => 80]) !!}
</div>

<!-- Data-Nacimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data-nacimiento', 'Data-Nacimiento:') !!}
    {!! Form::text('data-nacimiento', null, ['class' => 'form-control','id'=>'data-nacimiento']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#data-nacimiento').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Especie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('especie', 'Especie:') !!}
    {!! Form::text('especie', null, ['class' => 'form-control','maxlength' => 80,'maxlength' => 80]) !!}
</div>