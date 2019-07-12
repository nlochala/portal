<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'start_date' => 'required',
            'email_school' => 'required',
            'employee_classification_id' => 'required',
            'employee_status_id' => 'required',
            'title' => 'required',
            'given_name' => 'required',
            'family_name' => 'required',
            'preferred_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        // 'dob' => 'date of birth',
        return [
            'employee_classification_id' => 'classification',
            'employee_status_id' => 'status',
            'dob' => 'date of birth',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        // 'dob.required' => 'Your date of birth is required.',
        return [];
    }
}

