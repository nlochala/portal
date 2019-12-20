<?php

/* @var $factory Factory */

use App\Department;
use App\Helpers\DatabaseHelpers;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Department::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'name' => $faker->word,
        'description' => $faker->words(3,true),
    ]);
});
