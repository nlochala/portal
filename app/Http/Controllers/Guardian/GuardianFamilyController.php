<?php

namespace App\Http\Controllers;

use App\Family;
use App\Guardian;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class GuardianFamilyController extends GuardianController
{
    /**
     * Display the new family form.
     *
     * @param Guardian $guardian
     * @return Factory|View
     */
    public function newFamily(Guardian $guardian)
    {
        return view('guardian.new_family', compact('guardian'));
    }

    /**
     * Attach guardian to existing family.
     *
     * @param Guardian $guardian
     * @param Family $family
     * @return RedirectResponse
     */
    public function addToExistingFamily(Guardian $guardian, Family $family)
    {
        $guardian = DatabaseHelpers::dbAddAudit($guardian);
        $guardian->family_id = $family->id;
       ViewHelpers::flash($guardian->save(), 'guardian', 'added');

        return redirect()->to('family/'.$family->uuid);
    }

    /**
     * Create a new family and attach it to the guardian.
     *
     * @param Guardian $guardian
     * @return RedirectResponse
     */
    public function createNewFamily(Guardian $guardian)
    {
        $values = [];
        $values = DatabaseHelpers::dbAddAudit($values);
        $family = Family::create($values);

        $guardian->family_id = $family->id;
       ViewHelpers::flash($guardian->save(), 'guardian', 'added');

        return redirect()->to('family/'.$family->uuid);
    }

    /**
     * Show either the family page or the new family page.
     *
     * @param Guardian $guardian
     * @return RedirectResponse
     */
    public function viewFamily(Guardian $guardian)
    {
        return $guardian->family_id ?
            redirect()->to('family/'.$guardian->family->uuid)
            :
            redirect()->to('guardian/'.$guardian->uuid.'/new_family');
    }
}
