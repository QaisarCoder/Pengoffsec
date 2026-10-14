<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-3 bg-brand-600 border border-transparent rounded-full font-semibold text-sm text-white hover:bg-brand-700 hover:shadow-lg hover:shadow-brand-600/20 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
