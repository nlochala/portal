<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Visa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @return RedirectResponse
     */
    public function cancel(Visa $visa)
    {
        $visa->is_active = false;
        $visa = Helpers::dbAddAudit($visa);
        $visa->save()
            ?
            Helpers::flashAlert(
                'success',
                'The visa has been cancelled.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'There was an issue cancelling the visa. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Delete the given visa
     *
     * @param Visa $visa
     * @return RedirectResponse
     */
    public function delete(Visa $visa)
    {
        $visa->is_active = false;
        $visa = Helpers::dbAddAudit($visa);
        $visa->delete()
            ?
            Helpers::flashAlert(
                'success',
                'The visa has been deleted.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'There was an issue deleting the visa. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }
}
