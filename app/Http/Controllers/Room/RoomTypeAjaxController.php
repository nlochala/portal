<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use Exception;
use App\RoomType;
use App\Helpers\Helpers;
use App\Helpers\FieldValidation;
use App\Http\Requests\StoreRoomTypeRequest;
use Illuminate\Database\Eloquent\Collection;

class RoomTypeAjaxController extends Controller
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
        $this->request = new StoreRoomTypeRequest();
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
     * @return RoomType[]|Collection
     */
    public function ajaxShow()
    {
        return RoomType::with($this->eagerLoad)->get();
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
                $this->destroy(RoomType::find($id));
            }

            return $return_array;
        }

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN RoomType
            if ($action == 'edit') {
                if ($room_type = $this->update(RoomType::find($id), $form_data)) {
                    $return_array['data'][] = $room_type->load($this->eagerLoad);
                }
            }
            // CREATE THE RoomType
            if ($action == 'create') {
                $room_type = $this->store($data[$id]);
                $return_array['data'][] = $room_type->load($this->eagerLoad);
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
     * Store the new room_type.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(RoomType::create($values), 'room_type', 'create');
    }

    /**
     * Update the given model.
     *
     * @param RoomType $room_type
     * @param $values
     * @return RoomType|mixed|void
     */
    public function update(RoomType $room_type, $values)
    {
        $room_type = DatabaseHelpers::dbAddAudit($room_type);
        $this->attemptAction($room_type->update($values), 'room_type', 'update');

        return $room_type;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RoomType $room_type
     * @return void
     */
    public function destroy(RoomType $room_type)
    {
        if ($room_type->is_protected) {
            $this->attemptAction(false, 'room_type', 'delete', 'Can not delete. This room type is protected.');
            return;
        }

        $room_type = DatabaseHelpers::dbAddAudit($room_type);
        $this->attemptAction($room_type->delete(), 'room_type', 'delete');
    }
}
