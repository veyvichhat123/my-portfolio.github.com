<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        abort_unless($project->is_active, 404);

        return view('projects.show', compact('project'));
    }
}
