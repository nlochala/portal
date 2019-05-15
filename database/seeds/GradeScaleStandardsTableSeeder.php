<?php

use App\Helpers\Helpers;
use App\GradeScaleStandard;
use Illuminate\Database\Seeder;

class GradeScaleStandardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('grade_scale_standards')->truncate();

        $grade_scale_standards = Helpers::parseCsv('database/seeds/data/grade_scale_standards.csv', false);

        foreach ($grade_scale_standards as $item) {
            $model = new GradeScaleStandard();
            $model->short_name = $item[1];
            $model->name = $item[2];
            $model->description = $item[3];
            $model->grade_scale_id = $item[4];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
