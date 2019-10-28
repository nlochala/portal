<?php

namespace App\Console\Commands;

use App\Day;
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
        $this->info('Sleeping for 15 seconds so event can run.');
        sleep(15);
        $this->info('Checking for instructional days and quarter school days consistencies.');
        $year = Year::currentYear();
        $quarters = $year->quarters;


        foreach ($quarters as $quarter) {
            $count = Day::isQuarter($quarter->id)->isSchoolDay()->count();
            if ($count !== $quarter->instructional_days) {
                $this->line('-----------------------------------');
                $this->line($quarter->name.'\'s day count doesn\'t match the days table.');
                $this->info($quarter->name.'_instructional_days = '.$quarter->instructional_days);
                $this->info('Days table shows '.$count.' instructional days.');
                $this->line('-----------------------------------');
            }
        }
    }
}
