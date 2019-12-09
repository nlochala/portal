<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
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

        $student_statuses = FileHelpers::parseCsv('database/seeds/data/student_statuses.csv', false);

        foreach ($student_statuses as $type) {
            $model = new StudentStatus();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
