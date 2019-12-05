<?php

namespace App\Http\Controllers;

use App\Phone;
use App\Address;
use App\Country;
use App\Student;
use App\PhoneType;
use App\AddressType;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class StudentContactController extends StudentController
{
    /**
     * Display the contact information.
     *
     * @param Student $student
     *
     * @return Factory|View
     */
    public function contact(Student $student)
    {
        $person = $student->person;

        $phone_numbers = $student->person->phones->load(
            'country',
            'phoneType'
        );

        $addresses = $student->person->addresses->load(
            'country',
            'addressType'
        );

        $phone_type_dropdown = PhoneType::getDropdown();
        $country_code_dropdown = Country::getCountryCodeDropdown();
        $address_type_dropdown = AddressType::getDropdown();
        $country_dropdown = Country::getDropdown();

        return view('student.contact', compact(
            'student',
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
     * @param Student $student
     *
     * @return RedirectResponse
     */
    public function storeEmail(Student $student)
    {
        $values = request()->all();
        $person = $student->person;
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $person->update($values)
            ?
            Helpers::flashAlert(
                'success',
                'The email addresses have been successfully saved/updated.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'The email address changes did not save correctly. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Store the "New Phone Number" form.
     *
     * @param Student $student
     *
     * @return RedirectResponse
     */
    public function storePhone(Student $student)
    {
        $values = request()->all();
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['person_id'] = $student->person->id;
        $values['country_id'] = $values['country_id_phone'];
        /* @noinspection PhpUndefinedMethodInspection */
        Phone::create($values)
            ?
            Helpers::flashAlert(
                'success',
                'The phone number has been successfully saved.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'The phone number did not save correctly. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Store the "New Address" form.
     *
     * @param Student $student
     *
     * @return RedirectResponse
     */
    public function storeAddress(Student $student)
    {
        $values = request()->all();
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['person_id'] = $student->person->id;
        /* @noinspection PhpUndefinedMethodInspection */
        Address::create($values)
            ?
            Helpers::flashAlert(
                'success',
                'The address number has been successfully saved.',
                'fa fa-check mr-1')
            :
            Helpers::flashAlert(
                'danger',
                'The address number did not save correctly. Please try again.',
                'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Update the given address.
     *
     * @param Student $student
     * @param Address  $address
     *
     * @return RedirectResponse
     */
    public function updateAddress(Student $student, Address $address)
    {
        $values = request()->all();
        $address->user_updated_id = auth()->id();
        $address->user_updated_ip = Helpers::getUserIp();
        $address->country_id = $values['country_id_'.$address->id];
        $address->address_type_id = $values['address_type_id_'.$address->id];
        $address->update($values);

        Helpers::flash($address->update($values), 'address', 'updated');

        return redirect()->to('/student/'.$student->uuid.'/contact');
    }
}
