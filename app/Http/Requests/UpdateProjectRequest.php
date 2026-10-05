<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProjectRequest extends FormRequest
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
        $projectId = $this->route('project')?->getKey();

        return (new StoreProjectRequest)->rules() + [
            'slug' => ['required', 'string', 'max:190', 'alpha_dash', 'unique:projects,slug,'.$projectId],
        ];
    }
}
