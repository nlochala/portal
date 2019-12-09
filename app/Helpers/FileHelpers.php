<?php


namespace App\Helpers;


class FileHelpers extends Helpers
{
    /**
     * This function returns the maximum files size that can be uploaded
     * in PHP.
     *
     * @returns int File size in bytes
     **/
    public static function getMaximumFileUploadSize()
    {
        return min(static::convertPHPSizeToBytes(ini_get('post_max_size')),
            static::convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Returns a human-readable form of filesize.
     *
     *
     * @param $bytes
     *
     * @return string
     */
    public static function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif (1 == $bytes) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * This method will convert a CSV file relative to document root
     * to an associative array.
     *
     * @param      $file_path
     * @param bool $remove_first_row
     *
     * @return array
     */
    public static function parseCsv($file_path, $remove_first_row = true)
    {
        $return_array = [];
        $file_path = base_path($file_path);

        // Open the file for reading
        if (false !== ($handle = fopen("{$file_path}", 'r'))) {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            $x = 0;
            while (false !== ($data = fgetcsv($handle, 1000, ','))) {
                if ($remove_first_row && 0 == $x) {
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
}
