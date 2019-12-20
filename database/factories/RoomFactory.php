<?php

/* @var Factory $factory */

use App\Helpers\DatabaseHelpers;
use App\Room;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Room::class, function (Faker $faker) {
    return DatabaseHelpers::dbAddAudit([
        'number' => $faker->randomNumber(3),
        'description' => $faker->words(3,true),
        'room_type_id' => function () {
            return factory('App\RoomType')->create()->id;
        },
        'building_id' => function () {
            return factory('App\Building')->create()->id;
        },
        'phone_extension' => $faker->randomNumber(3),
    ]);
});
