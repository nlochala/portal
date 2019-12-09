<?php

namespace App\Listeners;

use App\Day;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Events\SchoolDaysChanged;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSchoolCalendar implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SchoolDaysChanged $event
     * @return void
     */
    public function handle(SchoolDaysChanged $event)
    {
        $year = $event->year;
        $quarters = $year->quarters;

        // Loop Through Quarters
        foreach ($quarters as $quarter) {
            $start_date = Carbon::parse($quarter->start_date);
            $date = Carbon::parse($quarter->start_date);
            $end_date = Carbon::parse($quarter->end_date);

            while ($date <= $end_date) {
                $formatted = $date->format('Y-m-d');
                $y = $date->format('Y');
                $m = $date->format('m');
                $d = $date->format('d');

                if ($date->isWeekday()) {
                    if ($day = Day::where('date', $formatted)->first()) {
                        // Day exists, make sure the quarter is correct.
                        $day->quarter_id === $quarter->id ?: $day->update(['quarter_id' => $quarter->id, 'name' => null]);
                    } else {
                        $insert_array = [
                            'quarter_id' => $quarter->id,
                            'date' => $formatted,
                            'is_school_day' => true,
                            'day' => $d,
                            'month' => $m,
                            'year' => $y,
                        ];
                        $insert_array = DatabaseHelpers::dbAddAudit($insert_array);

                        Day::create($insert_array);
                    }
                }

                $date->addDay();
            }
        }

        // Loop Through Holidays
        // Update days and change from is_school true to false. Make special note of is_staff_workday.
        foreach ($quarters as $quarter) {
            foreach ($quarter->holidays as $holiday) {
                $start_date = Carbon::parse($holiday->start_date);
                $date = Carbon::parse($holiday->start_date);
                $end_date = Carbon::parse($holiday->end_date);

                if ($holiday->is_staff_workday) {
                    continue;
                }

                while ($date <= $end_date) {
                    $formatted = $date->format('Y-m-d');
                    if ($date->isWeekday()) {
                        $day = Day::where('date', $formatted)->firstOrFail();
                        $day = DatabaseHelpers::dbAddAudit($day);
                        $day->description = $holiday->name;
                        $day->is_school_day = false;
                        $day->save();
                    }

                    $date->addDay();
                }
            }
        }

        foreach ($quarters as $quarter) {
            $count = Day::isQuarter($quarter->id)->isSchoolDay()->count();
            if ($count !== $quarter->instructional_days) {
                // Houston, we have a problem!
            }
        }
    }
}
