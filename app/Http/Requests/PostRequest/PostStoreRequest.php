<?php

namespace App\Http\Requests\PostRequest;

use App\Models\Post;

class PostStoreRequest extends BasePostRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()
            ? auth()->user()->can('create', Post::class)
            : auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->baseRules();
    }

}
