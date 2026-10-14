<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-ink-900">Verify your email</h1>
        <p class="mt-2 text-sm text-ink-500">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert-success mb-6">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-ink-500 hover:text-brand-600 transition">
                {{ __('Log out') }}
            </button>
        </form>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>{{ __('Resend verification email') }}</x-primary-button>
        </form>
    </div>
</x-guest-layout>
