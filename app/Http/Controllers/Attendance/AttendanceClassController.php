<?php

namespace App\Http\Controllers;

use App\AttendanceType;
use App\Quarter;
use App\Student;
use Carbon\Carbon;
use App\CourseClass;
use App\AttendanceDay;
use App\AttendanceClass;
use App\Helpers\Helpers;
use Illuminate\View\View;
use App\Events\AttendanceTaken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

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
        $date_string = request()->get('date');
        $date = $date_string ? Carbon::parse($date_string) : now();
        $date_iso = $date->isoFormat('dddd, MMMM Do, YYYY');
        $homeroom_array = [];

        //Homeroom list
        $homeroom_list = CourseClass::hasAttendance()->with('course')->get();
        foreach ($homeroom_list as $homeroom) {
            $homeroom_array[$homeroom->full_name]['present'] = $homeroom->attendance()->date($date->format('Y-m-d'))->present()->count();
            $homeroom_array[$homeroom->full_name]['absent'] = $homeroom->attendance()->date($date->format('Y-m-d'))->absent()->count();
            $homeroom_array[$homeroom->full_name]['uuid'] = $homeroom->uuid;
        }

        $absent_students = AttendanceDay::date($date->format('Y-m-d'))->absent()->with('student.person', 'type', 'student.gradeLevel')->get();
        $absent_stats = implode(',',
            AttendanceDay::getStudentCount('absent', Helpers::getPreviousWorkingDays($date->format('Y-m-d'), 15)));

        $present_count = AttendanceDay::date($date->format('Y-m-d'))->present()->count();
        $present_stats = implode(',',
            AttendanceDay::getStudentCount('present', Helpers::getPreviousWorkingDays($date->format('Y-m-d'), 15)));

        $current_student_count = Student::current()->count();

        return view('attendance.daily_report', compact(
            'homeroom_array',
           'absent_students',
            'date',
            'date_iso',
            'absent_stats',
            'present_count',
            'present_stats',
            'current_student_count'
        ));
    }

    /**
     * @return Factory|View
     */
    public function attendanceUpdate()
    {
        $date_string = request()->get('date');
        $date = $date_string ? Carbon::parse($date_string) : now();
        $date_iso = $date->isoFormat('dddd, MMMM Do, YYYY');

        $attendance_types = AttendanceType::all();

        return view('attendance.update', compact('date_iso', 'date', 'attendance_types'));
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
            if ($attendance = AttendanceClass::where('student_id', '=', $id)
                ->where('date', '=', $date)
                ->where('class_id', '=', $class->id)
                ->first()) {
                if ($attendance->update($update_array)) {
                    event(new AttendanceTaken($attendance));
                }
            } else {
                if ($attendance = AttendanceClass::create($update_array)) {
                    event(new AttendanceTaken($attendance));
                }
            }
        }

        Helpers::flash(true, 'class attendance', 'updated');

        return redirect()->to('class/'.$class->uuid);
    }
}
