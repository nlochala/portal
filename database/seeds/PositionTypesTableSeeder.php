<?php

use App\Helpers;
use App\PositionType;
use Illuminate\Database\Seeder;

class PositionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('position_types')->truncate();
        Schema::enableForeignKeyConstraints();

        $position_types = Helpers::parseCsv('database/seeds/data/position_types.csv', true);

        foreach($position_types as $type){
            $model = new PositionType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }
    }
}
