<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- CSS / JS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!--<link rel="stylesheet" href="{{ asset('css/app.css') }}">-->
         @vite(['resources/css/app.css', 'resources/js/app.js
    </head>

    <body class="font-sans antialiased" style="background-color: #f5f7fa;">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8">

            <!-- Panel wrapper -->
            {{-- Detect if the slot contains an auth-container --}}
@php
    $isAuthPage = Str::contains($slot, 'auth-container');
@endphp

@if ($isAuthPage)
    {{-- Render FULLSCREEN auth layout (login + register) --}}
    {{ $slot }}
@else
    {{-- Default small centered card (password reset, verify email etc.) --}}
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
@endif


        </div>

    </body>
</html>

