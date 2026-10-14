<x-layouts.app title="Services - PengOffSec">
    <x-page-header
        eyebrow="What we offer"
        title="Our Services"
        lede="Professional cybersecurity and software engineering solutions tailored for modern business infrastructure."
    />

    <div class="section">
        <div class="container-wide space-y-20">
            @foreach([
                'Cybersecurity Services' => [
                    'description' => 'Assessment, testing and advisory services across operational and information technology environments.',
                    'items' => [
                        'OT/IT Security Services' => 'Comprehensive protection for operational and information technology environments.',
                        'Network Analysis' => 'Deep packet inspection and traffic analysis to identify anomalies.',
                        'Penetration Testing' => 'Simulated attacks to uncover vulnerabilities before malicious actors do.',
                        'Security Assessment' => 'High-level review of your security posture.',
                        'Security Audit' => 'Systematic evaluation of information security compliance.',
                        'OT Infrastructure Security Assessment' => 'Specialized security testing for industrial control systems.',
                        'GRC (Governance, Risk & Compliance)' => 'Aligning your technology with industry security standards.',
                    ],
                ],
                'Software Services' => [
                    'description' => 'Secure, scalable product engineering for web, mobile and desktop platforms.',
                    'items' => [
                        'Web Application Development' => 'Scalable, secure, and modern web platforms.',
                        'Mobile Application Development' => 'Native and cross-platform mobile experiences.',
                        'Desktop Application Development' => 'High-performance desktop solutions for specialized tasks.',
                    ],
                ],
            ] as $heading => $group)
                <div>
                    <div class="max-w-2xl">
                        <h2 class="display-md">{{ $heading }}</h2>
                        <p class="mt-4 prose-body">{{ $group['description'] }}</p>
                    </div>

                    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($group['items'] as $name => $desc)
                            <div class="group card-interactive p-7 flex flex-col relative">
                                <div class="icon-chip mb-6" aria-hidden="true">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-ink-900 group-hover:text-brand-600 transition-colors">{{ $name }}</h3>
                                <p class="mt-3 text-sm text-ink-500 leading-relaxed flex-1">{{ $desc }}</p>
                                <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition group-hover:gap-2.5">
                                    Get started
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
                                    </svg>
                                </span>
                                <a href="/contact" class="absolute inset-0 z-10 rounded-2xl" aria-label="Get started with {{ $name }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CTA -->
    <section class="pb-20">
        <div class="container-wide">
            <div class="card p-10 lg:p-14 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="max-w-xl">
                    <h2 class="display-md">Need help scoping the right service?</h2>
                    <p class="mt-4 prose-body">Tell us about your environment and objectives. We will help you identify what to test first and why it matters.</p>
                </div>
                <a href="/contact" class="btn-primary shrink-0">Talk to an engineer</a>
            </div>
        </div>
    </section>
</x-layouts.app>
