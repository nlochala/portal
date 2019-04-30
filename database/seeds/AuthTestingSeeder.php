<?php

use App\AdGroup;
use App\Employee;
use App\Helpers\Helpers;
use App\User;
use App\Person;
use Illuminate\Database\Seeder;

class AuthTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('persons')->truncate();
        $persons = Helpers::parseCsv('database/seeds/data/persons.csv', false);

        foreach ($persons as $person) {
            $person_model = new Person();
            $person_model->email_school = $person[9];
            $person_model->person_type_id = $person[14];
            $person_model = Helpers::dbAddAudit($person_model);
            $person_model->save();
        }

        DB::table('users')->truncate();
        $users = Helpers::parseCsv('database/seeds/data/users.csv', false);

        foreach ($users as $user) {
            $user_model = new User();
            $user_model->person_id = $person_model->id;
            $user_model->username = $user[3];
            $user_model->email = $user[4];
            $user_model->display_name = $user[5];
            $user_model->given_name = $user[6];
            $user_model->family_name = $user[7];
            $user_model->azure_id = $user[8];
            $user_model = Helpers::dbAddAudit($user_model);
            $user_model->save();
        }

        DB::table('employees')->truncate();
        $employees = Helpers::parseCsv('database/seeds/data/employees.csv', false);

        foreach ($employees as $employee) {
            $model = new Employee();
            $model->person_id = $person_model->id;
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        DB::table('ad_groups')->truncate();
        DB::table('ad_groups_users_pivot')->truncate();
        $ad_groups = Helpers::parseCsv('database/seeds/data/ad_groups.csv', false);

        foreach ($ad_groups as $group) {
            $model = new AdGroup();
            $model->azure_id = $group[2];
            $model->name = $group[3];
            $model->email = $group[4];
            $model = Helpers::dbAddAudit($model);
            $model->save();

            $user_model->adGroups()->attach($model->id);
        }

        Schema::enableForeignKeyConstraints();
    }
}
