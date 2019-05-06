<?php

use App\OfficialDocumentType;
use App\User;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\OfficialDocument::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'official_document_type_id' => $faker->randomElement(OfficialDocumentType::all()->pluck('id')->toArray()),
        'person_id' => '',
        'file_id' => '',
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
