<?php

use App\AddressType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class AddressTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('address_types')->truncate();
        Schema::enableForeignKeyConstraints();

        $address_types = Helpers::parseCsv('database/seeds/data/address_types.csv', true);

        foreach($address_types as $type){
            $model = new AddressType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }
    }
}
