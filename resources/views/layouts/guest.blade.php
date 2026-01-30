<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Universal Fitness</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS / JS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>



<body class="font-sans antialiased" style="background-color: #f5f7fa;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8">
        
        @php
            $isAuthPage = Str::contains($slot, 'auth-container');
        @endphp

        @if ($isAuthPage)
            {{ $slot }}
        @else
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        @endif

    </div>
</body>
</html>

