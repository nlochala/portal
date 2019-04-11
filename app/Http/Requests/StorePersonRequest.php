<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'person_type_id' => 'type',
            'gender' => 'gender',
            'dob' => 'date of birth',
            'email_primary' => 'primary email',
            'email_secondary' => 'secondary email',
            'country_of_birth_id' => 'country',
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'person_type_id' => 'required',
            'title' => 'required',
            'given_name' => 'required',
            'family_name' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'email_primary' => 'required|email',
            'email_secondary' => 'required|email',
            'country_of_birth_id' => 'required',
            'language_primary_id' => 'required',
            'ethnicity_id' => 'required',
        ];
    }
}
