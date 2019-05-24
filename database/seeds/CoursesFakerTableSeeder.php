<?php

use App\Course;
use Illuminate\Database\Seeder;

class CoursesFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('courses')->truncate();
        factory(Course::class, 30)->create();

        Schema::enableForeignKeyConstraints();
    }
}
