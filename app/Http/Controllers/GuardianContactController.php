<?php

namespace App\Http\Controllers;

use App\Phone;
use App\Address;
use App\Country;
use App\Guardian;
use App\PhoneType;
use App\AddressType;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class GuardianContactController extends GuardianController
{
    /**
     * Display the contact information.
     *
     * @param Guardian $guardian
     *
     * @return Factory|View
     */
    public function contact(Guardian $guardian)
    {
        $person = $guardian->person;

        $phone_numbers = $guardian->person->phones->load(
            'country',
            'phoneType'
        );

        $addresses = $guardian->person->addresses->load(
            'country',
            'addressType'
        );

        $phone_type_dropdown = PhoneType::getDropdown();
        $country_code_dropdown = Country::getCountryCodeDropdown();
        $address_type_dropdown = AddressType::getDropdown();
        $country_dropdown = Country::getDropdown();

        return view('guardian.contact', compact(
            'guardian',
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
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     */
    public function storeEmail(Guardian $guardian)
    {
        $values = request()->all();
        $person = $guardian->person;
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
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     */
    public function storePhone(Guardian $guardian)
    {
        $values = request()->all();
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['person_id'] = $guardian->person->id;
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
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     */
    public function storeAddress(Guardian $guardian)
    {
        $values = request()->all();
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['person_id'] = $guardian->person->id;
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
     * @param Guardian $guardian
     * @param Address  $address
     *
     * @return RedirectResponse
     */
    public function updateAddress(Guardian $guardian, Address $address)
    {
        $values = request()->all();
        $address->user_updated_id = auth()->id();
        $address->user_updated_ip = Helpers::getUserIp();
        $address->country_id = $values['country_id_'.$address->id];
        $address->address_type_id = $values['address_type_id_'.$address->id];
        $address->update($values);

        Helpers::flash($address->update($values), 'address', 'updated');

        return redirect()->to('/guardian/'.$guardian->uuid.'/contact');
    }
}
