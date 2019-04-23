<?php

namespace App\Http\Controllers;

use App\Helpers\FieldValidation;
use App\Helpers\Helpers;
use App\Position;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class PositionController extends Controller
{
    protected $validation;

    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ajaxShow');
        $this->validation = new FieldValidation();
    }

    // Array of fields that needs to be validated as required data.
    protected $required = [];

    // Array of all expected fields to use for saving/updating the model.
    protected $fields = [];

    /*
        |--------------------------------------------------------------------------
        | AJAX METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * This returns a json formatted array for the table.
     *
     * @return Position[]|Collection
     */
    public function ajaxShow()
    {
        return Position::with(['type', 'school', 'supervisor'])->get();
    }

    /**
     * Take the given arrays and specified actions and pass them to the CRUD methods
     * below.
     *
     * @return array|bool
     *
     * @throws Exception
     */
    public function ajaxStore()
    {
        $values = request()->all();

        $action = $values['action'];
        $data = $values['data'];
        $return_array = [];

        foreach ($data as $id => $position_data) {
            // VALIDATE THE FORM DATA
            foreach ($this->required as $field) {
                $this->validation->required($field, $position_data);
                $this->validation->required($field, $position_data);
            }

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN Position
            if ('edit' == $action) {
                /* @noinspection PhpUndefinedMethodInspection */
                if ($position = $this->update(Position::find($id), $position_data)) {
                    $return_array['data'][] = $position;
                }
            }
            // CREATE THE Position
            if ('create' == $action) {
                $position = $this->store($data[$id]);
                $return_array['data'][] = $position;
            }
        }

        if ('remove' == $action) {
            foreach ($data as $id => $position_data) {
                /* @noinspection PhpUndefinedMethodInspection */
                $this->destroy(Position::find($id));
            }
        }

        return $return_array;
    }

    /*
        |--------------------------------------------------------------------------
        | CRUD METHODS
        |--------------------------------------------------------------------------
    */

    /**
     * Store the new position.
     *
     * @param $values
     *
     * @return RedirectResponse|bool
     */
    public function store($values)
    {
        $values = Helpers::dbAddAudit($values);
        /* @noinspection PhpUndefinedMethodInspection */
        $position = Position::create($values);

        /* @noinspection PhpUndefinedMethodInspection */
        if ($position->save()) {
            return $position;
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Position $position
     * @param $values
     *
     * @return Position|bool
     *
     * @internal param int $id
     */
    public function update(Position $position, $values)
    {
        $position = Helpers::dbAddAudit($position);
        foreach ($this->fields as $field) {
            /* @noinspection PhpVariableVariableInspection */
            $position->$field = $values[$field];
        }

        if ($position->save()) {
            return $position;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Position $position
     *
     * @return string
     *
     * @throws Exception
     */
    public function destroy(Position $position)
    {
        $position = Helpers::dbAddAudit($position);

        if ($position->save()) {
            return $position->delete();
        }

        return false;
    }
}
