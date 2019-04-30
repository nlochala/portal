<?php

namespace Tests\Browser\Pages;

use Faker\Factory;
use Laravel\Dusk\Page as BasePage;

abstract class Page extends BasePage
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
