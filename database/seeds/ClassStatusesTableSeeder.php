<?php

use App\ClassStatus;
use App\CourseType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class ClassStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('class_statuses')->truncate();

        $course_types = Helpers::parseCsv('database/seeds/data/class_statuses.csv', false);

        foreach ($course_types as $type) {
            $model = new ClassStatus();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = $type[2];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
