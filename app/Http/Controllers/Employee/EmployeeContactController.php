<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Phone;
use App\Address;
use App\Country;
use App\Employee;
use App\PhoneType;
use App\AddressType;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class EmployeeContactController extends EmployeeController
{
    /**
     * Display the contact information.
     *
     * @param Employee $employee
     *
     * @return Factory|View
     */
    public function contact(Employee $employee)
    {
        $person = $employee->person;

        $phone_numbers = $employee->person->phones->load(
            'country',
            'phoneType'
        );

        $addresses = $employee->person->addresses->load(
            'country',
            'addressType'
        );

        $phone_type_dropdown = PhoneType::getDropdown();
        $country_code_dropdown = Country::getCountryCodeDropdown();
        $address_type_dropdown = AddressType::getDropdown();
        $country_dropdown = Country::getDropdown();

        return view('employee.contact', compact(
            'employee',
            'phone_numbers',
            'addresses',
            'phone_type_dropdown',
            'country_code_dropdown',
            'country_dropdown',
            'address_type_dropdown',
            'person'
        ));
    }

    /**
     * Store the "Update Email Addresses" form.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function storeEmail(Employee $employee)
    {
        $values = request()->all();
        $person = $employee->person;
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = DatabaseHelpers::getUserIp();
        $person->update($values)
            ?
            ViewHelpers::flashAlert(
                'success',
                'The email addresses have been successfully saved/updated.',
                'fa fa-check mr-1')
            :
            ViewHelpers::flashAlert(
                'danger',
                'The email address changes did not save correctly. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Store the "New Phone Number" form.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function storePhone(Employee $employee)
    {
        $values = request()->all();
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = DatabaseHelpers::getUserIp();
        $values['person_id'] = $employee->person->id;
        $values['country_id'] = $values['country_id_phone'];
        /* @noinspection PhpUndefinedMethodInspection */
        Phone::create($values)
            ?
            ViewHelpers::flashAlert(
                'success',
                'The phone number has been successfully saved.',
                'fa fa-check mr-1')
            :
            ViewHelpers::flashAlert(
                'danger',
                'The phone number did not save correctly. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Store the "New Address" form.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function storeAddress(Employee $employee)
    {
        $values = request()->all();
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = DatabaseHelpers::getUserIp();
        $values['person_id'] = $employee->person->id;
        /* @noinspection PhpUndefinedMethodInspection */
        Address::create($values)
            ?
            ViewHelpers::flashAlert(
                'success',
                'The address number has been successfully saved.',
                'fa fa-check mr-1')
            :
            ViewHelpers::flashAlert(
                'danger',
                'The address number did not save correctly. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Update the given address.
     *
     * @param Employee $employee
     * @param Address  $address
     *
     * @return RedirectResponse
     */
    public function updateAddress(Employee $employee, Address $address)
    {
        $values = request()->all();
        $address->user_updated_id = auth()->id();
        $address->user_updated_ip = DatabaseHelpers::getUserIp();
        $address->country_id = $values['country_id_'.$address->id];
        $address->address_type_id = $values['address_type_id_'.$address->id];
        $address->update($values);

       ViewHelpers::flash($address->update($values), 'address', 'updated');

        return redirect()->to('/employee/'.$employee->uuid.'/contact');
    }
}
