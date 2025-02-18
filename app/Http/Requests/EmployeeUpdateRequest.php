<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'nip' => 'required|unique:employees,nip,' . $this->employee,
            'address' => 'required',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
