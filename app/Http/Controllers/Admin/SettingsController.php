<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\SiteSetting;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => SiteSetting::query()->orderBy('group')->orderBy('key')->get()->groupBy('group')]);
    }

    public function update(UpdateSettingsRequest $request, FileUploadService $files): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated['settings'] ?? [] as $key => $value) {
            SiteSetting::query()->where('key', $key)->update(['value' => $value]);
        }

        foreach (['logo' => 'logo_path', 'favicon' => 'favicon_path', 'og_image' => 'og_image'] as $input => $key) {
            if (! $request->hasFile($input)) {
                continue;
            }

            $setting = SiteSetting::query()->where('key', $key)->firstOrFail();
            $setting->update(['value' => $files->replace($request->file($input), $setting->value, 'settings')]);
        }

        return back()->with('success', __('ui.updated_successfully', ['resource' => __('ui.settings')]));
    }
}
