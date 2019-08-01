<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'year_id' => 'required',
            'department_id' => 'required',
            'short_name' => 'required',
            'name' => 'required',
            'description' => 'required',
            'course_type_id' => 'required',
            'grade_scale_id' => 'required',
            'course_transcript_type_id' => 'required',
            'grade_levels' => 'required',
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
            'department_id' => 'department',
            'course_type_id' => 'course type',
            'grade_scale_id' => 'grade scale',
            'course_transcript_type_id' => 'transcript type',
            'year_id' => 'year',
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
