<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'bail|email|required|string|min:4|max:20',
            'otp' => 'bail|required|integer|min:99999|max:999999'
        ];
    }
}
