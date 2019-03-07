<?php

use App\Helpers;
use App\VisaType;
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
        Schema::enableForeignKeyConstraints();

        $visa_types = Helpers::parseCsv('database/seeds/data/visa_types.csv', true);

        foreach($visa_types as $type){
            $model = new VisaType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->residency = $type[2];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }
    }
}
