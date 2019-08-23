<?php

namespace App\Http\Controllers;

use App\AttendanceDay;
use App\CourseClass;
use App\AttendanceClass;
use App\Helpers\Helpers;
use App\Events\AttendanceTaken;
use App\Quarter;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendanceClassController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the daily report.
     *
     * @return Factory|View
     */
    public function dailyReport()
    {
        //Homeroom list
        $homeroom_list = CourseClass::classesWithAttendance()->load('attendance');
        $absent_students = AttendanceDay::today()->absent()->with('student.person', 'type')->get();
        $absent_stats = implode(',',
            AttendanceDay::getStudentCount('absent', Helpers::getPreviousWorkingDays(now()->format('Y-m-d'), 15)));

        $present_count = AttendanceDay::today()->present()->count();
        $present_stats = implode(',',
            AttendanceDay::getStudentCount('present', Helpers::getPreviousWorkingDays(now()->format('Y-m-d'), 15)));

        $current_student_count = Student::current()->count();

        return view('attendance.daily_report', compact(
            'homeroom_list',
           'absent_students',
            'absent_stats',
            'present_count',
            'present_stats',
            'current_student_count'
        ));
    }

    /**
     * Store the class attendance.
     *
     * @param CourseClass $class
     * @return RedirectResponse
     */
    public function store(CourseClass $class)
    {
        $values = request()->all();
        $date = now()->format('Y-m-d');
        $quarter = Quarter::now();
        unset($values['_token']);
        foreach ($values as $id => $item) {
            $insert_array = [
                'date' => $date,
                'student_id' => $id,
                'class_id' => $class->id,
                'attendance_type_id' => $item,
                'quarter_id' => $quarter->id,
            ];

            $insert_array = Helpers::dbAddAudit($insert_array);
            if ($attendance = AttendanceClass::create($insert_array)) {
                event(new AttendanceTaken($attendance));
            }
        }
        Helpers::flash(true, 'class attendance');

        return redirect()->to('class/'.$class->uuid);
    }

    /**
     * Update the class attendance.
     *
     * @param CourseClass $class
     * @return RedirectResponse
     */
    public function update(CourseClass $class)
    {
        $values = request()->all();
        $date = now()->format('Y-m-d');
        $quarter = Quarter::now();
        unset($values['_token']);
        foreach ($values as $id => $item) {
            $update_array = [
                'date' => $date,
                'student_id' => $id,
                'class_id' => $class->id,
                'attendance_type_id' => $item,
                'quarter_id' => $quarter->id,
            ];

            $update_array = Helpers::dbAddAudit($update_array);
            $attendance = AttendanceClass::where('student_id', '=', $id)
                ->where('date', '=', $date)
                ->where('class_id', '=', $class->id)
                ->first();

            if ($attendance->update($update_array)) {
                event(new AttendanceTaken($attendance));
            }
        }
        Helpers::flash(true, 'class attendance', 'updated');

        return redirect()->to('class/'.$class->uuid);
    }
}
