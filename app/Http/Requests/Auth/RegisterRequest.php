<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegisterRequest extends FormRequest
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
        return [
            'name' => ['required', 'max:60', 'string'],
            'last_name' => ['required', 'max:60', 'string'],
            'dni' => ['required', 'numeric', 'digits:8', 'unique:users,dni'],
            'phone' => ['required', 'numeric', 'digits:9', 'unique:users,phone'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRules::min(8)->letters()->symbols()]
        ];
    }
}
