<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'borrow_date' => 'required|date',
            'id_inventories' => 'required|array',
            'id_inventories.*' => 'exists:inventories,id',
            'amount' => 'required|array',
            'amount.*' => 'integer|min:1',
            'id_employee' => 'nullable|exists:employees,id',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
        ];
    }
}
