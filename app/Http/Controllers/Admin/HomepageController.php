<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageHero;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomepageController extends Controller implements HasMiddleware
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

    public function index()
    {
        $hero = HomepageHero::first() ?? new HomepageHero([
            'headline' => 'Secure. Build. Scale.',
            'subheadline' => 'PengOffSec builds secure digital products.',
            'cta_text' => 'Start a Project',
            'cta_link' => '/contact'
        ]);
        return view('admin.hero.index', compact('hero'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'headline' => 'required',
            'subheadline' => 'required',
            'cta_text' => 'required',
            'cta_link' => 'required',
        ]);

        $hero = HomepageHero::firstOrNew();
        $hero->fill($validated);
        $hero->save();

        return back()->with('success', 'Hero updated successfully.');
    }
}
