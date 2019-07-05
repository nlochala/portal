<?php

namespace App\Http\Controllers;

use App\Person;
use App\Employee;
use App\Guardian;
use App\GuardianType;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class GuardianController extends Controller
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
     * Display an index of all guardians.
     *
     * @return Factory|View
     */
    public function index()
    {
        $title_dropdown = Person::$titleDropdown;
        $gender_dropdown = Person::$genderRadio;
        $type_dropdown = GuardianType::getDropdown();
        $employee_dropdown = Employee::getDropdown();

        return view('guardian.index', compact(
            'gender_dropdown',
            'title_dropdown',
            'type_dropdown',
            'employee_dropdown'
        ));
    }

    /**
     * Store a new guardian.
     *
     * @return RedirectResponse
     */
    public function storeNewGuardian()
    {
        $values = Helpers::dbAddAudit(request()->all());

        if (isset($values['employee_id']) && ! empty($values['employee_id'])) {
            $person = Employee::findOrFail($values['employee_id'])->person;
            $values['guardian_type_id'] = $values['employee_guardian_type_id'];
        } else {
            $values['gender'] = Person::getGender($values['gender']);
            $values['title'] = Person::getTitle($values['title']);
            $person = Person::create($values);
        }

        $guardian_values['person_id'] = $person->id;
        $guardian_values['guardian_type_id'] = $values['guardian_type_id'];

        $values = Helpers::dbAddAudit($guardian_values);
        $guardian = Guardian::create($values);

        Helpers::flash($guardian, 'guardian');

        if ($guardian) {
            return redirect()->to('guardian/'.$guardian->uuid.'/profile');
        }

        return redirect()->back()->withInput();
    }
}
