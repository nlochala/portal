<?php

use App\Country;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\Passport::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'person_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'country_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'image_file_id' => '',
        'is_active' => true,
        'family_name' => $faker->lastName,
        'given_name' => $faker->firstNameMale,
        'number' => $faker->randomNumber(8),
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
