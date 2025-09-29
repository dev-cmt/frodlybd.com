<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset($settings ? $settings->favicon : '') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('backEnd/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('backEnd/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('backEnd/css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('backEnd/css/icons.min.css') }}" rel="stylesheet" >

    @stack('css')
</head>
<body>

    <div class="container">
        {{ $slot }}
    </div>

    <!-- Jquery JS -->
    <script src="{{ asset('backEnd/js/jquery.js') }}"></script>

    <!-- Custom-Switcher JS -->
    <script src="{{ asset('backEnd/js/custom-switcher.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('backEnd/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('backEnd/js/show-password.js') }}"></script>

    @stack('js')
</body>
</html>
