<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        return view('admin.sections.index', ['sections' => Section::query()->orderBy('sort_order')->get()]);
    }

    public function update(UpdateSectionRequest $request, Section $section): RedirectResponse
    {
        $section->update($request->validated());

        return back()->with('success', __('ui.updated_successfully', ['resource' => __('ui.sections')]));
    }

    public function toggle(Section $section): RedirectResponse
    {
        $section->update(['active' => ! $section->active]);

        return back()->with('success', __('ui.updated_successfully', ['resource' => __('ui.sections')]));
    }
}
