<?php

use App\EmployeeBonusType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class EmployeeBonusTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('employee_bonus_types')->truncate();

        $employee_bonus_types = Helpers::parseCsv('database/seeds/data/employee_bonus_types.csv', false);

        foreach ($employee_bonus_types as $type) {
            $model = new EmployeeBonusType();
            $model->name = $type[2];
            $model->description = $type[3];
            $model->amount = $type[4];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
