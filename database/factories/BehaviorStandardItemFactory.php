<?php

/** @var Factory $factory */

use App\BehaviorStandard;
use App\BehaviorStandardItem;
use App\Helpers\DatabaseHelpers;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(BehaviorStandardItem::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'behavior_standard_id' => function () {
            return factory(BehaviorStandard::class)->create()->id;
        },
        'name' => $faker->words(3, true),
        'description' => $faker->sentences(2, true),
        'value' => $faker->numberBetween(1, 4),
    ]);
});
