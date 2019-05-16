<?php

use App\Position;
use App\PositionType;
use Illuminate\Database\Seeder;

class PositionsFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $types = PositionType::all();
        foreach ($types as $type) {
            factory(Position::class, 6)->create([
                'position_type_id' => $type->id,
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
