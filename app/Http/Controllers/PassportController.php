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
     *
     * @return RedirectResponse
     */
    public function cancel(Passport $passport)
    {
        $passport->is_active = false;
        $passport = Helpers::dbAddAudit($passport);
        Helpers::flash($passport->save(), 'passport', 'cancelled');
        return redirect()->back();
    }

    /**
     * Delete the given passport.
     *
     * @param Passport $passport
     *
     * @return RedirectResponse
     */
    public function delete(Passport $passport)
    {
        $passport->is_active = false;
        $passport = Helpers::dbAddAudit($passport);
        $passport->save();
        Helpers::flash($passport->delete(), 'passport', 'deleted');
        return redirect()->back();
    }
}
