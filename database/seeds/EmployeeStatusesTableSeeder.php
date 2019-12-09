<?php

use App\EmployeeStatus;
use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class EmployeeStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('employee_statuses')->truncate();

        $employee_statuses = FileHelpers::parseCsv('database/seeds/data/employee_statuses.csv', false);

        foreach ($employee_statuses as $type) {
            $model = new EmployeeStatus();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = true;
            $model->base_weight = $type[2];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
