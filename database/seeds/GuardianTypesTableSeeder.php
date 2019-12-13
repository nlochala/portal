<?php

use App\GuardianType;
use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class GuardianTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('guardian_types')->truncate();

        $student_statuses = FileHelpers::parseCsv('database/seeds/data/guardian_types.csv', false);

        foreach ($student_statuses as $type) {
            $model = new GuardianType();
            $model->name = $type[0];
            $model->description = $type[1];
            $model->is_protected = true;
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
