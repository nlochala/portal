<?php

namespace App\Http\Controllers;

use App\Address;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
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
     * Delete the given address.
     *
     * @param $address
     *
     * @return RedirectResponse
     */
    public function delete(Address $address)
    {
        $address = DatabaseHelpers::dbAddAudit($address);
        $address->save();
        ViewHelpers::flash($address->delete(), 'address', 'deleted');

        return redirect()->back();
    }
}
