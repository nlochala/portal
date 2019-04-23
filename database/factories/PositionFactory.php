<?php

use App\School;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\Position::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'name' => $faker->words(5, true),
        'description' => $faker->paragraphs(4, true),
        'school_id' => $faker->randomElement(School::all()->pluck('id')),
        'stipend' => $faker->randomNumber(4),
        'supervisor_position_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
        'user_created_id' => $faker->randomElement(\App\User::all()->pluck('id')),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(\App\User::all()->pluck('id')),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
