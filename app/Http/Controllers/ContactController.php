<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'required|string|max:255',
            'service_required' => 'required|string',
            'project_type' => 'required|string',
            'budget' => 'required|string',
            'timeline' => 'required|string',
            'project_details' => 'required|string',
        ]);

        Lead::create($validated);

        return back()->with('success', 'Thank you. We have received your project request and will be in touch shortly.');
    }
}
