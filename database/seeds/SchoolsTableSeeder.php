<?php

use App\Helpers\Helpers;
use App\School;
use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('schools')->truncate();

        $schools = Helpers::parseCsv('database/seeds/data/schools.csv', false);

        foreach ($schools as $school) {
            $model = new School();
            $model->name = $school[0];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
