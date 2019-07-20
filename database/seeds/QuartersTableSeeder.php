<?php

use App\Helpers\Helpers;
use App\Quarter;
use Illuminate\Database\Seeder;

class QuartersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('quarters')->truncate();

        $quarters = Helpers::parseCsv('database/seeds/data/quarters.csv', false);

        foreach ($quarters as $quarter) {
            $model = new Quarter();
            $model->name = $quarter[0];
            $model->year_id = $quarter[1];
            $model->start_date = $quarter[2];
            $model->end_date = $quarter[3];
            $model = Helpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
