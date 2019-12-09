<?php

use App\EmployeeClassification;
use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class EmployeeClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('employee_classifications')->truncate();

        $employee_classifications = FileHelpers::parseCsv('database/seeds/data/employee_classifications.csv', false);

        foreach ($employee_classifications as $classification) {
            $model = new EmployeeClassification();
            $model->name = $classification[2];
            $model->description = $classification[3];
            $model->base_allowance = $classification[4];
            $model->housing_allowance = $classification[5];
            $model->medical_insurance_allowance = $classification[6];
            $model->social_insurance_allowance = $classification[7];
            $model->medical_covered = $classification[8];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
