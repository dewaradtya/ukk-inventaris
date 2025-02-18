<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_amount' => 'required|numeric|min:1',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
