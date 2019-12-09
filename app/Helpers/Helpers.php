<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helpers
{
    /**
     * @var Carbon
     */
    protected $today;

    /**
     * Helpers constructor.
     */
    public function __construct()
    {
        $this->today = Carbon::today();
    }
}
