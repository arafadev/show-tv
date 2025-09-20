<?php
// app/Http/Requests/Episode/EpisodeLikeRequest.php

namespace App\Http\Requests\User\Episode;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeLikeRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'is_like' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'is_like.required' => 'Like status is required',
        ];
    }
}