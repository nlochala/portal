<?php

use App\Role;
use App\Helpers\FileHelpers;
use Illuminate\Database\Seeder;

class PermissionsRolesPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions_roles_pivot')->truncate();

        $permissions_roles_pivot = FileHelpers::parseCsv('database/seeds/data/permissions_roles_pivot.csv', false);

        foreach ($permissions_roles_pivot as $item) {
            $role = Role::findOrFail($item[1]);
            $role->permissions()->attach($item[0]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
