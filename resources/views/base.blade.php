<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="description" content="{{ $pageDescription ?? 'NextMedia Coding challenge page description' }}">
        <meta name="robots" content="index, follow" />

        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        {{-- <link rel="icon" href="" type="image/png" sizes="16x16"> --}}
        {{-- <link rel="canonical" href="#" /> --}}

        <title>{{ $pageTitle ?? 'NextMedia Coding challenge' }}</title>

        {{-- Head js, css can be injected here --}}
        @section('head_asset')
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
        @show

        {{-- Here we define all variables that we need on vuejs --}}
        <script>
            window.frontend = {
                base_url:  '{{ url('') }}/'
            }
        </script>

    </head>
    <body class="homepage">
       <div id="nmapp" class="w-full">

            {{-- Our main page content placeholder --}}
            @yield('main_content')
       
       </div>

       {{-- To include, extend or override page javascript --}}   
       @section('foot_js')
        <script src="{{ asset('assets/js/main.js') }}"></script>
       @show

    </body>
</html>
