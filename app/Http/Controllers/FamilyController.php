<?php

namespace App\Http\Controllers;

use App\Family;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class FamilyController extends Controller
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
     * Return the family dashboard.
     *
     * @param Family $family
     * @return Factory|View
     */
    public function show(Family $family)
    {
        $family->load(
            'guardians.person.phones.country',
            'guardians.person.phones.phoneType',
            'students.person.addresses',
            'students.person.passports',
            'students.person.idCards',
            'students.person.image',
            'students.person.ethnicity',
            'students.person.nationality',
            'students.person.primaryLanguage',
            'students.person.secondaryLanguage',
            'students.gradeLevel',
            'students.status',
            'guardians.person.phones.country',
            'guardians.person.phones.phoneType',
            'guardians.person.addresses',
            'guardians.person.passports',
            'guardians.person.idCards',
            'guardians.person.image',
            'guardians.person.ethnicity',
            'guardians.person.nationality',
            'guardians.person.primaryLanguage',
            'guardians.person.secondaryLanguage',
            'guardians.type'
       );
        $students = $family->students;
        $guardians = $family->guardians;

        if ($students->count() !== $guardians->count()) {
            if ($students->count() > $guardians->count()) {
                $guardians = $guardians->pad($students->count(), 0);
            } else {
                $students = $students->pad($guardians->count(), 0);
            }
        }

        return view('family.dashboard', compact('family', 'students', 'guardians'));
    }
}
