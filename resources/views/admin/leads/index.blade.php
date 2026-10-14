<x-layouts.admin title="Project Leads - PengOffSec">
    <div class="max-w-6xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="display-md">Project leads</h1>
                <p class="mt-2 text-sm text-ink-500">
                    {{ $stats['new'] }} new &middot; {{ $stats['inProgress'] }} in progress
                    @if($stats['won'] > 0)
                        &middot; {{ $stats['won'] }} completed
                    @endif
                    &middot; {{ $stats['total'] }} total from the contact form.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success mt-6">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.leads.index') }}" class="toolbar">
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                </svg>
                <label for="lead-search" class="sr-only">Search leads</label>
                <input id="lead-search" type="search" name="q" value="{{ request('q') }}"
                       placeholder="Search by name, email, company or details"
                       class="search-field">
            </div>

            <label for="lead-status" class="sr-only">Filter by status</label>
            <select id="lead-status" name="status" onchange="this.form.submit()"
                    class="input-field !w-auto !py-2.5 text-sm">
                <option value="">All statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-secondary btn-sm shrink-0">Search</button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.leads.index') }}" class="btn-secondary btn-sm shrink-0">Clear</a>
            @endif
        </form>

        <div class="table-scroll">
            <table class="table-grid">
                <thead>
                    <tr>
                        <th>Contact</th>
                        <th>Project</th>
                        <th>Budget &amp; timeline</th>
                        <th>Received</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>
                                <div class="cell-primary">{{ $lead->name }}</div>
                                <a href="mailto:{{ $lead->email }}" class="mt-0.5 block text-xs text-brand-600 hover:text-brand-700">{{ $lead->email }}</a>
                                @if($lead->company)
                                    <div class="mt-0.5 text-xs text-ink-500">{{ $lead->company }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="chip-neutral">{{ $lead->service_required ?: 'Not specified' }}</span>
                                @if($lead->project_details)
                                    <p class="mt-1.5 max-w-xs text-xs leading-relaxed text-ink-500">{{ Str::limit($lead->project_details, 100) }}</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap text-xs">
                                <div class="font-semibold text-ink-900">{{ $lead->budget ?: '—' }}</div>
                                <div class="mt-0.5 text-ink-500">{{ $lead->timeline ?: 'No timeline' }}</div>
                            </td>
                            <td class="whitespace-nowrap text-xs text-ink-500">
                                {{ $lead->created_at?->format('j M Y') }}
                            </td>
                            <td>
                                <div class="flex flex-col items-start gap-1.5">
                                    <span class="status-pill status-{{ \Illuminate\Support\Str::slug($lead->status) }}">{{ $lead->status }}</span>
                                    <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label for="lead-status-{{ $lead->id }}" class="sr-only">Status for {{ $lead->name }}</label>
                                        <select id="lead-status-{{ $lead->id }}" name="status" onchange="this.form.submit()"
                                                class="input-field !w-auto !py-1.5 !px-3 !text-xs">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status }}" @selected($lead->status === $status)>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span class="empty-state-icon">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8z" />
                                        </svg>
                                    </span>
                                    <p class="font-semibold text-ink-900">
                                        {{ request()->hasAny(['q', 'status']) ? 'No leads match your filters' : 'No leads yet' }}
                                    </p>
                                    <p class="mt-1 text-sm text-ink-500">
                                        {{ request()->hasAny(['q', 'status']) ? 'Try a different search term or clear the filters.' : 'Submissions from the public contact form will appear here.' }}
                                    </p>
                                    @if(request()->hasAny(['q', 'status']))
                                        <a href="{{ route('admin.leads.index') }}" class="btn-secondary btn-sm mt-5">Clear filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
