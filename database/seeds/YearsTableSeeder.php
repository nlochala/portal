<?php

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

        $years = Helpers::parseCsv('database/seeds/data/years.csv', false);

        foreach ($years as $year) {
            $model = new Year();
            $model->year_start = $year[2];
            $model->year_end = $year[3];
            $model->start_date = $year[4];
            $model->end_date = $year[5];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
