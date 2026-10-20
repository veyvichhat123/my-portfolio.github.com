<?php

namespace App\Http\Controllers;

use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        return view('education.index', compact('education'));
    }
    public function show(Education $education)
    {
        abort_unless($education->is_active, 404);

        return view('education.show', compact('education'));
    }
}
