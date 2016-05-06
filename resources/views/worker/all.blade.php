@extends('welcome')
@section('content')
    <a href="{{ route('worker.create') }}" class="btn btn-success">Add Worker</a>
    @foreach($workers as $worker)
        <h3>{{ $worker->name }}</h3>
        <p>
            <div class="flex_row">
                <a href="{{ route('worker.edit', $worker->id) }}" class="btn btn-primary">Edit Worker</a>
                {!! Form::open([
                    'method' => 'DELETE',
                    'route' => ['worker.destroy', $worker->id],
                    'class' => 'form__delete'
                ],
                ['class' => 'form__delete']) !!}
                {!! Form::submit('Delete Worker', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </div>
        </p>
        <hr>
    @endforeach

@endsection