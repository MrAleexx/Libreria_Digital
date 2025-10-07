<?php

namespace App\Http\Requests\Mail;

use Illuminate\Foundation\Http\FormRequest;

class ClaimMailRequest extends FormRequest
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
            'name' => ['required', 'max:60'],
            'dni' => ['required', 'numeric', 'digits:8'],
            'email' => ['required', 'email'],
            'tipo_reclamo' => ['required', 'max:150', 'in:problema_descarga,cobro_indebido,acceso_cuenta,otro'],
            'subject' => ['required', 'max:100'],
            'description' => ['required']
        ];
    }
}
