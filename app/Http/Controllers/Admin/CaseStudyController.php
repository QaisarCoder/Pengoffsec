<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CaseStudyController extends Controller implements HasMiddleware
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
        $query = CaseStudy::query();

        if ($search = trim((string) $request->query('q'))) {
            $query->where(fn ($q) => $q
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%"));
        }

        $caseStudies = $query->orderByDesc('created_at')->get();

        return view('admin.work.index', [
            'caseStudies' => $caseStudies,
            'stats' => [
                'total' => CaseStudy::count(),
                'thisMonth' => CaseStudy::where('created_at', '>=', now()->startOfMonth())->count(),
            ],
        ]);
    }

    public function create()
    {
        return view('admin.work.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:case_studies',
        ]);
        CaseStudy::create($validated);
        return redirect()->route('admin.work.index');
    }

    public function edit(CaseStudy $caseStudy)
    {
        return view('admin.work.edit', compact('caseStudy'));
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:case_studies,slug,' . $caseStudy->id,
        ]);
        $caseStudy->update($validated);
        return redirect()->route('admin.work.index');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        $caseStudy->delete();
        return redirect()->route('admin.work.index');
    }
}
