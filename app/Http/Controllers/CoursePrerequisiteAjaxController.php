<?php

namespace App\Http\Controllers;

use Exception;
use App\Course;
use App\Helpers\FieldValidation;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreCoursePrerequisiteRequest;

class CoursePrerequisiteAjaxController extends Controller
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
        $this->request = new StoreCoursePrerequisiteRequest();
        $this->eagerLoad = ['type', 'department'];
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
     * @param Course $course
     * @return Course[]|Collection
     */
    public function ajaxShow(Course $course)
    {
        return $course->prerequisites()->with($this->eagerLoad)->get();
    }

    /**
     * Take the given arrays and specified actions and pass them to the CRUD methods
     * below.
     * @param Course $course
     * @return array|bool
     * @throws Exception
     */
    public function ajaxStore(Course $course)
    {
        $values = request()->all();

        $action = $values['action'];
        $data = $values['data'];
        $return_array = [];

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy($course, $form_data);
            }

            if ($this->errors) {
                $return_array['error'] = $this->errors;
            }

            return $return_array;
        }

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // CREATE THE CoursePrerequisite
            if ($action == 'create') {
                $course = $this->store($course, $data[$id]);
                $return_array['data'][] = $course;
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
     * @param Course $course
     * @param $values
     * @return Course
     */
    public function store(Course $course, $values)
    {
        $set_prerequisites = $course->prerequisites()->syncWithoutDetaching($values);
        $this->attemptAction(is_array($set_prerequisites), 'course prerequisite', 'update');

        $course = Course::with($this->eagerLoad)->find($values)->first();

        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return void
     * @throws Exception
     */
    public function destroy(Course $course, $values)
    {
        $this->attemptAction($course->prerequisites()->detach($values), 'course prerequisite', 'delete');
    }
}
