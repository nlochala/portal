<?php

use App\Helpers\Helpers;
use App\StudentStatus;
use Illuminate\Database\Seeder;

class StudentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('student_statuses')->truncate();

        $student_statuses = Helpers::parseCsv('database/seeds/data/student_statuses.csv', true);

        foreach ($student_statuses as $type) {
            $model = new StudentStatus();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = true;
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
