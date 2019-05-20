<?php

namespace App\Helpers;

use Storage;
use App\File;
use Carbon\Carbon;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

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
     * @param $path
     * @param bool $strict
     * @return bool
     */
    public static function isUri($path, $strict = true)
    {
        $request_prefix = explode('/', request()->getRequestUri())[1];
        $path_prefix = explode('/', $path)[1];

        if (request()->getRequestUri() == $path) {
            return true;
        }

        if (! $strict && ($request_prefix == $path_prefix)) {
            return true;
        }

        return false;
    }

    /**
     * Return the proper badge for the expiration date.
     *
     * @param Carbon $expiration_date
     * @param string $item_name
     * @param int    $danger
     * @param int    $warning
     *
     * @return string
     */
    public static function getExpirationBadge(Carbon $expiration_date, $item_name = null, int $danger = 180, int $warning = 365)
    {
        if ($expiration_date->isPast()) {
            return '<span class="badge badge-dark"><i class="fa fa-pause-circle"></i> EXPIRED</span>';
        }

        switch ($x = $expiration_date->diffInDays()) {
            case $x < $danger:
                $color = 'danger';
                $icon = 'fa fa-calendar-times';
                break;
            case $x < $warning:
                $color = 'warning';
                $icon = 'fa fa-exclamation-circle';
                break;
            default:
                $color = 'primary';
                $icon = 'fa fa-check';
                break;
        }

        if ($item_name) {
            $item_name = "$item_name expires ";
        }

        return '<span class="badge badge-'
            .$color.'"><i class="'.$icon.'"></i> '.$item_name
            .$expiration_date->diffForHumans().'.</span>';
    }

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
            $bytes = number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2).' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes.' bytes';
        } elseif (1 == $bytes) {
            $bytes = $bytes.' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /**
     * Session flash session message for failed or successful form submissions.
     *
     * @param        $result
     * @param string $item
     * @param string $action
     */
    public static function flash($result, $item = 'form', $action = 'created')
    {
        if ($result) {
            Helpers::flashAlert(
                'success',
                'The '.$item.' was '.$action.' successfully!',
                'fa fa-check mr-1');
        } else {
            Helpers::flashAlert(
                'danger',
                'The '.$item.' did not '.$action.' successfully. Please try again.',
                'fa fa-info-circle mr-1');

            return;
        }
    }

    /**
     * Display an onclick HTML snippet.
     *
     * @param $url
     *
     * @return string
     */
    public static function onClick($url)
    {
        return 'onclick="window.location.href=\''.$url.'\'"';
    }

    /**
     * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case).
     *
     * @param string $sSize
     *
     * @return int The value in bytes
     */
    protected static function convertPHPSizeToBytes($sSize)
    {
        /** @noinspection PhpVariableNamingConventionInspection */
        $sSuffix = strtoupper(substr($sSize, -1));
        if (! in_array($sSuffix, ['P', 'T', 'G', 'M', 'K'])) {
            return (int) $sSize;
        }
        /** @noinspection PhpVariableNamingConventionInspection */
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                /* @noinspection PhpVariableNamingConventionInspection */
                $iValue *= 1024;
            // Fallthrough intended
            // no break
            case 'T':
                /* @noinspection PhpVariableNamingConventionInspection */
                $iValue *= 1024;
            // Fallthrough intended
            // no break
            case 'G':
                /* @noinspection PhpVariableNamingConventionInspection */
                $iValue *= 1024;
            // Fallthrough intended
            // no break
            case 'M':
                /* @noinspection PhpVariableNamingConventionInspection */
                $iValue *= 1024;
            // Fallthrough intended
            // no break
            case 'K':
                /* @noinspection PhpVariableNamingConventionInspection */
                $iValue *= 1024;
                break;
        }

        return (int) $iValue;
    }

    /**
     * Display an image based on the given File instance.
     *
     * @param File $file
     * @param null $height
     * @param null $width
     * @param bool $is_constraint
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    public static function displayImage(File $file, $height = null, $width = null, $is_constraint = true)
    {
        $contents = Storage::disk($file->driver)->get($file->getFullPath());
        $extension = $file->extension->name;

        if ($height || $width) {
            if ($is_constraint) {
                $img = Image::make($contents)->resize($height, $width, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $img = Image::make($contents)->resize($height, $width);
            }
        } else {
            $img = Image::make($contents);
        }

        $img->encode($extension);

        return 'data:image/'.$extension.';base64,'.base64_encode($img);
    }

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

    /**
     * Set the DB Audit Fields.
     *
     * @param $model
     *
     * @return mixed
     */
    public static function dbAddAudit($model)
    {
        auth()->user() ? $user_id = auth()->user()->id : $user_id = 1;

        if (is_array($model)) {
            $model['user_created_id'] = auth()->id();
            $model['user_created_ip'] = Helpers::getUserIp();

            return $model;
        }

        /* @noinspection PhpUndefinedMethodInspection */
        if ($model->exists) {
            $model->user_updated_id = $user_id;
            $model->user_updated_ip = static::getUserIp();
        } elseif (! $model->exists) {
            $model->user_created_id = $user_id;
            $model->user_created_ip = static::getUserIp();
        }

        return $model;
    }

    /**
     * Return the user's IP address.
     *
     * @return string
     */
    public static function getUserIp()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)
            && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])
        ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])
                && ! empty($_SERVER['REMOTE_ADDR'])
            ) {
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        return '127.0.0.1';
    }

    /**
     * Set the session so that a flash message will pop up.
     *
     * @param        $color
     * @param        $message
     * @param null   $icon
     * @param string $location
     */
    public static function flashAlert($color, $message, $icon = null, $location = 'bottom')
    {
        session()->flash('color', $color);
        session()->flash('message', $message);
        session()->flash('icon', $icon);
        session()->flash('location', $location);
    }

    /**
     * Set the session so that a modal window will appear.
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
