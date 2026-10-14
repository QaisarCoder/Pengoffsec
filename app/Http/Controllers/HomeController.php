<?php

namespace App\Http\Controllers;

use App\Models\HomepageHero;
use App\Models\Service;
use App\Models\CaseStudy;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $hero = HomepageHero::first();
        $service = Service::where('is_active', true)->get();
        $case = CaseStudy::latest()->take(3)->get();

        return view('home', compact('hero', 'service', 'case'));
    }
}
