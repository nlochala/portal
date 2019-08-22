<?php

use App\AttendanceType;
use App\ClassStatus;
use App\CourseType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class AttendanceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('attendance_types')->truncate();

        $types = Helpers::parseCsv('database/seeds/data/attendance_types.csv', false);

        foreach ($types as $type) {
            $model = new AttendanceType();
            $model->short_name = $type[0];
            $model->name = $type[1];
            $model->description = $type[2];
            $model->should_alert = $type[3];
            $model->is_present = $type[4];
            $model->is_protected = true;
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
