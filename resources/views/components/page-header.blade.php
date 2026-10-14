@props([
    'eyebrow' => null,
    'title',
    'lede' => null,
])

<section class="relative overflow-hidden pt-32 pb-12 md:pt-40 md:pb-16 border-b border-ink-200 bg-ink-50/50">
    <div class="absolute inset-0 security-grid security-grid-mask opacity-60" aria-hidden="true"></div>
    <div class="container-wide relative">
        @if($eyebrow)
            <span class="eyebrow">{{ $eyebrow }}</span>
        @endif
        <h1 class="{{ $lede ? 'display-lg mt-4 text-balance' : 'display-lg text-balance' }}">{{ $title }}</h1>
        @if($lede)
            <p class="lede mt-5 max-w-2xl">{{ $lede }}</p>
        @endif
    </div>
</section>
