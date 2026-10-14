<x-layouts.app title="{{ $caseStudy->title }} - PengOffSec">
    <x-page-header :eyebrow="$caseStudy->category" :title="$caseStudy->title" />

    <div class="section">
        <div class="container-wide">
            <div class="grid lg:grid-cols-12 gap-12">
                <div class="lg:col-span-8">
                    <div class="prose-body text-base leading-relaxed whitespace-pre-line">{{ $caseStudy->description }}</div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-28 card p-7">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-600">Engagement</h2>
                        <dl class="mt-6 space-y-5">
                            <div>
                                <dt class="text-xs text-ink-600">Category</dt>
                                <dd class="mt-1 font-semibold text-ink-900">{{ $caseStudy->category }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-ink-600">Published</dt>
                                <dd class="mt-1 font-semibold text-ink-900">{{ $caseStudy->created_at?->format('M Y') ?? 'â€”' }}</dd>
                            </div>
                        </dl>
                        <a href="/work" class="btn-secondary btn-sm mt-8 w-full">All case studies</a>
                        <a href="/contact" class="btn-primary btn-sm mt-3 w-full">Discuss your project</a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>
