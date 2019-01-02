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

            <div class="row">
                <div class="col-3">
                    <h3 class="mb-4">Dashboard</h3>

                    <div class="nav flex-column nav-pills">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">Index</a>
                        @hasrole('administrator')
                            <a class="nav-link" href="{{ route('dashboard.categories.index') }}">Categories</a>
                            <a class="nav-link" href="{{ route('dashboard.forums.index') }}">Forums</a>
                            <a class="nav-link" href="{{ route('dashboard.reports.index') }}">Raports</a>
                        @endhasrole
                    </div>
                </div>
                <div class="col-9">
                    @yield('content')
                </div>
            </div>
        </div>

        @section('scripts')
            <script src="{{ asset('js/app.js') }}"></script>
        @show
    </body>
</html>