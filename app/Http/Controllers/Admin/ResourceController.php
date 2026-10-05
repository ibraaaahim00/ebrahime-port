<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminResourceRequest;
use App\Models\Category;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioPillar;
use App\Models\PortfolioService;
use App\Models\Skill;
use App\Models\Technology;
use App\Models\Testimonial;
use App\Repositories\Eloquent\ContentRepository;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(string $resource): View
    {
        $config = $this->config($resource);

        return view('admin.resources.index', [
            'resource' => $resource,
            'config' => $config,
            'items' => $this->service($config)->index(),
        ]);
    }

    public function create(string $resource): View
    {
        return view('admin.resources.form', ['resource' => $resource, 'config' => $this->config($resource), 'item' => null]);
    }

    public function store(AdminResourceRequest $request, string $resource): RedirectResponse
    {
        $config = $this->config($resource);
        $this->service($config)->create($this->normalize($request->validated(), $resource));

        return redirect()->route('admin.'.$resource.'.index')->with('success', __('ui.created_successfully', ['resource' => __('ui.resource_'.$resource)]));
    }

    public function edit(string $resource, int $item): View
    {
        $config = $this->config($resource);
        $model = app($config['model']);

        return view('admin.resources.form', ['resource' => $resource, 'config' => $config, 'item' => $model->newQuery()->findOrFail($item)]);
    }

    public function update(AdminResourceRequest $request, string $resource, int $item): RedirectResponse
    {
        $config = $this->config($resource);
        $model = app($config['model'])->newQuery()->findOrFail($item);
        $this->service($config)->update($model, $this->normalize($request->validated(), $resource));

        return redirect()->route('admin.'.$resource.'.index')->with('success', __('ui.updated_successfully', ['resource' => __('ui.resource_'.$resource)]));
    }

    public function destroy(string $resource, int $item): RedirectResponse
    {
        $config = $this->config($resource);
        $model = app($config['model'])->newQuery()->findOrFail($item);
        $this->service($config)->delete($model);

        return back()->with('success', __('ui.deleted_successfully', ['resource' => __('ui.resource_'.$resource)]));
    }

    /** @return array{model: class-string, label: string, fields: array<string, array<string, mixed>>} */
    private function config(string $resource): array
    {
        $configs = [
            'categories' => ['model' => Category::class, 'label' => 'Categories', 'fields' => ['name', 'slug', 'icon', 'sort_order', 'active']],
            'technologies' => ['model' => Technology::class, 'label' => 'Technologies', 'fields' => ['name', 'slug', 'icon', 'category', 'sort_order', 'active']],
            'skills' => ['model' => Skill::class, 'label' => 'Skills', 'fields' => ['name', 'category', 'category_label', 'level', 'tag', 'icon', 'sort_order', 'active']],
            'experiences' => ['model' => Experience::class, 'label' => 'Experience', 'fields' => ['company', 'position', 'description', 'start_date', 'end_date', 'current', 'location', 'technologies', 'highlights', 'sort_order', 'active']],
            'education' => ['model' => Education::class, 'label' => 'Education', 'fields' => ['institution', 'degree', 'field', 'description', 'start_date', 'end_date', 'location', 'sort_order', 'active']],
            'services' => ['model' => PortfolioService::class, 'label' => 'Services', 'fields' => ['title', 'description', 'icon', 'sort_order', 'active']],
            'testimonials' => ['model' => Testimonial::class, 'label' => 'Testimonials', 'fields' => ['name', 'position', 'company', 'testimonial', 'rating', 'sort_order', 'active']],
            'pillars' => ['model' => PortfolioPillar::class, 'label' => 'Engineering Pillars', 'fields' => ['title', 'description', 'icon', 'sort_order', 'active']],
        ];

        abort_unless(isset($configs[$resource]), 404);

        return $configs[$resource];
    }

    private function service(array $config): ContentService
    {
        return new ContentService(new ContentRepository(app($config['model'])));
    }

    /** @param array<string, mixed> $data */
    private function normalize(array $data, string $resource): array
    {
        foreach (['technologies', 'highlights'] as $jsonField) {
            if (array_key_exists($jsonField, $data) && is_string($data[$jsonField])) {
                $data[$jsonField] = json_decode($data[$jsonField], true) ?: [];
            }
        }

        return $data;
    }
}
