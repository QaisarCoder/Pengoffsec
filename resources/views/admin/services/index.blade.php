<x-layouts.admin title="Admin Services - PengOffSec">
    <div class="max-w-6xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="display-md">Services</h1>
                <p class="mt-2 text-sm text-ink-500">
                    {{ $stats['live'] }} of {{ $stats['total'] }} {{ Str::plural('service', $stats['total']) }} visible on the public site.
                </p>
            </div>
            <a href="{{ route('admin.services.create') }}" class="btn-primary btn-sm shrink-0">Add new service</a>
        </div>

        @if(session('success'))
            <div class="alert-success mt-6">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.services.index') }}" class="toolbar">
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                </svg>
                <label for="service-search" class="sr-only">Search services</label>
                <input id="service-search" type="search" name="q" value="{{ request('q') }}"
                       placeholder="Search by name or description"
                       class="search-field">
            </div>

            <label for="service-category" class="sr-only">Filter by category</label>
            <select id="service-category" name="category" onchange="this.form.submit()"
                    class="input-field !w-auto !py-2.5 text-sm">
                <option value="">All categories</option>
                @foreach(['Cybersecurity', 'Software'] as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-secondary btn-sm shrink-0">Search</button>

            @if(request()->hasAny(['q', 'category']))
                <a href="{{ route('admin.services.index') }}" class="btn-secondary btn-sm shrink-0">Clear</a>
            @endif
        </form>

        <div class="table-scroll">
            <table class="table-grid">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Public</th>
                        <th class="w-44 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>
                                <div class="cell-primary">{{ $service->name }}</div>
                                @if($service->description)
                                    <p class="mt-1 max-w-md text-xs leading-relaxed text-ink-500">{{ Str::limit($service->description, 90) }}</p>
                                @endif
                            </td>
                            <td><span class="chip-neutral">{{ $service->category }}</span></td>
                            <td>
                                <form action="{{ route('admin.services.toggle', $service) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="status-pill {{ $service->is_active ? 'status-completed' : 'status-closed' }} hover:opacity-80"
                                            title="{{ $service->is_active ? 'Visible on the public site - click to hide' : 'Hidden - click to publish' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $service->is_active ? 'bg-emerald-500' : 'bg-ink-400' }}"></span>
                                        {{ $service->is_active ? 'Live' : 'Hidden' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="table-action-edit">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete &quot;{{ addslashes($service->name) }}&quot;? This cannot be undone.')">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </span>
                                    <p class="font-semibold text-ink-900">
                                        {{ request()->hasAny(['q', 'category']) ? 'No services match your filters' : 'No services yet' }}
                                    </p>
                                    <p class="mt-1 text-sm text-ink-500">
                                        {{ request()->hasAny(['q', 'category']) ? 'Try a different search term or clear the filters.' : 'Add your first service to start building the catalogue.' }}
                                    </p>
                                    <div class="mt-5 flex gap-2">
                                        @if(request()->hasAny(['q', 'category']))
                                            <a href="{{ route('admin.services.index') }}" class="btn-secondary btn-sm">Clear filters</a>
                                        @else
                                            <a href="{{ route('admin.services.create') }}" class="btn-primary btn-sm">Add a service</a>
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
