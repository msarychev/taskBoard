@extends('welcome')

@section('content')

    <h1>Edit Task - Task Name </h1>
    <p class="lead">Edit this task below. <a href="{{ route('tasks') }}">Go back to all tasks.</a></p>
    <hr>

    @include('partials.alerts.errors')

    {!! Form::model($task, [
    'method' => 'PATCH',
    'route' => ['task.update', $task->id]
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


    {!! Form::submit('Update Task', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection