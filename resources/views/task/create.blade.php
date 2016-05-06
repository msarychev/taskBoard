@extends('welcome')
@section('content')

    @include('partials.alerts.errors')

    {!! Form::open([
    'route' => 'task.store'
            ]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('worker_id', 'Assigned To:', ['class' => 'control-label']) !!}
        {!! Form::select('worker_id', $workers, null, ['placeholder' => 'Pick a worker...', 'class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
        {!! Form::select('status', ['ToDo' => 'ToDo', 'InProgress' => 'InProgress', 'Done' => 'Done'], 'ToDo', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>


    {!! Form::submit('Create New Task', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection