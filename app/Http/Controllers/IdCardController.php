<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
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
     * @return RedirectResponse
     */
    public function cancel(IdCard $id_card)
    {
        $id_card->is_active = false;
        $id_card = Helpers::dbAddAudit($id_card);
        $id_card->save()
            ?
            Helpers::flashAlert(
                'success',
                'The ID Card has been cancelled.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'There was an issue cancelling the ID Card. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Delete the given id_card
     *
     * @param IdCard $id_card
     * @return RedirectResponse
     */
    public function delete(IdCard $id_card)
    {
        $id_card->is_active = false;
        $id_card = Helpers::dbAddAudit($id_card);
        $id_card->delete()
            ?
            Helpers::flashAlert(
                'success',
                'The ID Card has been deleted.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'There was an issue deleting the ID Card. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }
}
