<?php

use App\School;
use App\User;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\Position::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'name' => $faker->words(3, true),
        'description' => $faker->paragraph(10, true),
        'school_id' => $faker->randomElement(School::all()->pluck('id')),
        'stipend' => $faker->randomNumber(1).'000',
        'supervisor_position_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
