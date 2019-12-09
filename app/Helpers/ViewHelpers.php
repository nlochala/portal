<?php


namespace App\Helpers;


use App\File;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManagerStatic as Image;

class ViewHelpers extends Helpers
{
    /**
     * Get colored badges given a specific percentage.
     *
     * @param $percentage
     * @param $badge_text
     * @return string
     */
    public static function colorPercentages($percentage, $badge_text)
    {
        switch ($number = round($percentage)) {
            case $number >= 90:
                $color = 'success';
                break;
            case $number >= 80:
                $color = 'primary';
                break;
            case $number >= 70:
                $color = 'warning';
                break;
            default:
                $color = 'danger';
                break;
        }

        return '<span class="badge badge-' . $color . '">' . $badge_text . '</span>';
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

        if (!$strict && ($request_prefix == $path_prefix)) {
            return true;
        }

        return false;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return a checked string if the values equal each other.
     *
     * @param bool $is_checked
     * @return string
     */
    public static function isChecked($is_checked = false)
    {
        if ($is_checked) {
            return 'checked';
        }

        return '';
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return the proper badge for the expiration date.
     *
     * @param Carbon $expiration_date
     * @param string $item_name
     * @param int $danger
     * @param int $warning
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
            . $color . '"><i class="' . $icon . '"></i> ' . $item_name
            . $expiration_date->diffForHumans() . '.</span>';
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
            static::flashAlert(
                'success',
                'The ' . $item . ' was ' . $action . ' successfully!',
                'fa fa-check mr-1');
        } else {
            static::flashAlert(
                'danger',
                'The ' . $item . ' did not ' . $action . ' successfully. Please try again.',
                'fa fa-info-circle mr-1');

            return;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Display an onclick HTML snippet.
     *
     * @param $url
     *
     * @return string
     */
    public static function onClick($url)
    {
        return 'onclick="window.location.href=\'' . $url . '\'"';
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Display an image based on the given File instance.
     *
     * @param File $file
     * @param null $height
     * @param null $width
     * @param bool $is_constraint
     *
     * @return string
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

        return 'data:image/' . $extension . ';base64,' . base64_encode($img);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set the session so that a flash message will pop up.
     *
     * @param        $color
     * @param        $message
     * @param null $icon
     * @param string $location
     */
    public static function flashAlert($color, $message, $icon = null, $location = 'bottom')
    {
        session()->flash('color', $color);
        session()->flash('message', $message);
        session()->flash('icon', $icon);
        session()->flash('location', $location);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Calculate a person's age from a given dob.
     *
     * @param Carbon $dob
     * @return string
     */
    public static function getAge(Carbon $dob)
    {
        if ($dob->age > 1) {
            return $dob->age . ' Years Old';
        }

        return Carbon::now()->diffInMonths($dob) . ' Months Old';
    }

}
