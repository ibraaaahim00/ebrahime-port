<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        return ['tag' => ['nullable', 'string', 'max:100'], 'title' => ['required', 'string', 'max:190'], 'description' => ['nullable', 'string', 'max:1000'], 'sort_order' => ['required', 'integer', 'min:0'], 'active' => ['boolean']];
    }
}
