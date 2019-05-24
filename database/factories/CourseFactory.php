<?php

/* @var Factory $factory */

use App\User;
use App\Year;
use App\Course;
use App\CourseType;
use App\Department;
use App\GradeScale;
use Webpatser\Uuid\Uuid;
use App\CourseTranscriptType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'short_name' => strtoupper($faker->bothify('???0#')),
        'name' => $faker->words(3, true),
        'description' => $faker->sentences(1, true),
        'credits' => $faker->randomDigitNotNull,
        'max_class_size' => 18,
        'is_active' => $faker->boolean(85),
        'has_attendance' => true,
        'show_on_report_card' => true,
        'calculate_report_card' => true,
        'calculate_on_transcript' => true,
        'is_protected' => false,
        'course_transcript_type_id' => $faker->randomElement(CourseTranscriptType::all()->pluck('id')->toArray()),
        'grade_scale_id' => $faker->randomElement(GradeScale::all()->pluck('id')->toArray()),
        'department_id' => $faker->randomElement(Department::all()->pluck('id')->toArray()),
        'course_type_id' => $faker->randomElement(CourseType::all()->pluck('id')->toArray()),
        'year_id' => $faker->randomElement(Year::all()->pluck('id')->toArray()),
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
