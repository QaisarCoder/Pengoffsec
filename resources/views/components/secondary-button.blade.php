<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-3 bg-white border border-ink-300 rounded-full font-semibold text-sm text-ink-800 hover:bg-ink-50 hover:border-ink-900 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
