<?php

namespace App\Listeners;

use App\AttendanceDay;
use App\AttendanceType;
use App\Helpers\Helpers;
use App\Events\AttendanceTaken;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateDailyAttendance implements ShouldQueue
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
     * @param AttendanceTaken $event
     * @return void
     */
    public function handle(AttendanceTaken $event)
    {
        // Check if the daily record exists for the student.
        $record = AttendanceDay::where('date', '=', $event->attendance->date)
            ->where('student_id', '=', $event->attendance->student_id)->first();

        $present_id = AttendanceType::where('name', '=', 'Present')->first()->id;

//         We don't want to record tardies on the daily report.
        $type_id = $event->attendance->type->is_present ? $present_id : $event->attendance->attendance_type_id;

//         If so, update the existing record.
        if ($record) {
            $record->attendance_type_id = $type_id;
            $record = Helpers::dbAddAudit($record);
            $record->user_updated_id = $event->attendance->user_updated_id;
            $record->save();

            return;
        }

//         If not, store new record.
        $record = new AttendanceDay;
        $record->date = $event->attendance->date;
        $record->quarter_id = $event->attendance->quarter_id;
        $record->student_id = $event->attendance->student_id;
        $record->attendance_type_id = $type_id;
        $record = Helpers::dbAddAudit($record);
        $record->user_created_id = $event->attendance->user_created_id;
        $record->save();
    }
}
