<?php

namespace App\Http\Requests\User\Home;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'q' => 'required|string|min:2|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'q.required' => 'Search query is required',
            'q.min' => 'Search query must be at least 2 characters',
            'q.max' => 'Search query cannot exceed 255 characters',
        ];
    }
}