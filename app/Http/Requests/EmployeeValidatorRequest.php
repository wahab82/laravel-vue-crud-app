<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeValidatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'email'      => 'nullable|string|email|max:255|unique:employees,email,'.$this->id,
            'phone'      => 'nullable|string|max:30',
            'company_id' => 'required',
        ];
    }

    /**
     * custom message
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'company_id.required' => 'Please select company name',
        ];
    }
}
