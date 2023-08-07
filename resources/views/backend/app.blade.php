<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/bootstrap.css')}}" />
    <script src="jquery/jquery-3.7.0.min.js"></script>
    <title>@yield('title')</title>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>