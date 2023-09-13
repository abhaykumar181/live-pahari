<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @include('backend.layouts.includes.head')
    </head>
    <body>
        
        
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body">
                @include('backend.layouts.includes.notices')
            </div>
        </div>
    </section>
    <!-- /.content -->
      
    @include('backend.layouts.includes.scripts')
        
    </body>
</html>
