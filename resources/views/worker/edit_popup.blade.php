<div class="container">

    <div class="alert alert-danger" style="display: none">

    </div>

    {!! Form::open([
        'method' => 'PATCH',
        'class' => 'form__updateWorker'
    ]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>


    {!! Form::submit('Update Worker', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
</div>