<?php

namespace App\Helpers;

use App\File;

class TestHelpers
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

    public static function getSampleFile()
    {
        $original_file = File::whereType('Document')->first();
        $new_file = $original_file->replicate();
        $new_file->save();

        return $new_file;
    }
}

