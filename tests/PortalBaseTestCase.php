<?php

namespace Tests;

use App\Person;
use Faker\Factory;

abstract class PortalBaseTestCase extends DuskTestCase
{
    protected $person;
    protected $user;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
        $this->artisan('db:seed --class=AuthTestingSeeder');

        /* @noinspection PhpUndefinedMethodInspection */
        $this->person = Person::first();
        $this->user = $this->person->user;
        $this->faker = Factory::create();
    }
}
