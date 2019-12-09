<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
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

        $position_types = FileHelpers::parseCsv('database/seeds/data/position_types.csv', false);

        foreach ($position_types as $type) {
            $model = new PositionType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
