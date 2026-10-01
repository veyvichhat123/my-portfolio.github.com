<?php


namespace App\Http\Controllers;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = \App\Models\Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }
}
