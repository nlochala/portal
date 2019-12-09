<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Helpers\Helpers;
use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();

        $roles = FileHelpers::parseCsv('database/seeds/data/roles.csv', false);

        foreach ($roles as $role) {
            $model = new Role();
            $model = DatabaseHelpers::dbAddAudit($model);
            $model->name = $role[0];
            $model->description = $role[1];
            $model->is_protected = true;
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
