<?php

/* @var Factory $factory */

use App\Building;
use App\Helpers\DatabaseHelpers;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Building::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'short_name' => strtoupper($faker->randomLetter),
        'name' => $faker->words(3, true)
    ]);
});
