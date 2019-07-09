<?php

/* @var Factory $factory */

use App\User;
use App\Family;
use App\Person;
use App\Guardian;
use App\GuardianType;
use Webpatser\Uuid\Uuid;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Guardian::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'person_id' => $faker->randomElement(Person::all()->pluck('id')->toArray()),
        'family_id' => $faker->randomElement(Family::all()->pluck('id')->toArray()),
        'guardian_type_id' => $faker->randomElement(GuardianType::all()->pluck('id')->toArray()),
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTimeBetween('-5 years'),
        'updated_at' => $faker->dateTimeBetween('-5 years'),
    ];
});
