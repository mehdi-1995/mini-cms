<?php

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRoleRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'name.required' => 'لطفا نام نقش را وارد کنید.',
            'name.string' => 'نام نقش باید متن باشد.',
            'name.unique' => 'این نام نقش قبلا ثبت شده است.',
            'permissions.array' => 'دسترسی‌ها باید به صورت آرایه ارسال شوند.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام نقش',
            'permissions' => 'دسترسی‌ها',
        ];
    }
}
