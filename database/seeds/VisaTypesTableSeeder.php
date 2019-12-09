<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\VisaType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class VisaTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('visa_types')->truncate();

        $visa_types = FileHelpers::parseCsv('database/seeds/data/visa_types.csv', true);

        foreach ($visa_types as $type) {
            $model = new VisaType();
            $model->code = $type[0];
            $model->name = $type[1];
            $model->description = $type[2];
            $model->residency = $type[3];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
