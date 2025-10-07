<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:yape,plin,bank_transfer,email',
            'voucher' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'voucher.required' => 'El comprobante de pago es obligatorio',
            'voucher.image' => 'El archivo debe ser una imagen válida',
            'voucher.max' => 'La imagen no debe pesar más de 2MB'
        ];
    }
}
