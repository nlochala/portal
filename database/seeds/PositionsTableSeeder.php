<?php

use App\Helpers\Helpers;
use App\Position;
use App\PositionType;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('positions')->truncate();

        $positions = Helpers::parseCsv('database/seeds/data/positions.csv', false);

        foreach ($positions as $position) {
            $model = new Position();
            $model->name = $position[0];
            $model->description = $position[1];
            $model->school_id = $position[2];
            $model->position_type_id = $position[3];
            $model->supervisor_position_id = $position[4];
            $model->stipend = $position[6];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }

}
