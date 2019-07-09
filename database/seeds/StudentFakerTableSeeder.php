<?php

use App\Person;
use App\Student;
use App\GradeLevel;
use Illuminate\Database\Seeder;

class StudentFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Students
        DB::table('students')->truncate();
        $status = [1, 2, 4, 5];
        foreach ($status as $status_id) {
            foreach (GradeLevel::where('year_id', 1)->get() as $grade_level) {
                factory(Person::class, 5)->create()
                    ->each(static function ($person) use ($grade_level, $status_id) {
                        factory(Student::class)
                            ->create([
                                'grade_level_id' => $grade_level->id,
                                'person_id' => $person->id,
                                'family_id' => null,
                                'student_status_id' => $status_id,
                            ]);
                    });
            }
        }
        foreach (GradeLevel::where('year_id', 1)->get() as $grade_level) {
            factory(Person::class, 30)->create()
                ->each(static function ($person) use ($grade_level) {
                    factory(Student::class)
                        ->create([
                            'grade_level_id' => $grade_level->id,
                            'person_id' => $person->id,
                            'family_id' => null,
                            'student_status_id' => 3,
                        ]);
                });
        }
        Schema::enableForeignKeyConstraints();
    }
}
