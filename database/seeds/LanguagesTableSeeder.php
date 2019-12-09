<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Language;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('languages')->truncate();

        $languages = FileHelpers::parseCsv('database/seeds/data/languages.csv', true);

        foreach ($languages as $language) {
            $model = new Language();
            $model->name = $language[1];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
