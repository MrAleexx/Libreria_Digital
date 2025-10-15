<?php

namespace App\Http\Requests\Admin\users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'institutional_email' => ['nullable', 'email', 'unique:users'],
            'role' => 'required|in:admin,librarian,user',
            'dni' => ['required', 'numeric', 'digits:8', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:9', 'unique:users'],
            'send_credentials' => 'boolean',
        ];
    }
}
