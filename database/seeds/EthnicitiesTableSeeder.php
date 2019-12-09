<?php

use App\Ethnicity;
use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
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

        $ethnicities = FileHelpers::parseCsv('database/seeds/data/ethnicities.csv', true);

        foreach ($ethnicities as $type) {
            $model = new Ethnicity();
            $model->name = $type[0];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
