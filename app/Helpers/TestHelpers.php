<?php

namespace App\Helpers;

use App\File;

class TestHelpers extends Helpers
{
    /**
     * Create sample images and return them.
     *
     * @return mixed
     */
    public static function getSampleImage()
    {
        $last_image = File::whereType('Graphics')->first();
        $new_image = $last_image->replicate();
        $new_image->original_file_id = $last_image->id;
        $new_image->save();

        return $new_image;
    }

    /**
     * Create a sample file and return the file model.
     *
     * @return mixed
     */
    public static function getSampleFile()
    {
        $original_file = File::whereType('Document')->first();
        $new_file = $original_file->replicate();
        $new_file->save();

        return $new_file;
    }

    /**
     * We have selectors that might contain spaces or other invalid jQuery selectors.
     * We need to sanitize them and then return back to the requesting function.
     *
     * @param $selector
     * @return mixed
     */
    public static function sanitizeSelectors($selector)
    {
        return str_replace(' ', '\ ', $selector);
    }
}
