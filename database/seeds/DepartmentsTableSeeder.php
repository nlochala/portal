<?php

use App\Department;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('departments')->truncate();

        $departments = Helpers::parseCsv('database/seeds/data/departments.csv', false);

        foreach ($departments as $department) {
            $model = new Department();
            $model->name = $department[2];
            $model->description = $department[3];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
