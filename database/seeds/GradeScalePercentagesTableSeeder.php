<?php

use App\GradeScalePercentage;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class GradeScalePercentagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('grade_scale_percentages')->truncate();

        $grade_scale_percentages = Helpers::parseCsv('database/seeds/data/grade_scale_percentages.csv', false);

        foreach ($grade_scale_percentages as $item) {
            $model = new GradeScalePercentage();
            $model->grade_scale_id = $item[0];
            $model->from = $item[1];
            $model->to = $item[2];
            $model->result = $item[3];
            $model->equivalent_standard_id = $item[6];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
