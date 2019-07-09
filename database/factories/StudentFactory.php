<?php

/* @var Factory $factory */

use App\User;
use App\Family;
use App\Person;
use App\Student;
use App\GradeLevel;
use App\StudentStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Webpatser\Uuid\Uuid;

$factory->define(Student::class, function (Faker $faker) {
    $student_status = $faker->randomElement(StudentStatus::all()->pluck('id')->toArray());
    $student_status < 4 ? $end_date = null : $end_date = $faker->dateTimeBetween('-2 years');

    return [
        'uuid' => Uuid::generate(4),
        'person_id' => $faker->randomElement(Person::all()->pluck('id')->toArray()),
        'family_id' => $faker->randomElement(Family::all()->pluck('id')->toArray()),
        'student_status_id' => $faker->randomElement(StudentStatus::all()->pluck('id')->toArray()),
        'grade_level_id' => $faker->randomElement(GradeLevel::all()->pluck('id')->toArray()),
        'start_date' => $faker->dateTimeBetween('-5 years', '-3 years'),
        'end_date' => $end_date,
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTimeBetween('-5 years'),
        'updated_at' => $faker->dateTimeBetween('-5 years'),
    ];
});
