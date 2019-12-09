<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();

        $permissions = FileHelpers::parseCsv('database/seeds/data/permissions.csv', false);

        foreach ($permissions as $permission) {
            $model = new Permission();
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->name = $permission[0];
            $model->description = $permission[1];
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
