<?php

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

        $permissions = Helpers::parseCsv('database/seeds/data/permissions.csv', false);

        foreach ($permissions as $permission) {
            $model = new Permission();
            $model = Helpers::dbAddAudit($model);
            $model->name = $permission[0];
            $model->description = $permission[1];
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
