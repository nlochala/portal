<?php

use App\Helpers\DatabaseHelpers;
use Faker\Generator as Faker;

$factory->define(App\Year::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'year_start' => '2020',
        'year_end' => '2021',
        'start_date' => '2020-08-22',
        'end_date' => '2021-06-01'
    ]);
});
