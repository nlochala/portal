<?php

namespace App\Http\Controllers;

use App\Family;
use App\Guardian;
use App\Helpers\Helpers;
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
        $guardian = Helpers::dbAddAudit($guardian);
        $guardian->family_id = $family->id;
        Helpers::flash($guardian->save(), 'guardian', 'added');

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
        $values = Helpers::dbAddAudit($values);
        $family = Family::create($values);

        $guardian->family_id = $family->id;
        Helpers::flash($guardian->save(), 'guardian', 'added');

        return redirect()->to('family/'.$family->uuid);
    }
}
