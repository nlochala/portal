<?php

use App\Helpers\Helpers;
use App\PositionType;
use Illuminate\Database\Seeder;

class PositionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('position_types')->truncate();

        $position_types = Helpers::parseCsv('database/seeds/data/position_types.csv', true);

        foreach ($position_types as $type) {
            $model = new PositionType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
