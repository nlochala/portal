<?php

use App\User;
use App\Country;
use App\Language;
use App\Ethnicity;
use Webpatser\Uuid\Uuid;
use Faker\Generator as Faker;

$factory->define(App\Person::class, function (Faker $faker) {
    $chinese = [
        '阿',
        '把',
        '锕',
        '的',
        '费',
        '工',
        '好',
        '家',
        '看',
        '太',
        '饿',
        '让',
        '拍',
        '在',
        '行',
        '赐',
        '把',
        '你',
        '吗',
        '哦',
        '日',
        '如',
        '它',
        '要',
        '给',
        '个',
        '过',
        '更',
        '高',
        '高',
        '号',
        '和',
        '还',
        '会',
        '很',
        '后',
    ];

    $gender = $faker->randomElement(['male', 'female']);

    return [
        'uuid' => Uuid::generate(4),
        'title' => $faker->title($gender),
        'given_name'=> $faker->firstName($gender).' '.$faker->firstName($gender),
        'family_name' => $faker->lastName,
        'preferred_name' => $faker->firstName($gender),
        'name_in_chinese' => implode('', $faker->randomElements($chinese, 3)),
        'gender' => ucfirst($gender),
        'dob' => $faker->dateTimeBetween(),
        'email_primary' => $faker->email,
        'email_secondary' => $faker->companyEmail,
        'email_school' => strtolower($faker->lastName).'@tlcdg.com',
        'country_of_birth_id' => $faker->randomElement(Country::all()->pluck('id')->toArray()),
        'language_primary_id' => $faker->randomElement(Language::all()->pluck('id')->toArray()),
        'language_secondary_id' => $faker->randomElement(Language::all()->pluck('id')->toArray()),
        'ethnicity_id' => $faker->randomElement(Ethnicity::all()->pluck('id')->toArray()),
        'user_created_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_created_ip' => $faker->ipv4,
        'user_updated_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'user_updated_ip' => $faker->ipv4,
        'created_at' => $faker->dateTimeBetween('-5 years'),
        'updated_at' => $faker->dateTimeBetween('-5 years'),
    ];
});
