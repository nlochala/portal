<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\OfficialDocumentType;
use Illuminate\Database\Seeder;

class OfficialDocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('official_document_types')->truncate();

        $official_document_types = FileHelpers::parseCsv('database/seeds/data/official_document_types.csv', false);

        foreach ($official_document_types as $type) {
            $model = new OfficialDocumentType();
            $model->name = $type[2];
            $model->person_type_id = $type[4];
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
