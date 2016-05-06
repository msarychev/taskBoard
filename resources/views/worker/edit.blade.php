@extends('welcome')

@section('content')

    <h1>Edit Task - Task Name </h1>
    <p class="lead">Edit this worker below. <a href="{{ route('workers') }}">Go back to all workers.</a></p>
    <hr>

    @include('partials.alerts.errors')

    {!! Form::model($worker, [
    'method' => 'PATCH',
    'route' => ['worker.update', $worker->id]
    ]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>


    {!! Form::submit('Update Worker', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection