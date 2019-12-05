<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Visa;
use Illuminate\Http\RedirectResponse;

class VisaController extends Controller
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
     * Cancel the given visa.
     *
     * @param Visa $visa
     *
     * @return RedirectResponse
     */
    public function cancel(Visa $visa)
    {
        $visa->is_active = false;
        $visa = Helpers::dbAddAudit($visa);
        Helpers::flash($visa->save(), 'visa', 'cancelled');

        return redirect()->back();
    }

    /**
     * Delete the given visa.
     *
     * @param Visa $visa
     *
     * @return RedirectResponse
     */
    public function delete(Visa $visa)
    {
        $visa->is_active = false;
        $visa = Helpers::dbAddAudit($visa);
        $visa->save();
        Helpers::flash($visa->delete(), 'visa', 'deleted');

        return redirect()->back();
    }
}
