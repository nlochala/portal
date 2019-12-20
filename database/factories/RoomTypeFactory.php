<?php

/* @var Factory $factory */

use App\Helpers\DatabaseHelpers;
use App\RoomType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(RoomType::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'name' => $faker->word,
        'description' => $faker->words(3,true),
    ]);
});
