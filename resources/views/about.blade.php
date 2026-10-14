<x-layouts.app title="About - PengOffSec">
    <x-page-header
        eyebrow="About us"
        title="Security and engineering, done properly."
        lede="PengOffSec is a professional web development and security agency dedicated to building high-performance, scalable, and secure digital products."
    />

    <div class="section">
        <div class="container-wide space-y-20">

            <section class="grid lg:grid-cols-12 gap-12">
                <div class="lg:col-span-7">
                    <h2 class="display-md">Who we are</h2>
                    <div class="mt-6 space-y-5 prose-body">
                        <p>
                            We work with organisations that depend on their technology to operate â€” and that need to know
                            whether that technology can withstand real scrutiny. Our team combines offensive security
                            practitioners with software engineers, so the same people who test a system also understand
                            how it was built.
                        </p>
                        <p>
                            That combination matters. Findings are more accurate when the tester knows the architecture.
                            Remediation is faster when the fix was written by someone who found the problem. And because
                            both capabilities sit in the same team, we can move from assessment into engineering without
                            a handover.
                        </p>
                        <p>
                            We favour clarity over volume. A report with twenty validated, well-evidenced findings is more
                            useful than one with two hundred unverified ones, and we would rather leave an organisation
                            with a short list of decisions it can act on than a long list it cannot.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="card p-8">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-600">What we optimise for</h3>
                        <ul class="mt-6 space-y-5">
                            @foreach([
                                ['Evidence over assertion', 'Every finding is manually validated before it reaches you.'],
                                ['Business context', 'Risk is described in terms of what it means for your operations.'],
                                ['Actionable outcomes', 'Clear priorities, not a wall of raw scanner output.'],
                                ['Long-term partnership', 'We stay involved after the report to help you close the gaps.'],
                            ] as [$title, $desc])
                                <li>
                                    <p class="font-semibold text-ink-900">{{ $title }}</p>
                                    <p class="mt-1 text-sm text-ink-500 leading-relaxed">{{ $desc }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>

            <section>
                <div class="max-w-2xl">
                    <span class="eyebrow">Capabilities</span>
                    <h2 class="display-lg mt-4">What we bring to the table</h2>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach([
                        ['Offensive security', 'Penetration testing, OT/IT assessments, and network analysis.'],
                        ['Governance & compliance', 'GRC alignment against recognised industry standards.'],
                        ['Product engineering', 'Secure web, mobile, and desktop application development.'],
                        ['Security advisory', 'Prioritised remediation guidance your team can execute.'],
                    ] as [$title, $desc])
                        <div class="card p-7">
                            <h3 class="font-bold text-ink-900">{{ $title }}</h3>
                            <p class="mt-3 text-sm text-ink-500 leading-relaxed">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- CTA -->
            <section>
                <div class="rounded-3xl bg-ink-900 px-8 py-14 lg:px-16 lg:py-20 text-center relative overflow-hidden">
                    <div class="absolute inset-0 dot-grid opacity-[0.08]" aria-hidden="true"></div>
                    <div class="absolute -bottom-20 left-1/2 -translate-x-1/2 w-[500px] h-[260px] glow-coral opacity-70" aria-hidden="true"></div>
                    <div class="relative max-w-2xl mx-auto">
                        <h2 class="display-md text-white text-balance">Let's talk about what you need.</h2>
                        <p class="mt-5 text-lg text-ink-300">Whether you need an assessment, a secure build, or both â€” we can scope it with you.</p>
                        <a href="/contact" class="btn-primary mt-9">Get in touch</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
