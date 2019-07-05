<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentProfileRequest extends FormRequest
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
            'title' => 'required',
            'given_name' => 'required',
            'family_name' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'preferred_name' => 'required',
            'country_of_birth_id' => 'required',
            'language_primary_id' => 'required',
            'ethnicity_id' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'gender' => 'gender',
            'dob' => 'date of birth',
            'country_of_birth_id' => 'nationality',
            'language_primary_id' => 'primary language',
            'ethnicity_id' => 'ethnicity',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
