<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'nip' => 'required|unique:employees',
            'address' => 'required',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
