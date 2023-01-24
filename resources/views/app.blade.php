<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>School Management System</title>

        {{-- Fonts  --}}
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        {{-- Icon --}}
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

        {{-- Image --}}
        <link rel="shortcut icon" href="{{ asset('/images/logo.png') }}" />

    </head>
    <body>
       <div id="app">
           <app-component></app-component>
       </div>
    </body>

    <script src="{{ mix('js/app.js') }}"></script>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</html>
