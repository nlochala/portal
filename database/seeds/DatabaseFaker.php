<?php

use Illuminate\Database\Seeder;

class DatabaseFaker extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PositionsFakerTableSeeder::class);
        $this->call(CoursesFakerTableSeeder::class);
        DB::unprepared(file_get_contents('database/seeds/data/families-students-guardians.sql'));

//        $this->call(StudentFakerTableSeeder::class);
//        $this->call(GuardianFakerTableSeeder::class);
//        $this->call(FamilyFakerTableSeeder::class);
    }
}
