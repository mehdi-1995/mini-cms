<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قوانین مشترک user
     */
    protected function baseRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],

            'email' => [
                'required',
                'email',
            ],

            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ];
    }

    /**
     * پیام‌های خطای مشترک
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام الزامی است.',
            'name.min' => 'نام باید حداقل ۳ کاراکتر باشد.',

            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً استفاده شده است.',

            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
            'password.confirmed' => 'تأیید رمز عبور مطابقت ندارد.',
        ];
    }
}
