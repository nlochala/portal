<?php

namespace App\Http\Controllers;

use App\Year;
use Exception;
use App\Holiday;
use App\Quarter;
use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreHolidayRequest;
use Illuminate\Database\Eloquent\Collection;

class HolidayAjaxController extends Controller
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
        $this->request = new StoreHolidayRequest();
        $this->eagerLoad = ['quarter'];
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
     * @return Holiday[]|Collection
     */
    public function ajaxShow()
    {
        return Holiday::with($this->eagerLoad)->get();
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

            // EDIT THE GIVEN Holiday
            if ($action == 'edit') {
                if ($holiday = $this->update(Holiday::find($id), $form_data)) {
                    $return_array['data'][] = $holiday->load($this->eagerLoad);
                }
            }
            // CREATE THE Holiday
            if ($action == 'create') {
                if ($holiday = $this->store($data[$id])) {
                    $return_array['data'][] = $holiday->load($this->eagerLoad);
                }
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Holiday::find($id));
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
     * Store the new holiday.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);
        if ($values['is_staff_workday'] === 'false') {
            $quarter = Quarter::getQuarter($values['start_date'], true, Year::find($values['year']));
            $values['quarter_id'] = $quarter ? $quarter->id : null;
        }

        $start = Carbon::parse($values['start_date']);
        $end = Carbon::parse($values['end_date']);

        if ($start > $end) {
            return $this->attemptAction(false, 'holiday', 'create', 'The Start Date must be a date before the End Date.');
        }

        if ($holiday = Holiday::create($values)) {
            //Do something to change the days table.
            //TODO:  1. Change quarter create/update to create/update days.
            //TODO:  2. Change make sure a quarter doesn't overlap the start/end of another quarter.
            //TODO:  3. When a holiday is created, loop through those given days and update the day table for no_school.
        }

        return $this->attemptAction($holiday, 'holiday', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Holiday $holiday
     * @param $values
     * @return Holiday|mixed|void
     */
    public function update(Holiday $holiday, $values)
    {
        $holiday = Helpers::dbAddAudit($holiday);
        $this->attemptAction($holiday->update($values), 'holiday', 'update');

        return $holiday;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Holiday $holiday
     * @return void
     */
    public function destroy(Holiday $holiday)
    {
        $holiday = Helpers::dbAddAudit($holiday);
        $this->attemptAction($holiday->delete(), 'holiday', 'delete');
    }
}
