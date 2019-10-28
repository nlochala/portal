<?php

namespace App\Console\Commands;

use App\Year;
use Illuminate\Console\Command;
use App\Events\SchoolDaysChanged;

class UpdateSchoolCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:update-school-calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate the school calendar given changes in quarters and holidays.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        event(new SchoolDaysChanged(Year::currentYear()));
    }
}
