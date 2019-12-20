<?php

/* @var $factory Factory */

use App\Helpers\DatabaseHelpers;
use App\Quarter;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Quarter::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'name' => $faker->numberBetween(1,4),
        'year_id' => function () {
            return factory('App\Year')->create()->id;
        },
        'instructional_days' => $faker->numberBetween(20,50),
        'start_date' => '2020-08-22',
        'end_date' => '2020-10-01',
    ]);
});
