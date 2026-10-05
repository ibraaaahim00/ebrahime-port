<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['slug' => $this->input('slug') ?: Str::slug((string) $this->input('title'))]);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['required', 'string', 'max:190', 'alpha_dash', 'unique:projects,slug'],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['nullable', 'string', 'max:5000'],
            'badge' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'url:http,https', 'max:500'],
            'live_demo_url' => ['nullable', 'url:http,https', 'max:500'],
            'client_company' => ['nullable', 'string', 'max:190'],
            'project_status' => ['required', 'string', 'max:80'],
            'start_date' => ['nullable', 'date'],
            'completion_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'case_study' => ['nullable', 'json'],
            'technology_ids' => ['array'],
            'technology_ids.*' => ['integer', 'exists:technologies,id'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99999'],
            'featured' => ['boolean'],
            'published' => ['boolean'],
            'active' => ['boolean'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'thumbnail' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
        ];
    }
}
