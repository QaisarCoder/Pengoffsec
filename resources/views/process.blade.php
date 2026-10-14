<x-layouts.app title="Our Process - PengOffSec">
    <x-page-header
        eyebrow="Our process"
        title="From uncertainty to a clear security picture."
        lede="Security assessments should do more than produce a list of vulnerabilities. PengOffSec takes a structured approach to understanding your environment, testing what matters, validating the evidence, and turning technical findings into decisions your team can act on."
    />

    <div class="section">
        <div class="container-wide space-y-20">

            <!-- Before we test -->
            <section class="grid lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-5">
                    <h2 class="display-md">Before we test, we understand.</h2>
                    <p class="mt-6 prose-body">
                        Every environment is different. Before testing begins, we establish what you are protecting,
                        how it is exposed, what matters most to the business, and what you want the assessment to answer.
                    </p>
                    <p class="mt-6 pl-5 border-l-2 border-brand-500 text-lg font-semibold text-ink-900">
                        The goal is not to test everything blindly. The goal is to focus effort where it can reveal meaningful risk.
                    </p>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 card p-8">
                    @foreach([
                        'Technology and architecture',
                        'Externally exposed assets',
                        'Applications and APIs',
                        'Authentication and access',
                        'Business-critical functionality',
                        'Assessment objectives',
                        'Scope and rules of engagement',
                        'Compliance and regulatory requirements',
                    ] as $item)
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-ink-600">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Six stages -->
            <section>
                <div class="text-center max-w-2xl mx-auto">
                    <span class="eyebrow">The security journey</span>
                    <h2 class="display-lg mt-4">Six stages, every engagement.</h2>
                </div>

                @php
                    $stages = [
                        ['id' => '01', 'title' => 'Discover', 'sub' => 'Understand the environment.', 'desc' => 'We begin by understanding your technology, business objectives, exposed assets, and security concerns.'],
                        ['id' => '02', 'title' => 'Define', 'sub' => 'Set the boundaries.', 'desc' => 'We establish scope, objectives, testing windows, access requirements, rules of engagement, and communication.'],
                        ['id' => '03', 'title' => 'Assess', 'sub' => 'Test what matters.', 'desc' => 'We assess the agreed attack surface using tooling, technical analysis, and manual testing.'],
                        ['id' => '04', 'title' => 'Validate', 'sub' => 'Separate signal from noise.', 'desc' => 'Potential findings are investigated and manually validated to remove false positives.'],
                        ['id' => '05', 'title' => 'Report', 'sub' => 'Turn findings into decisions.', 'desc' => 'Your assessment results are presented in clear, actionable reporting supported by evidence.'],
                        ['id' => '06', 'title' => 'Improve', 'sub' => 'Know what to do next.', 'desc' => 'We help turn findings into prioritized actions to address meaningful weaknesses.'],
                    ];
                @endphp

                <div class="mt-14 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($stages as $stage)
                        <div class="group card-interactive p-7">
                            <span class="font-mono text-xs font-bold text-brand-600">{{ $stage['id'] }}</span>
                            <h3 class="mt-3 text-lg font-bold text-ink-900">{{ $stage['title'] }}</h3>
                            <p class="mt-1 text-sm font-semibold text-brand-600">{{ $stage['sub'] }}</p>
                            <p class="mt-3 text-sm text-ink-500 leading-relaxed">{{ $stage['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Approach -->
            <section>
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="display-lg">Built around evidence, not assumptions.</h2>
                </div>
                <div class="mt-12 grid md:grid-cols-2 gap-x-12 gap-y-10">
                    @foreach([
                        ['Understand the context', 'We assess security issues in the context of the environment and the business.'],
                        ['Validate the finding', 'Potential vulnerabilities are investigated before being presented as confirmed risk.'],
                        ['Explain the impact', 'Technical findings should make sense to both security teams and decision-makers.'],
                        ['Make it actionable', 'Every meaningful finding should help answer the question: what should we do next?'],
                    ] as [$title, $desc])
                        <div class="border-l-2 border-brand-500 pl-6">
                            <h3 class="font-bold text-lg text-ink-900">{{ $title }}</h3>
                            <p class="mt-2 prose-body text-sm">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Editorial -->
            <section class="card bg-brand-50 border-brand-100 p-10 lg:p-14 text-center">
                <h2 class="display-md text-balance">Security testing should reduce uncertainty.</h2>
                <p class="mt-5 prose-body max-w-3xl mx-auto">
                    A security assessment is not valuable because it produces a large number of findings. It is valuable
                    because it gives you greater confidence in what is actually exposed, what can realistically be
                    exploited, what matters most, and where to focus your next security investment.
                </p>
            </section>

            <!-- Outcomes + CTA -->
            <section class="grid lg:grid-cols-2 gap-6">
                <div class="card p-8 lg:p-10">
                    <h2 class="text-2xl font-bold">At the end of the process, you should know more than you did before.</h2>
                    <ul class="mt-7 space-y-3">
                        @foreach([
                            'What is exposed',
                            'Where meaningful weaknesses exist',
                            'Which findings matter most',
                            'What evidence supports them',
                            'What could happen if they remain unresolved',
                            'What should be prioritized next',
                        ] as $outcome)
                            <li class="flex items-start gap-3 text-sm text-ink-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 shrink-0 mt-2"></span>
                                {{ $outcome }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-2xl bg-ink-900 p-8 lg:p-10 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Ready to understand your security posture?</h2>
                        <p class="mt-4 text-sm text-ink-300 leading-relaxed">
                            Start with a conversation. We will help define the right scope, understand your objectives,
                            and determine the assessment approach that fits your environment.
                        </p>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="/contact" class="btn-primary">Request an assessment</a>
                        <a href="/contact" class="btn px-6 py-3 text-white border border-white/20 hover:bg-white/10">Contact us</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
