<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Room;
use Exception;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Database\Eloquent\Collection;

class RoomAjaxController extends Controller
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
        $this->request = new StoreRoomRequest();
        $this->eagerLoad = ['building', 'type'];
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
     * @return Room[]|Collection
     */
    public function ajaxShow()
    {
        return Room::with($this->eagerLoad)->get();
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
                $this->destroy(Room::find($id));
            }

            return $return_array;
        }

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN Room
            if ($action == 'edit') {
                if ($room = $this->update(Room::find($id), $form_data)) {
                    $return_array['data'][] = $room->load($this->eagerLoad);
                }
            }
            // CREATE THE Room
            if ($action == 'create') {
                $room = $this->store($data[$id]);
                $return_array['data'][] = $room->load($this->eagerLoad);
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
     * Store the new room.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(Room::create($values), 'room', 'create');
    }

    /**
     * Update the given model.
     *
     * @param Room $room
     * @param $values
     * @return Room|mixed|void
     */
    public function update(Room $room, $values)
    {
        $room = DatabaseHelpers::dbAddAudit($room);
        $this->attemptAction($room->update($values), 'room', 'update');

        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @return void
     */
    public function destroy(Room $room)
    {
        if ($room->is_protected) {
            $this->attemptAction(false, 'room', 'delete', 'Can not delete. This room is protected.');

            return;
        }

        $room = DatabaseHelpers::dbAddAudit($room);
        $this->attemptAction($room->delete(), 'room', 'delete');
    }
}
