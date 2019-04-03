<?php

use App\EmployeeStatus;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class EmployeeStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('employee_statuses')->truncate();
        Schema::enableForeignKeyConstraints();

        $employee_statuses = Helpers::parseCsv('database/seeds/data/employee_statuses.csv', true);

        foreach($employee_statuses as $type){
            $model = new EmployeeStatus();
            $model->name = $type[0];
            $model->description = $type[1];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

    }
}
