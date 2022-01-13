<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'avatar' => 'bail|sometimes|url',
            'username' => 'sometimes|bail|required|string|min:4|max:20|unique:users,username'
        ];
    }
}
