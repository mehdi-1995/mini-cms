<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserUpdateRequest extends BaseUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // خیلی مهم
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        // اگر route model binding داری: Route::put('/users/{user}', ...)

        return array_merge($this->baseRules(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);
    }
}
