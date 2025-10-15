<?php

namespace App\Http\Requests\Admin\users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'institutional_email' => ['nullable', 'email', Rule::unique('users')->ignore($this->user)],
            'role' => 'required|in:admin,librarian,user',
            'is_active' => 'boolean',
            'dni' => ['required', 'numeric', 'digits:8', Rule::unique('users')->ignore($this->user)],
            'phone' => ['required', 'numeric', 'digits:9', Rule::unique('users')->ignore($this->user)],
            'password' => 'nullable|string|min:8|confirmed',
            'reset_temp_password' => 'boolean',
        ];
    }
}
