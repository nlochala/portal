<?php

namespace App\Http\Controllers;

use Exception;
use App\Quarter;
use App\Assignment;
use App\CourseClass;
use App\AssignmentGrade;
use App\Helpers\Helpers;
use App\Events\AssignmentGraded;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreAssignmentGradeRequest;

class AssignmentGradeAjaxController extends Controller
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
        $this->request = new StoreAssignmentGradeRequest();
        $this->eagerLoad = ['student.person', 'assignment'];
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
     * @param CourseClass $class
     * @param Quarter $quarter
     * @param Assignment $assignment
     * @return AssignmentGrade[]|Collection
     */
    public function ajaxShow(CourseClass $class, Quarter $quarter, Assignment $assignment)
    {
        $current_students = $class->currentStudents($quarter, 'current');
        $enrollment_array = $current_students->pluck('id')->toArray();
        $create_array = Helpers::dbAddAudit([]);

        $grades = AssignmentGrade::isAssignment($assignment->id)->with($this->eagerLoad)->get();
        $grades_array = $grades->pluck('student.id')->toArray();
        foreach ($enrollment_array as $student_id) {
            if (! in_array($student_id, $grades_array)) {
                $create_array['assignment_id'] = $assignment->id;
                $create_array['student_id'] = $student_id;
                AssignmentGrade::create($create_array);
            }
        }

        return AssignmentGrade::isAssignment($assignment->id)->with($this->eagerLoad)->get();
    }

    /**
     * Take the given arrays and specified actions and pass them to the CRUD methods
     * below.
     * @return array|bool
     * @throws Exception
     */
    public function ajaxStore()
    {
        $values = request()->all();

        $action = $values['action'];
        $data = $values['data'];
        $return_array = [];

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN AssignmentGrade
            if ($action == 'edit') {
                if ($grade = $this->update(AssignmentGrade::find($id), $form_data)) {
                    $return_array['data'][] = $grade->load($this->eagerLoad);
                }
            }
            // CREATE THE AssignmentGrade
            if ($action == 'create') {
                $grade = $this->store($data[$id]);
                $return_array['data'][] = $grade->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(AssignmentGrade::find($id));
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
     * Store the new grade.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        if ($grade = $this->attemptAction(AssignmentGrade::create($values), 'grade', 'create')) {
            event(new AssignmentGraded(
                $grade->student,
                $grade->assignment->class,
                $grade->assignment->quarter
            ));

            return $grade;
        }
    }

    /**
     * Update the given model.
     *
     * @param AssignmentGrade $grade
     * @param $values
     * @return AssignmentGrade|mixed|void
     */
    public function update(AssignmentGrade $grade, $values)
    {
        $grade = Helpers::dbAddAudit($grade);
        if (isset($values['points_earned']) && $grade->date_completed === '--') {
            $values['date_completed'] = now()->format('Y-m-d');
        }

        if (isset($values['is_excused']) && $values['is_excused'] === '1') {
            $values['points_earned'] = null;
            $values['date_completed'] = null;
        }

        if ($this->attemptAction($grade->update($values), 'grade', 'update')) {
            event(new AssignmentGraded(
                $grade->student,
                $grade->assignment->class,
                $grade->assignment->quarter
            ));
        }

        return $grade;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AssignmentGrade $grade
     * @return void
     */
    public function destroy(AssignmentGrade $grade)
    {
        $grade = Helpers::dbAddAudit($grade);
        $this->attemptAction($grade->delete(), 'grade', 'delete');
    }
}
