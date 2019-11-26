<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveAttendanceDuplicates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:remove-attendance-duplicates
    {--start_date= : In the form of YYYY-mm-dd}
    {--end_date= : In the form of YYYY-mm-dd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will remove the duplicates from the attendance records.';

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
        if (empty($this->option('start_date')) && empty($this->option('end_date'))) {
            $this->line('');
            $this->line('There was not a start_date or end_date given.');
            if ($this->confirm('Do you wish to run the command using today\'s date?')) {
                $start_date = now()->format('Y-m-d');
                $end_date = $start_date;
            } else {
                return;
            }
        } else {
            $start_date = Carbon::parse($this->option('start_date'))->format('Y-m-d');
            $end_date = Carbon::parse($this->option('end_date'))->format('Y-m-d');
        }

        $result_array = Helpers::checkDuplicateAttendance($start_date, $end_date);
        $this->line(\GuzzleHttp\json_encode($result_array));
    }
}
