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
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Delete the given address
     *
     * @param $address
     * @return RedirectResponse
     */
    public function delete(Address $address)
    {
        $address = Helpers::dbAddAudit($address);
        $address->save();
        Helpers::flash($address->delete(), 'address', 'deleted');

        return redirect()->back();
    }
}
