<?php

use App\FileExtension;
use App\Helpers;
use Illuminate\Database\Seeder;

class FileExtensionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('file_extensions')->truncate();
        Schema::enableForeignKeyConstraints();

        $file_extensions = Helpers::parseCsv('database/seeds/data/file_extensions.csv', true);

        foreach($file_extensions as $type){
            $model = new FileExtension();
            $model->name = $type[2];
            $model->description = $type[3];
            $model->type = $type[1];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }
    }
}
