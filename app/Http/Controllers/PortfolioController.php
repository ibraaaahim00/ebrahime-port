<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\PortfolioQueryService;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __construct(private PortfolioQueryService $portfolio) {}

    public function index(): View
    {
        return view('home', $this->portfolio->home());
    }

    public function project(Project $project): View
    {
        abort_unless($project->active && $project->published, 404);

        return view('projects.show', [
            'project' => $project->load(['category', 'technologies']),
            'relatedProjects' => Project::query()->visible()->where('id', '!=', $project->getKey())->with(['category', 'technologies'])->orderBy('sort_order')->limit(3)->get(),
        ]);
    }
}
