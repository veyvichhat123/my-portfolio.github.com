<?php

namespace App\Http\Controllers;

use App\Models\Experience;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        return view('experience.index', compact('experiences'));
    }
}
