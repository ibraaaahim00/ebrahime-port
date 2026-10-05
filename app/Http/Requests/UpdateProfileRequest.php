<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:190'], 'professional_title' => ['required', 'string', 'max:190'], 'status' => ['nullable', 'string', 'max:190'], 'short_bio' => ['nullable', 'string', 'max:1000'], 'full_bio' => ['nullable', 'string'], 'email' => ['nullable', 'email', 'max:190'], 'phone' => ['nullable', 'string', 'max:40'], 'location' => ['nullable', 'string', 'max:150'], 'github_url' => ['nullable', 'url:http,https', 'max:500'], 'linkedin_url' => ['nullable', 'url:http,https', 'max:500'], 'facebook_url' => ['nullable', 'url:http,https', 'max:500'], 'instagram_url' => ['nullable', 'url:http,https', 'max:500'], 'whatsapp_url' => ['nullable', 'url:http,https', 'max:500'], 'available' => ['boolean'], 'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:80'], 'hero_cta_text' => ['nullable', 'string', 'max:100'], 'hero_cta_url' => ['nullable', 'string', 'max:500'], 'profile_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'], 'cv' => ['nullable', 'file', 'mimes:pdf', 'max:10240']];
    }
}
