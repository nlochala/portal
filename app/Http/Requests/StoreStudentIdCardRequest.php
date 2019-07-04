<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentIdCardRequest extends FormRequest
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
            'upload_front' => 'required',
            'upload_back' => 'required',
            'is_active' => 'required',
            'number' => 'required',
            'name' => 'required',
            'issue_date' => 'required',
            'expiration_date' => 'required',
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
            'front_image_file_id' => 'front of ID Card image',
            'back_image_file_id' => 'back of ID Card image',
            'is_active' => 'card status',
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
