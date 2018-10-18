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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/circliful.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="page-wrapper">
        @guest
            @include('layouts.partials.topnav')
        @else
            @include('layouts.partials.sidebar')
        @endguest

        <main class="page-content py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-4.1.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/circliful.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sidebar.js') }}" type="text/javascript"></script>
    @yield ('scripts')
</body>
</html>
