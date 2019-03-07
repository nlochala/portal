<?php

namespace App;

use Carbon\Carbon;

class Helpers
{
    /**
     * @var Carbon
     */
    protected $today;

    /**
     * Helpers constructor.
     */
    public function __construct()
    {
        $this->today = Carbon::today();
    }

    /**
     * This method will convert a CSV file relative to document root
     * to an associative array.
     *
     * @param $file_path
     * @param bool $remove_first_row
     * @return array
     */
    public static function parseCsv($file_path, $remove_first_row = true)
    {
        $return_array = [];

        // Open the file for reading
        if (($handle = fopen("{$file_path}", "r")) !== FALSE) {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            $x = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if($remove_first_row && $x == 0){
                    $x++;
                    continue;
                }
                // Each individual array is being pushed into the nested array
                $return_array[] = $data;
            }
            // Close the file
            fclose($handle);
        }

        return $return_array;
    }

    /**
     * Set the DB Audit Fields
     *
     * @param $model
     * @return mixed
     */
    public static function dbAddAudit($model)
    {
        auth()->user() ? $user_id = auth()->user()->id : $user_id = 1;

        if ($model->exists && $model->isDirty()) {
            $model->user_updated_id = $user_id;
            $model->user_updated_ip = static::getUserIp();
        } elseif (!$model->exists) {
            $model->user_created_id = $user_id;
            $model->user_created_ip = static::getUserIp();
        }

        return $model;
    }

    /**
     * Return the user's IP address
     *
     * @return string
     */
    public static function getUserIp()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)
            && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
        ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);

                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])
                && !empty($_SERVER['REMOTE_ADDR'])
            ) {
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        return '127.0.0.1';
    }

    /**
     * Set the session so that a flash message will pop up
     *
     * @param      $level
     * @param      $message
     * @param bool $stay_open
     */
    public static function flashAlert($level, $message, $stay_open = false)
    {
        session()->flash('stay_open', $stay_open);
        session()->flash('message', $message);
        session()->flash('level', $level);
    }

    /**
     * Set the session so that a modal window will appear
     *
     * @param $title
     * @param $message
     */
    public static function flashModal($title, $message)
    {
        session()->flash('modal', true);
        session()->flash('message', $message);
        session()->flash('title', $title);
    }
}