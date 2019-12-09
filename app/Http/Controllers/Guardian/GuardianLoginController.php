<?php

namespace App\Http\Controllers;

use App\Guardian;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuardianLoginController extends Controller
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
     * Display the logins for students.
     *
     * @return Factory|View
     */
    public function index()
    {
        $with = ['person.phones', 'person.phones.phoneType', 'person.phones.country', 'type', 'family'];
        $guardians = Guardian::with($with)->get();

        return view('logins.guardian_logins', compact('guardians'));
    }

    /**
     * Export Logins.
     *
     * @return Factory|View
     */
    public function loginsExport()
    {
        $guardians = Guardian::with('person')->isImported(false)->get();

        foreach ($guardians as $guardian) {
            if ($guardian->username === null) {
                $lastname = preg_replace('/[^A-Za-z0-9]/', '', $guardian->person->family_name);
                $guardian->username = strtolower($lastname).$guardian->id.'@tlcdg.com';
                $guardian->password = 'tlcPP'.rand(0,9).rand(0,9).rand(0,9);
                $guardian->save();
            }
        }

        return view('logins.guardian_export', compact('guardians'));
    }

    /**
     * Mark a student as imported.
     *
     * @return RedirectResponse
     */
    public function imported()
    {
        $guardians = Guardian::with('person')->isImported(false)->get();

        foreach ($guardians as $guardian) {
            $guardian = DatabaseHelpers::dbAddAudit($guardian);
            $guardian->is_imported = true;
           ViewHelpers::flash($guardian->save(), 'guardian', 'updated');
        }

        return redirect()->back();
    }
}
