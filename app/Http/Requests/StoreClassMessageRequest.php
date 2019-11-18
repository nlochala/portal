<?php

namespace App\Http\Requests;

use App\CourseClass;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassMessageRequest extends FormRequest
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
            'student_id' => 'required_if:all_students,0',
            'subject' => 'required',
            'message_body' => 'required',
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
            'message_body' => 'message',
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
        return [
            'student_id.required_if' => 'This is required if you are sending to only individual student parents.',
        ];
    }
}

