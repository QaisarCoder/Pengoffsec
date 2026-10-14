<x-layouts.admin title="Admin Work - PengOffSec">
    <div class="max-w-6xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="display-md">Portfolio</h1>
                <p class="mt-2 text-sm text-ink-500">
                    {{ $stats['total'] }} {{ Str::plural('case study', $stats['total']) }} published
                    @if($stats['thisMonth'] > 0)
                        &middot; {{ $stats['thisMonth'] }} added this month
                    @endif
                    .
                </p>
            </div>
            <a href="{{ route('admin.work.create') }}" class="btn-primary btn-sm shrink-0">Create new</a>
        </div>

        <form method="GET" action="{{ route('admin.work.index') }}" class="toolbar">
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                </svg>
                <label for="work-search" class="sr-only">Search case studies</label>
                <input id="work-search" type="search" name="q" value="{{ request('q') }}"
                       placeholder="Search by title, description or slug"
                       class="search-field">
            </div>
            <button type="submit" class="btn-secondary btn-sm shrink-0">Search</button>
            @if(request('q'))
                <a href="{{ route('admin.work.index') }}" class="btn-secondary btn-sm shrink-0">Clear</a>
            @endif
        </form>

        <div class="table-scroll">
            <table class="table-grid">
                <thead>
                    <tr>
                        <th>Case study</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th class="w-44 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caseStudies as $caseStudy)
                        <tr>
                            <td>
                                <div class="cell-primary">{{ $caseStudy->title }}</div>
                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <code class="rounded bg-ink-100 px-1.5 py-0.5 font-mono text-xs text-ink-600">/{{ $caseStudy->slug }}</code>
                                    <a href="{{ route('work.show', $caseStudy->slug) }}" target="_blank" rel="noopener"
                                       class="text-xs font-semibold text-brand-600 hover:text-brand-700">View</a>
                                </div>
                            </td>
                            <td><span class="chip-neutral">{{ $caseStudy->category }}</span></td>
                            <td class="whitespace-nowrap text-xs text-ink-500">
                                {{ $caseStudy->created_at?->format('j M Y') }}
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.work.edit', $caseStudy) }}" class="table-action-edit">Edit</a>
                                    <form action="{{ route('admin.work.destroy', $caseStudy) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete &quot;{{ addslashes($caseStudy->title) }}&quot;? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <span class="empty-state-icon">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h6v13H4zM14 7h6v13h-6z" />
                                        </svg>
                                    </span>
                                    <p class="font-semibold text-ink-900">
                                        {{ request('q') ? 'No case studies match your search' : 'No case studies yet' }}
                                    </p>
                                    <p class="mt-1 text-sm text-ink-500">
                                        {{ request('q') ? 'Try a different search term.' : 'Showcase your first project to build the portfolio page.' }}
                                    </p>
                                    <div class="mt-5 flex gap-2">
                                        @if(request('q'))
                                            <a href="{{ route('admin.work.index') }}" class="btn-secondary btn-sm">Clear search</a>
                                        @else
                                            <a href="{{ route('admin.work.create') }}" class="btn-primary btn-sm">Add a case study</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
