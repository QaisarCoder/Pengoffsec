<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(): View
    {
        return view('work.index', ['caseStudies' => CaseStudy::all()]);
    }

    public function show(CaseStudy $caseStudy): View
    {
        return view('work.show', ['caseStudy' => $caseStudy]);
    }
}
