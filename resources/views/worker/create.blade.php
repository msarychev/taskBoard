@extends('welcome')
@section('content')

    @include('partials.alerts.errors')

    {!! Form::open([
    'route' => 'worker.store'
            ]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Create New Worker', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@endsection