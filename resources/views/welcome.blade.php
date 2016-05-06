<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="/css/main.css" rel="stylesheet" type="text/css">
    <link href="/css/popup.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">


</head>
<body>

<div class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Space-O Task Board</a>
        </div>
        {{--<div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li {{ Request::is('/') ? 'class=active' : '' }}><a href="{{url('/')}}">Home</a></li>
                <li {{ Request::is('workers') ? 'class=active' : '' }}><a href="{{route('workers')}}">Workers</a></li>
                <li {{ Request::is('tasks') ? 'class=active' : '' }}><a href="{{route('tasks')}}">Tasks</a></li>
            </ul>
        </div>--}}
    </div>
</div>

<div class="container dashboard">
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {!! Session::get('flash_message') !!}
        </div>
    @endif

    @yield('content')
</div>

</body>
<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>--}}
<script src="/js/jquery.popup.min.js"></script>
<script src="/js/jquery.jeditable.mini.js"></script>
<script src="/js/main.js"></script>
</html>
