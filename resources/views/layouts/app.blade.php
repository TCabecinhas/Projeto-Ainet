<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/plain_white.png') }}" type="img/png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Imagine Shirts') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paginate.css') }}" rel="stylesheet">
    @stack('css')
</head>

<body>
    <div id="app">
        @include('layouts.partials.navbar')

        <main>
            <div class="container mt-4">
                @if (session('success'))
                    @include('layouts.partials.messages.success-a')
                @endif
                @if (session('error'))
                    @include('layouts.partials.messages.error-a')
                @endif
                @if ($errors->any())
                    @include('layouts.partials.messages.validation-errors-a')
                @endif
            </div>
            @yield('content')
        </main>
    </div>

</body>

</html>
