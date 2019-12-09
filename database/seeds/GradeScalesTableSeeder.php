<?php

use App\GradeScale;
use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class GradeScalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('grade_scales')->truncate();

        $grade_scales = FileHelpers::parseCsv('database/seeds/data/grade_scales.csv', false);

        foreach ($grade_scales as $scale) {
            $model = new GradeScale();
            $model->name = $scale[2];
            $model->description = $scale[3];
            $model->is_percentage_based = $scale[4];
            $model->is_standards_based = $scale[5];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
