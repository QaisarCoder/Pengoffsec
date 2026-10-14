<x-layouts.app title="Work - PengOffSec">
    <x-page-header
        eyebrow="Case studies"
        title="Our work"
        lede="Explore our portfolio of cybersecurity assessments, security engineering, and software development projects."
    />

    <div class="section">
        <div class="container-wide">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-ink-600">
                    <span class="font-semibold text-ink-900">{{ count($caseStudies ?? []) }}</span>
                    {{ Str::plural('engagement', count($caseStudies ?? [])) }} documented
                </p>
                <a href="/contact" class="btn-secondary btn-sm shrink-0 self-start sm:self-auto">Request a portfolio sample</a>
            </div>

            <x-case-study-index :studies="$caseStudies ?? collect()" />
        </div>
    </div>

    <!-- CTA -->
    <section class="pb-20">
        <div class="container-wide">
            <div class="relative overflow-hidden rounded-3xl bg-ink-900 px-8 py-14 lg:px-16 lg:py-16 text-center">
                <div class="absolute inset-0 dot-grid opacity-[0.08] pointer-events-none" aria-hidden="true"></div>
                <div class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-[600px] h-[300px] glow-coral opacity-70 pointer-events-none" aria-hidden="true"></div>

                <div class="relative max-w-2xl mx-auto">
                    <h2 class="display-md text-white text-balance">Your project could be the next one.</h2>
                    <p class="mt-5 text-lg text-ink-300 leading-relaxed">
                        Tell us what you are protecting and we will show you how we would approach it.
                    </p>
                    <a href="/contact" class="btn-primary mt-9">Request an assessment</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
