<?php

namespace App\Http\Controllers;

use Exception;
use App\Course;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Database\Eloquent\Collection;

class CourseAjaxController extends Controller
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
        $this->request = new StoreCourseRequest();
        $this->eagerLoad = [
            'prerequisites',
            'corequisites',
            'equivalents',
            'gradeLevels',
            'type',
            'transcriptType',
            'gradeScale',
            'department',
            'year',
        ];
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
     * @return Course[]|Collection
     */
    public function ajaxShow()
    {
        return Course::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Course
            if ($action == 'edit') {
                if ($course = $this->update(Course::find($id), $form_data)) {
                    $return_array['data'][] = $course->load($this->eagerLoad);
                }
            }
            // CREATE THE Course
            if ($action == 'create') {
                $course = $this->store($data[$id]);
                $return_array['data'][] = $course->load($this->eagerLoad);
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Course::find($id));
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
     * Store the new course.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);

        return $this->attemptAction(Course::create($values), 'course', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Course $course
     * @param $values
     * @return Course|mixed|void
     */
    public function update(Course $course, $values)
    {
        $course = Helpers::dbAddAudit($course);
        $this->attemptAction($course->update($values), 'course', 'update');

        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return void
     */
    public function destroy(Course $course)
    {
        $course = Helpers::dbAddAudit($course);
        $this->attemptAction($course->delete(), 'course', 'delete');
    }
}
