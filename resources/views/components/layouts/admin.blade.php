<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin CMS - PengOffSec</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ink-50 text-ink-900">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 shrink-0 bg-white border-r border-ink-200 p-6 hidden lg:flex lg:flex-col">
            <a href="/" class="flex items-center gap-3 group">
                <span class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center font-extrabold text-sm tracking-tighter transition group-hover:bg-brand-700">PO</span>
                <span class="flex flex-col leading-none">
                    <span class="text-sm font-extrabold tracking-tighter text-ink-900">PENGOFFSEC</span>
                    <span class="text-[10px] font-semibold uppercase tracking-[0.16em] text-ink-600 mt-1">CMS</span>
                </span>
            </a>

            <nav class="mt-10 space-y-1">
                @foreach([
                    ['admin.dashboard', 'Dashboard', 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10'],
                    ['admin.hero.index', 'Homepage CMS', 'M4 5h16M4 12h16M4 19h10'],
                    ['admin.services.index', 'Services CMS', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['admin.work.index', 'Portfolio CMS', 'M4 7h6v13H4zM14 7h6v13h-6z'],
                    ['admin.leads.index', 'Project Leads', 'M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8z'],
                    ['admin.ai-leads.index', 'AI Bookings', 'M12 3v18M5 8l7-5 7 5M5 16l7 5 7-5'],
                ] as [$route, $label, $icon])
                    @php $isActive = request()->routeIs($route); @endphp
                    <a href="{{ route($route) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ $isActive ? 'bg-brand-50 text-brand-700' : 'text-ink-600 hover:bg-ink-50 hover:text-ink-900' }}">
                        <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <a href="/" class="mt-auto btn-secondary btn-sm w-full">View website</a>
        </aside>

        <!-- Mobile top bar -->
        <div class="lg:hidden fixed inset-x-0 top-0 z-40 bg-white border-b border-ink-200 px-4 py-3 flex items-center justify-between">
            <span class="text-sm font-extrabold tracking-tighter text-ink-900">PENGOFFSEC CMS</span>
            <a href="/" class="btn-secondary btn-sm">View site</a>
        </div>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 lg:p-10 p-5 pt-20 lg:pt-10">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
