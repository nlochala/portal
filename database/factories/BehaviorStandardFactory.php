<?php

/** @var Factory $factory */

use App\BehaviorStandard;
use App\Helpers\DatabaseHelpers;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(BehaviorStandard::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'name' => $faker->words(3, true),
        'description' => $faker->sentences(2, true),
    ]);
});
