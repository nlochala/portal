<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Year;
use Exception;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreYearRequest;
use Illuminate\Database\Eloquent\Collection;

class YearAjaxController extends Controller
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
        $this->request = new StoreYearRequest();
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
    public function attemptAction($result, $item = 'school year or position', $action = 'update or delete', $custom_message = null)
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
     * @return Year[]|Collection
     */
    public function ajaxShow()
    {
        return Year::with($this->eagerLoad)->get();
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

        if ($action == 'remove') {
            foreach ($data as $id => $form_data) {
                $this->destroy(Year::find($id));
            }

            return $return_array;
        }

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN Year
            if ($action == 'edit') {
                if ($year = $this->update(Year::find($id), $form_data)) {
                    $return_array['data'][] = $year->load($this->eagerLoad);
                }
            }
            // CREATE THE Year
            if ($action == 'create') {
                $year = $this->store($data[$id]);
                $return_array['data'][] = $year->load($this->eagerLoad);
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
     * Store the new year.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);
        return $this->attemptAction(Year::create($values), 'year', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Year $year
     * @param $values
     * @return Year|mixed|void
     */
    public function update(Year $year, $values)
    {
        $year = DatabaseHelpers::dbAddAudit($year);
        $this->attemptAction($year->update($values), 'year', 'update');

        return $year;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Year $year
     * @return void
     */
    public function destroy(Year $year)
    {
        if ($year->is_protected) {
            $this->attemptAction(false, 'year', 'delete',
                'Can not delete. This year is protected.');
            return;
        }

        $year = DatabaseHelpers::dbAddAudit($year);
        $this->attemptAction($year->delete(), 'year', 'delete');
    }
}
