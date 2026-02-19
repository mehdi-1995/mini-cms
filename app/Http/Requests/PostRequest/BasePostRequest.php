<?php

namespace App\Http\Requests\PostRequest;

use Illuminate\Foundation\Http\FormRequest;

class BasePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function baseRules(): array
    {
        return [
            'title'     => ['required', 'string', 'max:255'],
            'content'   => ['required', 'string']
        ];
    }
}
