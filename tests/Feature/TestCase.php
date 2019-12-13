<?php

namespace Tests\Feature;

use Tests\Traits\SignIn;
use Tests\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions, SignIn, WithFaker;

}
