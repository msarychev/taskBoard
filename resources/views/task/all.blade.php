@extends('welcome')
@section('content')
    <a href="{{ route('task.create') }}" class="btn btn-success">Add Task</a>
    @foreach($tasks as $task)
        <h3>{{ $task->name }}</h3>
        <p class="lead">{{ $task->worker->name  or 'Not assigned' }}</p>
        <p class="lead">{{ $task->status }}</p>
        <p>
            <div class="flex_row">
                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
                {!! Form::open([
                    'method' => 'DELETE',
                    'route' => ['task.destroy', $task->id],
                    'class' => 'form__delete'
                ],
                ['class' => 'form__delete']) !!}
                {!! Form::submit('Delete Task', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </div>
        </p>
        <hr>
    @endforeach

@endsection