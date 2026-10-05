<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return match ($this->route('resource')) {
            'categories' => ['name' => ['required', 'string', 'max:100'], 'slug' => ['required', 'alpha_dash', 'max:120'], 'icon' => ['nullable', 'string', 'max:120'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'technologies' => ['name' => ['required', 'string', 'max:100'], 'slug' => ['required', 'alpha_dash', 'max:120'], 'icon' => ['nullable', 'string', 'max:120'], 'category' => ['nullable', 'string', 'max:100'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'skills' => ['name' => ['required', 'string', 'max:100'], 'category' => ['required', 'string', 'max:100'], 'category_label' => ['required', 'string', 'max:150'], 'level' => ['nullable', 'string', 'max:150'], 'tag' => ['nullable', 'string', 'max:100'], 'icon' => ['nullable', 'string', 'max:120'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'experiences' => ['company' => ['required', 'string', 'max:150'], 'position' => ['required', 'string', 'max:150'], 'description' => ['nullable', 'string'], 'start_date' => ['nullable', 'date'], 'end_date' => ['nullable', 'date', 'after_or_equal:start_date'], 'current' => ['boolean'], 'location' => ['nullable', 'string', 'max:150'], 'technologies' => ['nullable', 'json'], 'highlights' => ['nullable', 'json'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'education' => ['institution' => ['required', 'string', 'max:190'], 'degree' => ['required', 'string', 'max:190'], 'field' => ['nullable', 'string', 'max:190'], 'description' => ['nullable', 'string'], 'start_date' => ['nullable', 'date'], 'end_date' => ['nullable', 'date', 'after_or_equal:start_date'], 'location' => ['nullable', 'string', 'max:150'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'services' => ['title' => ['required', 'string', 'max:190'], 'description' => ['nullable', 'string'], 'icon' => ['nullable', 'string', 'max:120'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'testimonials' => ['name' => ['required', 'string', 'max:150'], 'position' => ['nullable', 'string', 'max:150'], 'company' => ['nullable', 'string', 'max:150'], 'testimonial' => ['required', 'string'], 'rating' => ['nullable', 'integer', 'min:1', 'max:5'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            'pillars' => ['title' => ['required', 'string', 'max:190'], 'description' => ['required', 'string'], 'icon' => ['nullable', 'string', 'max:120'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']],
            default => [],
        };
    }
}
