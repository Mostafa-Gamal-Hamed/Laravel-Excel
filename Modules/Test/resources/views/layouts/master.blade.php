<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Test Module - {{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="{{ $author ?? '' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- Css --}}
    <link rel="stylesheet" href="{{asset("bootstrap/style.css")}}">

    {{-- Vite CSS --}}
    {{-- {{ module_vite('build-test', 'resources/assets/sass/app.scss') }} --}}
</head>

<body>
    @yield('content')

    {{-- JS --}}
    <script src="{{asset('bootstrap/style.js')}}"></script>
    {{-- Vite JS --}}
    {{-- {{ module_vite('build-test', 'resources/assets/js/app.js') }} --}}
</body>
