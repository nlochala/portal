<?php

use App\CourseType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class CourseTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('course_types')->truncate();

        $course_types = Helpers::parseCsv('database/seeds/data/course_types.csv', false);

        foreach ($course_types as $type) {
            $model = new CourseType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = $type[2];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
