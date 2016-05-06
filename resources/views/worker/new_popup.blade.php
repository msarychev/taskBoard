<div class="container">

    <div class="alert alert-danger" style="display: none">

    </div>

    {!! Form::open([
    'route' => 'worker.store',
    'class' => 'form__newWorker'
            ]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Create New Worker', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

</div>