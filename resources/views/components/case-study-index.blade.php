@props([
    'studies',
])

@if($studies->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6']) }}>
        @foreach($studies as $study)
            <a href="/work/{{ $study->slug }}" class="group card-interactive p-7 flex flex-col bg-white">
                <div class="icon-chip mb-6" aria-hidden="true">
                    @if($study->category === 'Cybersecurity')
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    @endif
                </div>

                <span class="text-xs font-bold uppercase tracking-widest text-brand-600">{{ $study->category }}</span>

                <h3 class="mt-3 text-lg font-bold text-ink-900 group-hover:text-brand-600 transition-colors">{{ $study->title }}</h3>

                <p class="mt-3 text-sm text-ink-500 leading-relaxed flex-grow line-clamp-3">{{ $study->description }}</p>

                <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition group-hover:gap-2.5">
                    View case study
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0l-6-6m6 6l-6 6" />
                    </svg>
                </span>
            </a>
        @endforeach
    </div>
@else
    <div {{ $attributes->merge(['class' => 'mt-12 relative overflow-hidden rounded-2xl border border-ink-200 bg-white p-12 text-center shadow-card']) }}>
        <div class="absolute inset-0 dot-grid opacity-[0.05] pointer-events-none" aria-hidden="true"></div>

        <div class="relative">
            <span class="inline-flex w-14 h-14 rounded-2xl bg-brand-50 border border-brand-100 text-brand-600 items-center justify-center" aria-hidden="true">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </span>

            <h3 class="mt-6 text-xl font-bold text-ink-900">Case studies coming soon</h3>
            <p class="mt-3 text-sm text-ink-600 max-w-md mx-auto leading-relaxed">
                We are currently preparing detailed case studies highlighting our recent OT/IT security
                assessments and engineering engagements.
            </p>

            <a href="/contact" class="btn-primary btn-sm mt-7">Request a portfolio sample</a>
        </div>
    </div>
@endif
