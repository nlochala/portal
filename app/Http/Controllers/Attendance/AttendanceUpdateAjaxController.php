<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\Quarter;
use App\Student;
use Carbon\Carbon;
use App\AttendanceDay;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreDefaultRequest;
use Illuminate\Database\Eloquent\Collection;

class AttendanceUpdateAjaxController extends Controller
{
    protected $validation;
    protected $errors;
    protected $request;
    protected $eagerLoad;

    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ajaxShow');
        $this->validation = new FieldValidation();
        $this->errors = false;
        $this->request = new StoreDefaultRequest();
        $this->eagerLoad = [];
    }

    /**
     * Add an error if needed.
     *
     * @param bool $result
     * @param string $item
     * @param string $action
     * @param null $custom_message
     * @return bool|void
     */
    public function attemptAction($result, $item = 'year', $action = 'update', $custom_message = null)
    {
        if ($result) {
            return $result;
        }

        if ($custom_message) {
            $this->errors[] = $custom_message;

            return;
        }

        $this->errors[] = "Could not $action this $item. Please try again.";
    }

    /*
        |--------------------------------------------------------------------------
        | AJAX METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * This returns a json formatted array for the table.
     *
     * @param $date
     * @return AttendanceDay[]|Collection
     */
    public function ajaxShow($date)
    {
        $return_array = [];

        $quarter = Quarter::getQuarter($date);
        $date = Carbon::parse($date);
        $students = Student::current()->activeOn($date)->with('person', 'gradeLevel')->get();

        foreach ($students as $student) {
            $attendance = AttendanceDay::date($date->format('Y-m-d'))->isStudent($student->id)->with('type')->first();
            $return_array[] = [
                'id' => $student->id,
                'name' => $student->formalName,
                'gradeLevel' => $student->gradeLevel,
                'attendanceDay' => $attendance,
                'date' => $date->format('Y-m-d'),
            ];
        }

        return $return_array;
    }

    /**
     * Take the given arrays and specified actions and pass them to the CRUD methods
     * below.
     * @param $date
     * @return array|bool
     */
    public function ajaxStore($date)
    {
        $values = request()->all();

        $action = $values['action'];
        $data = $values['data'];
        $return_array = [];

        foreach ($data as $id => $form_data) {

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN AttendanceDay
            if ($action == 'edit') {
                if ($day = $this->update(Student::find($id), $date, $form_data)) {
                    $return_array['data'][] = $day;
                }
            }
            // CREATE THE AttendanceDay
            if ($action == 'create') {
                if ($day = $this->store(Student::find($id), $form_data)) {
                    $return_array['data'][] = $day;
                }
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(AttendanceDay::find($id));
            }
        }

        if ($this->errors) {
            $return_array['error'] = $this->errors;
        }

        return $return_array;
    }

    /*
        |--------------------------------------------------------------------------
        | CRUD METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * Store the new day.
     *
     * @param Student $student
     * @param $values
     * @return bool
     */
    public function store(Student $student, $values)
    {
        // Shouldn't be anything here....
    }

    /**
     * Update the given model.
     *
     * @param Student $student
     * @param $values
     * @return AttendanceDay|mixed|void
     */
    public function update(Student $student, $date, $values)
    {
        $values['student_id'] = $student->id;
        $values['date'] = $date;
        $values['quarter_id'] = Quarter::getQuarter($date)->id;
        $values = DatabaseHelpers::dbAddAudit($values);

        if ($attendance = AttendanceDay::date($date)->isStudent($student->id)->first()) {
            $attendance = DatabaseHelpers::dbAddAudit($attendance);
            $attendance->attendance_type_id = $values['attendance_type_id'];
            $attendance->save();

        } else {
            $attendance = AttendanceDay::create($values);
        }


        $return_array = [
            'id' => $student->id,
            'name' => $student->formalName,
            'gradeLevel' => $student->gradeLevel,
            'attendanceDay' => $attendance->load('type'),
            'date' => $date,
        ];

        return $return_array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AttendanceDay $day
     * @return void
     */
    public function destroy(AttendanceDay $day)
    {
        $day = DatabaseHelpers::dbAddAudit($day);
        $this->attemptAction($day->delete(), 'day', 'delete');
    }
}
