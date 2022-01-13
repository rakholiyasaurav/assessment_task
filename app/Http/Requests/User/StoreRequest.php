<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'bail|required|string|min:4|max:20|unique:users,username',
            'password' => 'bail|required|min:8'
        ];
    }
}
