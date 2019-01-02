<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        @section('styles')
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @show
    </head>
    <body>
        @include('partials.navbar')

        <div class="container pb-3">
            @include('partials.flash_messages')

            @yield('content')
        </div>

        @section('scripts')
            <script src="{{ asset('js/app.js') }}"></script>
        @show
    </body>
</html>