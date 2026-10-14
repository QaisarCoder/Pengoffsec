<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-ink-900">Welcome back</h1>
        <p class="mt-2 text-sm text-ink-500">Log in to your PengOffSec account.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="input-field mt-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="input-field mt-2" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-ink-300 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                <span class="text-sm text-ink-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-ink-500 hover:text-brand-600 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @else
                <span></span>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
                </svg>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
