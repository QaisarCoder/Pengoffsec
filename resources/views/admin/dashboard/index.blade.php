<x-layouts.admin title="Admin Dashboard - PengOffSec">
    <div class="max-w-5xl">
        <h1 class="display-md">Admin overview</h1>
        <p class="mt-2 text-sm text-ink-500">Manage your public site content and review incoming leads.</p>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-8">
            @foreach([
                ['Portfolio items', \App\Models\CaseStudy::count(), 'text-ink-900', 'admin.work.index'],
                ['Services', \App\Models\Service::where('is_active', true)->count(), 'text-ink-900', 'admin.services.index'],
                ['New leads', \App\Models\Lead::where('status', 'New')->count(), 'text-amber-600', 'admin.leads.index'],
                ['AI bookings', \App\Models\Appointment::where('status', 'pending')->count(), 'text-brand-600', 'admin.ai-leads.index'],
            ] as [$label, $value, $valueClass, $route])
                <a href="{{ route($route) }}" class="card p-6 transition hover:border-brand-300 hover:shadow-card-hover">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-500">{{ $label }}</h3>
                            <p class="mt-3 text-4xl font-extrabold tracking-tight {{ $valueClass }}">{{ $value }}</p>
                        </div>
                        <svg class="h-4 w-4 shrink-0 text-ink-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        @php $recentBookings = \App\Models\Appointment::orderByDesc('created_at')->limit(5)->get(); @endphp

        @if($recentBookings->isNotEmpty())
            <div class="card p-8 mt-8">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="font-bold text-ink-900">Latest AI bookings</h2>
                    <a href="{{ route('admin.ai-leads.index') }}" class="btn-secondary btn-sm">View all</a>
                </div>
                <ul class="mt-2 divide-y divide-ink-100">
                    @foreach($recentBookings as $booking)
                        <li class="flex flex-wrap items-center justify-between gap-3 py-4">
                            <div class="min-w-0">
                                <div class="font-semibold text-ink-900">{{ $booking->client_name }}</div>
                                <div class="mt-0.5 truncate text-xs text-ink-500">{{ $booking->client_email }}</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="chip-neutral hidden sm:inline-flex">{{ $booking->service }}</span>
                                <span class="status-pill status-{{ $booking->status }}">{{ \Illuminate\Support\Str::headline($booking->status) }}</span>
                                <span class="w-32 text-right text-sm text-ink-600">
                                    @if($booking->scheduled_at)
                                        {{ $booking->scheduled_at->format('j M, g:i A') }}
                                    @else
                                        <span class="text-ink-500">No date</span>
                                    @endif
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-8 mt-8">
            <h2 class="font-bold text-ink-900">Quick actions</h2>
            <div class="mt-5 flex flex-wrap gap-2">
                <a href="{{ route('admin.hero.index') }}" class="btn-primary btn-sm">Edit homepage hero</a>
                <a href="{{ route('admin.services.create') }}" class="btn-secondary btn-sm">Add a service</a>
                <a href="{{ route('admin.work.create') }}" class="btn-secondary btn-sm">Add case study</a>
                <a href="{{ route('admin.leads.index') }}" class="btn-secondary btn-sm">Review leads</a>
                <a href="{{ route('admin.ai-leads.index') }}" class="btn-secondary btn-sm">Review AI bookings</a>
            </div>
        </div>
    </div>
</x-layouts.admin>
