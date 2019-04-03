<?php

namespace App\Helpers;


class FieldValidation
{
    /**
     * This is a constructed array that grows as errors are added.
     *
     * @var
     */
    protected $errors;

    /**
     * This array is the one that is eventually returned. It contains,
     * when constructed, the errors array.
     *
     * @var
     */
    protected $error_array;

    /**
     * Construct the empty data portion of the returned array.
     * FieldValidation constructor.
     */
    public function __construct()
    {
        $this->error_array['data'] = array();
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION CHECKS
    |--------------------------------------------------------------------------
    */
    /**
     * This is the "field is required" check. If the field is empty, it writes to the
     * error parameter.
     *
     * @param $field
     * @param $data
     * @param string $message
     */
    public function required($field, $data, $message = 'This field is required.')
    {
        if(empty($data[$field]))
        {
            $this->errors[] = [
                'name' => $field,
                'status' => $message
            ];
        }
    }

    /**
     * This will check that the given email is valid.
     *
     * @param $field
     * @param $data
     * @param string $message
     */
    public function email($field, $data, $message = 'This field requires a valid email.')
    {
        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = [
                'name' => $field,
                'status' => $message
            ];
        }
    }

    /**
     * This will check that the given url is valid.
     *
     * @param $field
     * @param $data
     * @param string $message
     */
    public function url($field, $data, $message = 'This field requires a valid url.')
    {
        if (!filter_var($data[$field], FILTER_VALIDATE_URL)) {
            $this->errors[] = [
                'name' => $field,
                'status' => $message
            ];
        }
    }

    /**
     * Check 2 passwords and see if they match or not.
     *
     * @param $password_field1
     * @param $password_field2
     * @param $user_data
     * @param string $message
     */
    public function passwordConfirmation($password_field1, $password_field2, $user_data, $message = 'These passwords do not match!')
    {
        if($user_data[$password_field1] !== $user_data[$password_field2])
        {
            $this->errors[] = [
                'name' => $password_field1,
                'status' => $message
            ];

            $this->errors[] = [
                'name' => $password_field2,
                'status' => $message
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RETURN ARRAY
    |--------------------------------------------------------------------------
    */
    /**
     * This is the constructed array that is returned.
     *
     * @return bool
     */
    public function hasErrors()
    {
        if(!empty($this->errors))
        {
            $this->error_array['fieldErrors'] = $this->errors;
            return $this->error_array;
        }

        return false;
    }

}