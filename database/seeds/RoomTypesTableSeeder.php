<?php

use App\RoomType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('room_types')->truncate();

        $room_types = Helpers::parseCsv('database/seeds/data/room_types.csv', false);

        foreach ($room_types as $type) {
            $model = new RoomType();
            $model->name = $type[2];
            $model->description = $type[3];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
