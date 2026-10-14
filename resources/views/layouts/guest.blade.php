<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PengOffSec') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ink-50 text-ink-900 antialiased">
    <div class="min-h-screen flex items-center justify-center px-6 py-12 relative overflow-hidden">
        <div class="absolute inset-0 security-grid security-grid-mask" aria-hidden="true"></div>
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[700px] h-[500px] glow-coral" aria-hidden="true"></div>

        <div class="relative w-full sm:max-w-md">
            <a href="/" class="flex flex-col items-center gap-3">
                <span class="w-12 h-12 rounded-xl bg-brand-600 text-white flex items-center justify-center font-extrabold tracking-tighter shadow-lg shadow-brand-600/30">PO</span>
                <span class="text-lg font-extrabold tracking-tighter text-ink-900">PENGOFFSEC</span>
            </a>

            <div class="mt-8 card p-8">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs text-ink-600">
                &copy; {{ date('Y') }} PengOffSec
            </p>
        </div>
    </div>
</body>
</html>
