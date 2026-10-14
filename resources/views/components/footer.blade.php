<footer class="border-t border-ink-200 bg-ink-50/60 mt-auto">
    <div class="container-wide py-16 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
            <!-- Brand -->
            <div class="md:col-span-5">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <span class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center font-extrabold text-sm tracking-tighter transition group-hover:bg-brand-700">PO</span>
                    <span class="text-lg font-extrabold tracking-tighter text-ink-900">PENGOFFSEC</span>
                </a>
                <p class="mt-5 text-sm text-ink-500 leading-relaxed max-w-sm">
                    Offensive security assessments and secure software engineering for organisations that depend on their technology.
                </p>
                <a href="/contact" class="btn-dark btn-sm mt-6">Request an assessment</a>
            </div>

            <!-- Services -->
            <div class="md:col-span-3">
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-600">Services</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="/services" class="text-ink-600 hover:text-brand-600 transition">Cybersecurity</a></li>
                    <li><a href="/services" class="text-ink-600 hover:text-brand-600 transition">Software Development</a></li>
                    <li><a href="/process" class="text-ink-600 hover:text-brand-600 transition">Assessment Process</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="md:col-span-2">
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-600">Company</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="/about" class="text-ink-600 hover:text-brand-600 transition">About</a></li>
                    <li><a href="/work" class="text-ink-600 hover:text-brand-600 transition">Case Studies</a></li>
                    <li><a href="/contact" class="text-ink-600 hover:text-brand-600 transition">Contact</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="md:col-span-2">
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-600">Legal</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="#" class="text-ink-600 hover:text-brand-600 transition">Privacy</a></li>
                    <li><a href="#" class="text-ink-600 hover:text-brand-600 transition">Terms</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-14 pt-8 border-t border-ink-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-ink-600">
            <p>&copy; {{ date('Y') }} PengOffSec. All rights reserved.</p>
            <p class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Systems operational
            </p>
        </div>
    </div>
</footer>
