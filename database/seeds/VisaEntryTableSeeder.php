<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\VisaEntry;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class VisaEntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('visa_entries')->truncate();

        $visa_entries = FileHelpers::parseCsv('database/seeds/data/visa_entries.csv', true);

        foreach ($visa_entries as $type) {
            $model = new VisaEntry();
            $model->name = $type[0];

            empty($type[1]) ?: $model->number_of_entries = $type[1];

            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
