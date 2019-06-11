<!DOCTYPE html>
<html lang="{{ locale()->current() }}" dir="{{ locale()->dir() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Prode') }}</title>

    <!-- Styles -->
    <link href="{{ asset('plugins/bootstrap-4.3.1/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/web.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('web.partials.topnav')

    @yield('content')

    @include('web.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/bootstrap-4.3.1/bootstrap.js') }}" type="text/javascript"></script>
    @yield ('scripts')
</body>
</html>
