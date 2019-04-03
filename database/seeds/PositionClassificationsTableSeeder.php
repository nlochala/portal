<?php

use App\Helpers\Helpers;
use App\PositionClassification;
use Illuminate\Database\Seeder;

class PositionClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('position_classifications')->truncate();
        Schema::enableForeignKeyConstraints();

        $position_classifications = Helpers::parseCsv('database/seeds/data/position_classifications.csv', true);

        foreach($position_classifications as $type){
            $model = new PositionClassification();
            $model->name = $type[0];
            $model->description = $type[1];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }
    }
}
