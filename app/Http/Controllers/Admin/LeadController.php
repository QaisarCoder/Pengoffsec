<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LeadController extends Controller implements HasMiddleware
{
    public const STATUSES = ['New', 'Contacted', 'In Progress', 'Completed', 'Closed'];

    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (!auth()->user() || !auth()->user()->is_admin) {
                    abort(403);
                }
                return $next($request);
            }),
        ];
    }

    public function index(Request $request)
    {
        $query = Lead::query();

        if ($search = trim((string) $request->query('q'))) {
            $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('company', 'like', "%{$search}%")
                ->orWhere('project_details', 'like', "%{$search}%"));
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $leads = $query->orderByDesc('created_at')->get();

        $stats = [
            'total' => Lead::count(),
            'new' => Lead::where('status', 'New')->count(),
            'inProgress' => Lead::whereIn('status', ['Contacted', 'In Progress'])->count(),
            'won' => Lead::where('status', 'Completed')->count(),
        ];

        return view('admin.leads.index', [
            'leads' => $leads,
            'stats' => $stats,
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
        ]);

        $lead->update(['status' => $validated['status']]);

        return back()->with('success', "{$lead->name} moved to {$validated['status']}.");
    }
}
