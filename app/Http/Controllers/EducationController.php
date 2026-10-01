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
}
