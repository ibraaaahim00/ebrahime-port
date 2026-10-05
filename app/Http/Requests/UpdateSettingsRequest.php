<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return ['settings' => ['array'], 'settings.*' => ['nullable', 'string', 'max:5000'], 'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'], 'favicon' => ['nullable', 'file', 'mimes:ico,png,svg', 'max:2048'], 'og_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120']];
    }
}
