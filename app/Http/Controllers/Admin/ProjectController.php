<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projects) {}

    public function index(): View
    {
        return view('admin.projects.index', ['projects' => Project::query()->with(['category', 'technologies'])->orderBy('sort_order')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project, ...$this->formData()]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->projects->create($request->validated(), $request->file('image'), $request->file('thumbnail'));

        return redirect()->route('admin.projects.index')->with('success', __('ui.created_successfully', ['resource' => __('ui.project')]));
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['project' => $project->load('technologies'), ...$this->formData()]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->projects->update($project, $request->validated(), $request->file('image'), $request->file('thumbnail'));

        return redirect()->route('admin.projects.index')->with('success', __('ui.updated_successfully', ['resource' => __('ui.project')]));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->projects->delete($project);

        return back()->with('success', __('ui.deleted_successfully', ['resource' => __('ui.project')]));
    }

    public function toggle(Project $project, string $attribute): RedirectResponse
    {
        $this->projects->toggle($project, $attribute);

        return back()->with('success', __('ui.updated_successfully', ['resource' => __('ui.project')]));
    }

    /** @return array<string, mixed> */
    private function formData(): array
    {
        return [
            'categories' => Category::query()->where('active', true)->orderBy('sort_order')->get(),
            'technologies' => Technology::query()->where('active', true)->orderBy('sort_order')->get(),
        ];
    }
}
