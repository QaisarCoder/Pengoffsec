<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-8">
                <div class="flex items-center gap-4">
                    <span class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <div>
                        <p class="text-lg font-bold text-ink-900">{{ __('Welcome back, :name', ['name' => Auth::user()->name]) }}</p>
                        <p class="text-sm text-ink-500">{{ __("You're logged in.") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
