<?php

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\IdCard::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'person_id' => '',
        'front_image_file_id' => '',
        'back_image_file_id' => '',
        'is_active' => true,
        'number' => $faker->randomNumber(8),
        'name' => '乐天赐',
        'expiration_date' => Carbon::now()->addMonths(14)->format('Y-m-d'),
        'issue_date' => Carbon::now()->subMonths(6)->format('Y-m-d'),
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
