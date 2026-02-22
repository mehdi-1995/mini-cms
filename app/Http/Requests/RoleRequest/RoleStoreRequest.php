<?php

namespace App\Http\Requests\RoleRequest;

use Illuminate\Validation\Rule;

class RoleStoreRequest extends BaseRoleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge($this->baseRules(), [
            'name' => ['required', 'string', Rule::unique('roles', 'name')],
            'guard_name' => ['required', 'in:' . implode(',', array_keys(config('auth.guards')))],
        ]);
    }
}
