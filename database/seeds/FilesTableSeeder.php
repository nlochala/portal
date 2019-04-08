<?php

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

        $file_extensions = Helpers::parseCsv('database/seeds/data/files.csv', false);

        foreach($file_extensions as $type){
            $model = new ProjectFile();
            $model->file_extension_id = $type[0];
            $model->path = $type[1];
            $model->size = $type[2];
            $model->name = $type[3];
            $model->driver = $type[4];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
