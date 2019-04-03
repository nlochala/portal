<?php

namespace App\Http\Controllers;

use App\File;
use Storage;

class MediaController extends Controller
{
    /**
     * Download the given file
     *
     * @param File $file
     * @return mixed
     */
    public function downloadFile(File $file)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return Storage::download($file->getFullPath(), $file->public_name . '.' . $file->extension->name);
    }
}
