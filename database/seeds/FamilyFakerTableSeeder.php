<?php

use App\Family;
use App\Student;
use App\Guardian;
use Illuminate\Database\Seeder;

class FamilyFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        //Guardian
        DB::table('families')->truncate();
        factory(Family::class, 700)->create();
        $guardians = Guardian::orderBy('uuid')->get();
        $students = Student::orderBy('uuid')->get();

        for ($i = 0; $i <= 699; $i++) {
            $guardians[$i]->family_id = $i;
            $guardians[$i]->save();
        }

        for ($i = 0; $i <= 599; $i++) {
            $guardians[$i + 700]->family_id = $i;
            $guardians[$i + 700]->save();
        }

        for ($i = 0; $i <= 699; $i++) {
            $students[$i]->family_id = $i;
            $students[$i]->save();
        }

        for ($i = 0; $i <= 99; $i++) {
            $students[$i + 700]->family_id = $i;
            $students[$i + 700]->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
