<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\Year;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('years')->truncate();

        $years = FileHelpers::parseCsv('database/seeds/data/years.csv', false);

        foreach ($years as $year) {
            $model = new Year();
            $model->year_start = $year[2];
            $model->year_end = $year[3];
            $model->start_date = $year[4];
            $model->end_date = $year[5];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
