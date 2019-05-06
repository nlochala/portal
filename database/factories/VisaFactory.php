<?php

use App\User;
use App\VisaEntry;
use App\VisaType;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\Visa::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'passport_id' => '',
        'visa_type_id' => $faker->randomElement(VisaType::all()->pluck('id')->toArray()),
        'visa_entry_id' => $faker->randomElement(VisaEntry::all()->pluck('id')->toArray()),
        'entry_duration' => $faker->randomNumber(2),
        'image_file_id' => '',
        'is_active' => true,
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
