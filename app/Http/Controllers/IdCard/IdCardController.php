<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
use App\IdCard;
use Illuminate\Http\RedirectResponse;

class IdCardController extends Controller
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
     * Cancel the given id_card.
     *
     * @param IdCard $id_card
     *
     * @return RedirectResponse
     */
    public function cancel(IdCard $id_card)
    {
        $id_card->is_active = false;
        $id_card = DatabaseHelpers::dbAddAudit($id_card);
       ViewHelpers::flash($id_card->save(), 'ID Card', 'cancelled');

        return redirect()->back();
    }

    /**
     * Delete the given id_card.
     *
     * @param IdCard $id_card
     *
     * @return RedirectResponse
     */
    public function delete(IdCard $id_card)
    {
        $id_card->is_active = false;
        $id_card = DatabaseHelpers::dbAddAudit($id_card);
        $id_card->save();
       ViewHelpers::flash($id_card->delete(), 'ID Card', 'deleted');

        return redirect()->back();
    }
}
