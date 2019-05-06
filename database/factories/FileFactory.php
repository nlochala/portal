<?php

use App\FileExtension;
use App\User;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'uuid' => Uuid::generate(4),
        'file_extension_id' => $faker->randomElement(FileExtension::all()->pluck('id')),
        '.........' => '..............',
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
