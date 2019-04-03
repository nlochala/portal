<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddressType;
use App\Country;
use App\Employee;
use App\Helpers\FieldValidation;
use App\Helpers\Helpers;
use App\Person;
use App\PhoneType;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Person $person)
    {
        $this->authorize('profile.show.address');
        $address_list = Address::all();
        return view('address.index', compact('address_list'));
    }

    /*
        |--------------------------------------------------------------------------
        | AJAX METHODS
        |--------------------------------------------------------------------------
    */
    /**
     * This returns a json formatted array for the table
     *
     * @return Address[]|Collection
     * @throws AuthorizationException
     */
    public function ajaxShow(Person $person)
    {
        $this->authorize('profile.show.address');
        return Address::all();
    }

    /**
     * Take the given arrays and specified actions and pass them to the CRUD methods
     * below.
     * @return array|bool
     * @throws Exception
     */
    public function ajaxStore()
    {
        $this->authorize('profile.edit.address');
        $values = request()->all();

        $action = $values['action'];
        $data = $values['data'];
        $return_array = [];

        foreach ($data as $id => $address_data) {
            $this->validation->required('name', $address_data);
            $this->validation->required('username', $address_data);

            if ($errors = $this->validation->hasErrors()) {
                return $errors;
            }

            // EDIT THE GIVEN Address
            if ($action == 'edit') {
                if ($address = $this->update(Address::find($id), $address_data)) {
                    $return_array['data'][] = $address;
                }
            }
            // CREATE THE Address
            if ($action == 'create') {
                $address = $this->store($data[$id]);
                $return_array['data'][] = $address;
            }
        }

        if ($action == 'remove') {
            foreach ($data as $id => $address_data) {
                $this->destroy(Address::find($id));
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
     * Store the new address
     *
     * @param $values
     * @return RedirectResponse|bool
     */
    public function store($values)
    {
        $address = Address::create($values);
        $address->user_created_id = auth()->id();
        $address->user_created_ip = Helpers::getUserIp();

        if ($address->save()) {
            return $address;
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Address $address
     *
     * @param $values
     * @return Address|bool
     * @internal param int $id
     */
    public function update(Address $address, $values)
    {
        $address->name = $values['name'];
        $address->username = $values['username'];
        $address->user_updated_id = auth()->id();
        $address->user_updated_ip = Helpers::getUserIp();

        if ($address->save()) {
            return $address;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     * @return string
     * @throws Exception
     */
    public function destroy(Address $address)
    {
        $address->user_updated_id = auth()->id();
        $address->user_updated_ip = Helpers::getUserIp();

        if ($address->save()) {
            return $address->delete();
        }

        return false;
    }

    /**
     * Delete the given item.
     *
     * @param Address $address
     * @return RedirectResponse
     * @throws Exception
     */
    public function profileDestroy(Address $address)
    {
        if($this->destroy($address)){
            Helpers::flashAlert(
                'success',
                'The address has been successfully deleted.',
                'fa fa-check mr-1');
            return redirect()->back();
        }
        Helpers::flashAlert(
            'danger',
            'There was a problem deleting the address. Please try again.',
            'fa fa-info-circle mr-1');
        return redirect()->back();
    }

}
