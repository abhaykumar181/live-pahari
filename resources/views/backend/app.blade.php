<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/dashboard-styles.css" />
    <link rel="stylesheet" type="text/css" href="/fontawesome/all.min.css" />
    <title>@yield('title')</title>
    @stack('styles')
</head>
<body class="sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                @include('backend.auth.sidenavbar')
                <div class="col-md-10 px-0 content-right">
                    @include('backend.auth.header')
                    @yield('content')
                    @include('backend.auth.footer')
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
    <script src="/fontawesome/all.min.js"></script>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/jquery/jquery-3.7.0.min.js"></script>
    <script src="/jquery/jquery.validate.min.js"></script>
</body>
</html>


