<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ubah menjadi true agar request dapat diproses
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'condition' => 'required|string',
            'amount' => 'required|integer|min:1',
            'register_date' => 'required|date',
            'code' => 'required|string|unique:inventories,code,' . $this->inventory,
            'id_type' => 'required|exists:types,id',
            'id_room' => 'required|exists:rooms,id',
        ];
    }
}
