<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Passport;
use Illuminate\Http\RedirectResponse;

class PassportController extends Controller
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
     * Cancel the given passport.
     *
     * @param Passport $passport
     * @return RedirectResponse
     */
    public function cancel(Passport $passport)
    {
        $passport->is_active = false;
        $passport = Helpers::dbAddAudit($passport);
        $passport->save()
            ?
            Helpers::flashAlert(
                'success',
                'The passport has been cancelled.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'There was an issue cancelling the passport. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Delete the given passport
     *
     * @param Passport $passport
     * @return RedirectResponse
     */
    public function delete(Passport $passport)
    {
        $passport->is_active = false;
        $passport = Helpers::dbAddAudit($passport);
        $passport->delete()
            ?
            Helpers::flashAlert(
                'success',
                'The passport has been deleted.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'There was an issue deleting the passport. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

}
