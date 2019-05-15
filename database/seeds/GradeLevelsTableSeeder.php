<?php

use App\GradeLevel;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class GradeLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('grade_levels')->truncate();

        $grade_levels = Helpers::parseCsv('database/seeds/data/grade_levels.csv', false);

        foreach ($grade_levels as $level) {
            $model = new GradeLevel();
            $model->short_name = $level[2];
            $model->name = $level[3];
            $model->year_id = $level[4];
            $model->school_id = $level[5];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
