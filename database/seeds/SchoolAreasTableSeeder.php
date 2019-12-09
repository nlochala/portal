<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\SchoolArea;
use Illuminate\Database\Seeder;

class SchoolAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('school_areas')->truncate();

        $school_areas = FileHelpers::parseCsv('database/seeds/data/school_areas.csv', false);

        foreach ($school_areas as $item) {
            $model = new SchoolArea();
            $model->name = $item[2];
            $model->description = $item[3];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
