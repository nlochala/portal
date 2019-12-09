<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\PersonType;
use Illuminate\Database\Seeder;

class PersonTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('person_types')->truncate();

        $person_types = FileHelpers::parseCsv('database/seeds/data/person_types.csv', false);

        foreach ($person_types as $type) {
            $model = new PersonType();
            $model->name = $type[2];
            $model->description = $type[3];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
