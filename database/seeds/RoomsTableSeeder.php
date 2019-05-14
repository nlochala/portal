<?php

use App\Helpers\Helpers;
use App\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('rooms')->truncate();

        $rooms = Helpers::parseCsv('database/seeds/data/rooms.csv', true);

        foreach ($rooms as $room) {
            $model = new Room();
            $model->number = $room[0];
            $model->description = $room[1];
            $model->room_type_id = $room[2];
            $model->building_id = $room[3];
            $model->phone_extension = $room[4];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
