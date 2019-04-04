<?php

namespace App\Http\Controllers;

use App\File;
use App\FileAudit;
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
        $file->update(['download_count' => ++$file->download_count]);
        FileAudit::newAudit($file);

        /** @noinspection PhpUndefinedMethodInspection */
        return Storage::disk($file->driver)
            ->download($file->getFullPath() , $file->public_name . '.' . $file->extension->name);
    }
}
