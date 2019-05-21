<?php

use App\Country;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('countries')->truncate();

        $countries = Helpers::parseCsv('database/seeds/data/countries.csv', true);

        foreach ($countries as $country) {
            $model = new Country();
            $model->name = $country[0];
            $model->country_code = $country[1];
            $model->is_protected = true;
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
