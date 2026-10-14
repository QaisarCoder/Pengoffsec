<x-layouts.admin title="AI Bookings - PengOffSec">
    <div class="max-w-6xl">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="display-md">AI assistant bookings</h1>
                <p class="mt-2 text-sm text-ink-500">
                    {{ $counts['total'] }} {{ Str::plural('booking', $counts['total']) }} captured by the assistant
                    &middot; {{ $counts['pending'] }} awaiting a reply.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success mt-6">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="card p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-500">Total</p>
                <p class="mt-2 text-3xl font-extrabold tracking-tight text-ink-900">{{ $counts['total'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-500">Awaiting reply</p>
                <p class="mt-2 text-3xl font-extrabold tracking-tight text-amber-600">{{ $counts['pending'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-500">Upcoming</p>
                <p class="mt-2 text-3xl font-extrabold tracking-tight text-brand-600">{{ $counts['upcoming'] }}</p>
            </div>
        </div>

        <div class="table-scroll">
            <table class="table-grid">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Scheduled</th>
                        <th>Reference</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="cell-primary">{{ $appointment->client_name }}</div>
                                <a href="mailto:{{ $appointment->client_email }}" class="mt-0.5 block text-xs text-brand-600 hover:text-brand-700">{{ $appointment->client_email }}</a>
                                @if($appointment->client_phone)
                                    <a href="tel:{{ $appointment->client_phone }}" class="mt-0.5 block text-xs text-ink-500 hover:text-ink-900">{{ $appointment->client_phone }}</a>
                                @endif
                            </td>
                            <td class="text-sm">{{ $appointment->service }}</td>
                            <td class="whitespace-nowrap text-sm">
                                @if($appointment->scheduled_at)
                                    <span class="font-semibold text-ink-900">{{ $appointment->scheduled_at->format('j M Y') }}</span>
                                    <span class="mt-0.5 block text-xs text-ink-500">{{ $appointment->scheduled_at->format('g:i A') }}</span>
                                @else
                                    <span class="text-ink-500">Not set</span>
                                @endif
                            </td>
                            <td>
                                <code class="rounded bg-ink-100 px-1.5 py-0.5 font-mono text-xs text-ink-700">{{ $appointment->reference }}</code>
                                @if($appointment->message)
                                    <p class="mt-1.5 max-w-xs text-xs leading-relaxed text-ink-500">{{ Str::limit($appointment->message, 90) }}</p>
                                @endif
                            </td>
                            <td>
                                <div class="flex flex-col items-start gap-1.5">
                                    <span class="status-pill status-{{ $appointment->status }}">{{ \Illuminate\Support\Str::headline($appointment->status) }}</span>
                                    <form action="{{ route('admin.ai-leads.update-status', $appointment) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label for="booking-status-{{ $appointment->id }}" class="sr-only">Status for booking {{ $appointment->reference }}</label>
                                        <select id="booking-status-{{ $appointment->id }}" name="status" onchange="this.form.submit()"
                                                class="input-field !w-auto !py-1.5 !px-3 !text-xs">
                                            @foreach(\App\Http\Controllers\Admin\AILeadController::STATUSES as $status)
                                                <option value="{{ $status }}" @selected($appointment->status === $status)>{{ \Illuminate\Support\Str::headline($status) }}</option>
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5h8M8 14h5m-4.5 6h7a2 2 0 002-2V6a2 2 0 00-2-2H8.5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <p class="font-semibold text-ink-900">No AI bookings yet</p>
                                    <p class="mt-1 text-sm text-ink-500">Meetings booked through the site assistant will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
