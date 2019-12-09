<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\PhoneType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class PhoneTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('phone_types')->truncate();

        $phone_types = FileHelpers::parseCsv('database/seeds/data/phone_types.csv', true);

        foreach ($phone_types as $type) {
            $model = new PhoneType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
