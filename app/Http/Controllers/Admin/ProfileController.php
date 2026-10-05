<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\PortfolioProfile;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['profile' => PortfolioProfile::query()->firstOrFail()]);
    }

    public function update(UpdateProfileRequest $request, FileUploadService $files): RedirectResponse
    {
        $profile = PortfolioProfile::query()->firstOrFail();
        $data = $request->validated();

        $data['profile_image_path'] = $files->replace($request->file('profile_image'), $profile->profile_image_path, 'profile');
        $data['cv_path'] = $files->replace($request->file('cv'), $profile->cv_path, 'cv');
        unset($data['profile_image'], $data['cv']);

        $profile->update($data);

        return back()->with('success', __('ui.updated_successfully', ['resource' => __('ui.profile')]));
    }
}
