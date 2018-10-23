<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Prode') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap-4.1.3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/web.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('layouts.partials.topnav')

    @yield('content')

    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-4.1.3.js') }}" type="text/javascript"></script>
    @yield ('scripts')
</body>
</html>
