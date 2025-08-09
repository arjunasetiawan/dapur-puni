<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="images/bakery.png" type="image/x-icon">
        <title>Dapur Puni</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
        body {
            background-image: url("{{ asset('images/backg9.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Figtree', sans-serif;
        }

       .login-card {
                background: transparent;
                backdrop-filter: blur(10px);
                border-radius: 6rem;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                padding: 2.5rem;
                width: 100%;
                max-width: 420px;
                font-size: 1rem;
            }

        .login-logo img {
            width: 250px;
            margin-bottom: 1rem;
            
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: bold;
            color:rgb(245, 242, 240);
            text-align: center;
        }
    </style>
    </head>
    <body class="min-h-screen flex items-center justify-center">

    <div class="login-wrapper text-left">

        <div class="login-logo">

            <!-- <img src="{{ asset('images/dapurpuni.png') }}" alt="Dapur Puni Logo"> -->
        </div>
        <div class="login-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
