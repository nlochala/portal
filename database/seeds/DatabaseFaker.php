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
    }
}
