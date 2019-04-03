<?php

namespace App\Console\Commands;

use App\File;
use Illuminate\Console\Command;
use Storage;

class ProcessFileSizes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:process-file-sizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process filesizes of those files registered in the files table.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = File::emptySize()->get();
        if($files->isEmpty()){
            return;
        }

        foreach($files as $file) {
            $file->update(['size' => Storage::size($file->getFullPath())]);
        }

        return;
    }
}
