<div class="container">

    <div class="alert alert-danger" style="display: none">

    </div>

    {!! Form::open([
        'route' => 'task.store',
        'class' => 'form__task',
                ]) !!}

    {!! Form::hidden('sort', 0) !!}
    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('worker_id', 'Assigned To:', ['class' => 'control-label']) !!}
        {!! Form::select('worker_id', $arWorkers, null, ['placeholder' => 'Pick a worker...', 'class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
        {!! Form::select('status', ['ToDo' => 'ToDo', 'InProgress' => 'InProgress', 'Done' => 'Done'], 'ToDo', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('time', 'Time:', ['class' => 'control-label']) !!}
        {!! Form::text('time', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>


    {!! Form::submit('Create New Task', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
</div>