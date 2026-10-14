<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PengOffSec - Security & Engineering')</title>

    <meta name="description" content="PengOffSec delivers offensive security assessments and secure software engineering for organisations that depend on their technology.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-ink-900 antialiased min-h-screen flex flex-col">
    <x-nav />

    <main class="flex-1">
        {{ $slot }}
    </main>


    <x-footer />
    <x-ai-assistant />
</body>
</html>
