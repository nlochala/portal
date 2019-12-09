<?php

use App\Helpers\FileHelpers;
use App\Student;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class StudentUsernameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $students = FileHelpers::parseCsv('database/seeds/data/student_passwords.csv', false);

        foreach ($students as $student) {
            $username = explode('@', $student[0])[0];
            preg_match('/[0-9]+/', $student[0], $num);
            $id = $num[0];
            $model = Student::find($id);
            if ($model instanceof Student) {
                $model->username = $username;
                $model->password = $student[2];
                $model->save();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
