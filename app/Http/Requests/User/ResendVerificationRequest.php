<?php

namespace App\Http\Requests\User;
use Illuminate\Foundation\Http\FormRequest;

class InvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'bail|required|email|max:255'
        ];
    }
}
