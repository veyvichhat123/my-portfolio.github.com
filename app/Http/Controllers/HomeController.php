<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Project::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        $experiences = Experience::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_date')
            ->take(3)
            ->get();

        return view('home', compact('featured', 'experiences'));
    }
}
