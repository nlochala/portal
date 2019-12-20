<?php

namespace App\Http\Controllers;

use App\BehaviorStandard;
use Exception;
use App\BehaviorStandardItem;
use App\Helpers\FieldValidation;
use App\Helpers\DatabaseHelpers;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreBehaviorStandardItemRequest;


class BehaviorStandardItemAjaxController extends Controller
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
        $this->request = new StoreBehaviorStandardItemRequest();
        $this->eagerLoad = ['standard'];
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
     * @param BehaviorStandard $standard
     * @return BehaviorStandardItem[]|Collection
     */
    public function ajaxShow(BehaviorStandard $standard)
    {
        return $standard->items()->with($this->eagerLoad)->get();
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
                $this->destroy(BehaviorStandardItem::find($id));
            }

            return $return_array;
        }

        foreach ($data as $id => $form_data) {
            $this->validation->checkForm($this->request, $form_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN BehaviorStandardItem
            if ($action == 'edit') {
                if ($item = $this->update(BehaviorStandardItem::find($id), $form_data)) {
                    $return_array['data'][] = $item->load($this->eagerLoad);
                }
            }
            // CREATE THE BehaviorStandardItem
            if ($action == 'create') {
                if ($item = $this->store($data[$id])) {
                    $return_array['data'][] = $item->load($this->eagerLoad);
                }
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
     * Store the new item.
     *
     * @param $values
     * @return bool
     */
    public function store($values)
    {
        $values = DatabaseHelpers::dbAddAudit($values);

        return $this->attemptAction(BehaviorStandardItem::create($values), 'item', 'create');
    }

    /**
     * Update the given model.
     *
     * @param BehaviorStandardItem $item
     * @param $values
     * @return BehaviorStandardItem|mixed|void
     */
    public function update(BehaviorStandardItem $item, $values)
    {
        $item = DatabaseHelpers::dbAddAudit($item);
        $this->attemptAction($item->update($values), 'item', 'update');

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BehaviorStandardItem $item
     * @return void
     */
    public function destroy(BehaviorStandardItem $item)
    {
        if ($item->is_protected) {
            $this->attemptAction(false, 'item', 'delete',
                'Can not delete. This item is protected.');
            return;
        }

        $item = DatabaseHelpers::dbAddAudit($item);
        $this->attemptAction($item->delete(), 'item', 'delete');
    }
}
