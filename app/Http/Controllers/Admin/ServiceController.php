<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ServiceController extends Controller implements HasMiddleware
{
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
        $query = Service::query();

        // Server-side search keeps the table responsive as the catalogue grows.
        if ($search = trim((string) $request->query('q'))) {
            $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        $services = $query->orderBy('category')->orderBy('name')->get();

        $stats = [
            'total' => Service::count(),
            'live' => Service::where('is_active', true)->count(),
            'hidden' => Service::where('is_active', false)->count(),
        ];

        return view('admin.services.index', compact('services', 'stats'));
    }

    /**
     * Toggle whether a service is offered on the public site.
     */
    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        return back()->with('success', sprintf(
            '%s is now %s on the public site.',
            $service->name,
            $service->is_active ? 'visible' : 'hidden'
        ));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|in:Cybersecurity,Software',
        ]);
        Service::create($validated);
        return redirect()->route('admin.services.index');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|in:Cybersecurity,Software',
        ]);
        $service->update($validated);
        return redirect()->route('admin.services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index');
    }
}
