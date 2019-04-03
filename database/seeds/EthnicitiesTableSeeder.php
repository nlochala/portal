<?php

use App\Ethnicity as Ethnicities;
use App\Helpers\Helpers;
use App\Ethnicity;
use Illuminate\Database\Seeder;

class EthnicitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ethnicities')->truncate();
        Schema::enableForeignKeyConstraints();

        $ethnicities = Helpers::parseCsv('database/seeds/data/ethnicities.csv', true);

        foreach($ethnicities as $type){
            $model = new Ethnicity();
            $model->name = $type[0];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }
    }
}
