<?php

namespace App\Http\Controllers;

use App\Country;
use App\Employee;
use App\Ethnicity;
use App\Helpers\Helpers;
use App\Language;
use App\Person;
use App\PersonType;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonController extends Controller
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
     * Display the new person form.
     *
     * @return Factory|View
     */
    public function create()
    {
        $title_dropdown = Person::$titleDropdown;
        $type_dropdown = PersonType::getDropdown();
        $gender_dropdown = Person::$genderRadio;
        $language_dropdown = Language::getDropdown();
        $country_dropdown = Country::getDropdown();
        $ethnicity_dropdown = Ethnicity::getDropdown();

        return view('person.create', compact(
            'title_dropdown',
            'type_dropdown',
            'gender_dropdown',
            'language_dropdown',
            'country_dropdown',
            'ethnicity_dropdown'
        ));
    }

    /**
     * Store the information from the person create form.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $values = Helpers::dbAddAudit(request()->all());
        $values['title'] = Person::getTitle($values['title']);
        $values['gender'] = Person::getGender($values['gender']);
        /** @noinspection PhpUndefinedMethodInspection */
        $person = Person::create($values);

        if (!$person) {
            Helpers::flashAlert('danger', 'There was a problem saving your form. Please try again.', 'fa fa-info-circle mr-1');
            return redirect()->back();
        }

        switch ($person->personType->name) {
            case 'Student':
                break;
            case 'Parent':
                break;
            case 'Employee':
                /** @noinspection PhpUndefinedMethodInspection */
                $employee = Employee::create([
                    'person_id' => $person->id,
                    'user_created_id' => $values['user_created_id'],
                    'user_created_ip' => $values['user_created_ip']
                ]);
                if (!$employee) {
                    Helpers::flashAlert('danger', 'There was a problem saving your form. Please try again.', 'fa fa-info-circle mr-1');
                    return redirect()->back();
                }
                Helpers::flashAlert('success', 'The employee has been successfully created.', 'fa fa-check mr-1');
                return redirect()->to('employee/' . $employee->uuid . '/profile');
            default:
                Helpers::flashAlert('danger', 'Not sure what type of person you are trying to create... Please try again.', 'fa fa-info-circle mr-1');
                return redirect()->back();
        }
    }
}
