<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
</head>
<body>
    @if(!request()->is('/') && !request()->is('login') && !request()->is('register'))
        @include('layouts.aside-rigth')
        @include('layouts.sidebar')
        @include('layouts.header')
    @else
        @include('layouts.login-btn')
    @endif
    <div id="app">
        @yield('content')
    </div>    
    @include('layouts.footer')
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/all.js') }}" defer></script>
</body>
</html>
