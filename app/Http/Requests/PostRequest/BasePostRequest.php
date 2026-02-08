<?php

namespace App\Http\Requests\PostRequest;

use Illuminate\Foundation\Http\FormRequest;

class BasePostRequest extends FormRequest
{


    protected function prepareForValidation()
    {
        $this->merge([
            'published' => $this->boolean('published'),
        ]);
    }

}
