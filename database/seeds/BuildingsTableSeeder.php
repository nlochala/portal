<?php

use App\Building;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('buildings')->truncate();

        $buildings = Helpers::parseCsv('database/seeds/data/buildings.csv', false);

        foreach ($buildings as $building) {
            $model = new Building();
            $model->short_name = $building[2];
            $model->name = $building[3];
            $model->is_protected = true;
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
