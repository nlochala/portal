<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\File as ProjectFile;
use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('files')->truncate();

        $file_extensions = FileHelpers::parseCsv('database/seeds/data/files.csv', false);

        foreach ($file_extensions as $type) {
            $model = new ProjectFile();
            $model->file_extension_id = $type[0];
            $model->size = $type[1];
            $model->name = $type[2];
            $model->driver = $type[3];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
