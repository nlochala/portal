<?php

use App\FileExtension;
use App\Helpers\Helpers;
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

        $file_extensions = Helpers::parseCsv('database/seeds/data/file_extensions.csv', false);

        foreach ($file_extensions as $type) {
            $model = new FileExtension();
            $model->mime_apache = $type[1];
            $model->mime_nginx = $type[2];
            $model->name = $type[0];
            $model->description = $type[3];
            $model->type = $type[4];
            $model->is_protected = true;
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
