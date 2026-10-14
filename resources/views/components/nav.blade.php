<nav
    x-data="{ open: false, scrolled: false }"
    x-init="const onScroll = () => scrolled = window.scrollY > 8; onScroll(); window.addEventListener('scroll', onScroll, { passive: true });"
    @keydown.escape.window="open = false"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300 ease-out"
    :class="scrolled || open ? 'bg-white/95 backdrop-blur-xl border-b border-ink-200/70 shadow-nav' : 'bg-transparent border-b border-transparent'"
>
    <div class="container-wide">
        <div class="flex h-16 md:h-20 items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group shrink-0">
                <span class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center font-extrabold text-sm tracking-tighter shadow-sm shadow-brand-600/30 transition group-hover:bg-brand-700">PO</span>
                <span class="flex flex-col leading-none">
                    <span class="text-base md:text-lg font-extrabold tracking-tighter text-ink-900">PENGOFFSEC</span>
                    <span class="hidden md:block text-[10px] font-semibold uppercase tracking-[0.16em] text-ink-600 mt-1">Offensive Security</span>
                </span>
            </a>

            <!-- Desktop links -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="/services" class="nav-link {{ request()->is('services') ? 'nav-link-active' : '' }}">Services</a>
                <a href="/process" class="nav-link {{ request()->is('process') ? 'nav-link-active' : '' }}">Process</a>
                <a href="/work" class="nav-link {{ request()->is('work') ? 'nav-link-active' : '' }}">Case Studies</a>
                <a href="/about" class="nav-link {{ request()->is('about') ? 'nav-link-active' : '' }}">About</a>
                <a href="/contact" class="btn-primary btn-sm">Request an assessment</a>
            </div>

            <!-- Mobile toggle -->
            <button
                @click="open = !open"
                class="lg:hidden inline-flex items-center justify-center w-10 h-10 -mr-2 rounded-lg text-ink-700 hover:bg-ink-100 transition"
                :aria-expanded="open ? 'true' : 'false'"
                aria-controls="mobile-menu"
                aria-label="Toggle navigation menu"
            >
                <svg x-show="!open" class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-cloak x-show="open" class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity -translate-y-2" x-transition:enter-end="opacity translate-y-0"
         class="lg:hidden bg-white border-t border-ink-100 shadow-card">
        <div class="container-wide py-4 flex flex-col">
            <a href="/services" @click="open = false" class="nav-link {{ request()->is('services') ? 'nav-link-active' : '' }} py-3 border-b border-ink-100">Services</a>
            <a href="/process" @click="open = false" class="nav-link {{ request()->is('process') ? 'nav-link-active' : '' }} py-3 border-b border-ink-100">Process</a>
            <a href="/work" @click="open = false" class="nav-link {{ request()->is('work') ? 'nav-link-active' : '' }} py-3 border-b border-ink-100">Case Studies</a>
            <a href="/about" @click="open = false" class="nav-link {{ request()->is('about') ? 'nav-link-active' : '' }} py-3 border-b border-ink-100">About</a>
            <a href="/contact" class="btn-primary mt-5 w-full">Request an assessment</a>
        </div>
    </div>
</nav>
