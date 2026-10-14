<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AILeadController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (! auth()->user() || ! auth()->user()->is_admin) {
                    abort(403);
                }
                return $next($request);
            }),
        ];
    }

    /**
     * Statuses a booking can move through, in pipeline order.
     */
    public const STATUSES = ['pending', 'contacted', 'in_progress', 'completed', 'cancelled'];

    public function index()
    {
        $appointments = Appointment::orderByDesc('created_at')->get();

        $counts = [
            'total' => $appointments->count(),
            'pending' => $appointments->where('status', 'pending')->count(),
            'upcoming' => $appointments
                ->filter(fn ($a) => $a->scheduled_at && $a->scheduled_at->isFuture())
                ->count(),
        ];

        return view('admin.leads.ai-index', compact('appointments', 'counts'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', "Booking {$appointment->reference} moved to {$validated['status']}.");
    }
}
