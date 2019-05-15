<?php

use App\CourseTranscriptType;
use App\Helpers\Helpers;
use Illuminate\Database\Seeder;

class CourseTranscriptTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('course_transcript_types')->truncate();

        $course_transcript_types = Helpers::parseCsv('database/seeds/data/course_transcript_types.csv', false);

        foreach ($course_transcript_types as $item) {
            $model = new CourseTranscriptType();
            $model->name = $item[2];
            $model->description = $item[3];
            $model = Helpers::dbAddAudit($model);
            $model->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
