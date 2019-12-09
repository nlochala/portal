<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Visa;
use App\Country;
use App\Guardian;
use App\Passport;
use App\VisaType;
use App\VisaEntry;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GuardianPassportVisaController extends GuardianController
{
    /**
     * Display the Passport and Visa information page.
     *
     * @param Guardian $guardian
     *
     * @return Factory|View
     */
    public function passportVisa(Guardian $guardian)
    {
        if ($guardian->person->passports->isEmpty()) {
            return redirect()->to('/guardian/'.$guardian->uuid.'/create_passport');
        }

        $visa_type_dropdown = VisaType::getDropdown();
        $entry_dropdown = VisaEntry::getDropdown();
        $status_dropdown = Visa::$statusRadio;

        $passports = $guardian->person->passports->load('visas')->sortByDesc('issue_date');

        return view('guardian.passport_visa', compact(
            'guardian',
            'passports',
            'visa_type_dropdown',
            'entry_dropdown',
            'status_dropdown'
        ));
    }

    /**
     * Display the passport update form.
     *
     * @param Guardian $guardian
     * @param Passport $passport
     *
     * @return Factory|View
     */
    public function updatePassportForm(Guardian $guardian, Passport $passport)
    {
        $country_dropdown = Country::getDropdown();
        $status_dropdown = Passport::$statusRadio;

        return view('guardian.passport_edit_form', compact(
            'guardian',
            'country_dropdown',
            'passport',
            'status_dropdown'
        ));
    }

    /**
     * Process the update passport form.
     *
     * @param Guardian $guardian
     * @param Passport $passport
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updatePassport(Guardian $guardian, Passport $passport)
    {
        $values = request()->all();
        $passport = DatabaseHelpers::dbAddAudit($passport);

        if (request()->has('upload')) {
            $filename = Str::slug('passport '.$guardian->person->fullName(true));

            if (! $file = File::getFile($values['upload'])) {
                ViewHelpers::flashAlert(
                    'danger',
                    'Could not find the uploaded image. Please try again.',
                    'fa fa-info-circle mr-1');

                return redirect()->back()->withInput();
            }

            if (! $resized_file = File::saveAndResizeImage($file, $filename)) {
                ViewHelpers::flashAlert(
                    'danger',
                    'Could not resize the uploaded image. Please try again.',
                    'fa fa-info-circle mr-1');

                return redirect()->back()->withInput();
            }
            $passport->image_file_id = $resized_file->id;
        }

        if ($passport->update($values)) {
            ViewHelpers::flashAlert(
                'success',
                'The passport has been successfully updated.',
                'fa fa-check mr-1');

            return redirect()->to("/guardian/$guardian->uuid/passports_visas");
        }

        ViewHelpers::flashAlert(
            'danger',
            'There was a problem updating your passport. Please try again.',
            'fa fa-info-circle mr-1');

        return redirect()->back()->withInput();
    }

    /**
     * Display the passport creation form.
     *
     * @param Guardian $guardian
     *
     * @return Factory|View
     */
    public function createPassport(Guardian $guardian)
    {
        $country_dropdown = Country::getDropdown();
        $image_data = Passport::getSampleImage();
        $status_dropdown = Passport::$statusRadio;

        return view('guardian.passport_form', compact(
            'guardian',
            'country_dropdown',
            'image_data',
            'status_dropdown'
        ));
    }

    /**
     * Store new passport information.
     *
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function storePassport(Guardian $guardian)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $filename = Str::slug('passport '.$guardian->person->fullName(true));

        if (! request()->has('upload')) {
            ViewHelpers::flashAlert(
                'danger',
                'Please upload a scanned image of the passport. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $file = File::getFile($values['upload'])) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not find the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $resized_file = File::saveAndResizeImage($file, $filename)) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not resize the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        $values['image_file_id'] = $resized_file->id;
        $values['person_id'] = $guardian->person->id;

        /* @noinspection PhpUndefinedMethodInspection */
       ViewHelpers::flash(Passport::create($values), 'passport');

        return redirect()->to('/guardian/'.$guardian->uuid.'/passports_visas');
    }

    /**
     * Store the visa for the given passport.
     *
     * @param Guardian $guardian
     * @param Passport $passport
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function storeVisa(Guardian $guardian, Passport $passport)
    {
        $old_values = DatabaseHelpers::dbAddAudit(request()->all());
        $filename = Str::slug('visa '.$guardian->person->fullName(true));
        $values = [];

        foreach ($old_values as $key => $value) {
            $values[explode('__'.$passport->id, $key)[0]] = $value;
        }

        if (! request()->has('upload')) {
            ViewHelpers::flashAlert(
                'danger',
                'Please upload a scanned image of the visa. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $file = File::getFile($values['upload'])) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not find the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $resized_file = File::saveAndResizeImage($file, $filename)) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not resize the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        $values['image_file_id'] = $resized_file->id;
        $values['passport_id'] = $passport->id;

        /* @noinspection PhpUndefinedMethodInspection */
       ViewHelpers::flash(Visa::create($values), 'visa');

        return redirect()->back();
    }

    /**
     * Store the updated visa.
     *
     * @param Guardian $guardian
     * @param Visa     $visa
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updateVisa(Guardian $guardian, Visa $visa)
    {
        $values = request()->all();
        $filename = Str::slug('visa '.$guardian->person->fullName(true));

        if (request()->has('upload_1')) {
            if (! $file = File::getFile($values['upload_1'])) {
                ViewHelpers::flashAlert(
                    'danger',
                    'Could not find the uploaded image. Please try again.',
                    'fa fa-info-circle mr-1');

                return redirect()->back()->withInput();
            }

            if (! $resized_file = File::saveAndResizeImage($file, $filename)) {
                ViewHelpers::flashAlert(
                    'danger',
                    'Could not resize the uploaded image. Please try again.',
                    'fa fa-info-circle mr-1');

                return redirect()->back()->withInput();
            }

            $visa->image_file_id = $resized_file->id;
        }

        $visa->is_active = $values["is_active_$visa->id"];
        $visa->visa_type_id = $values["visa_type_id_$visa->id"];
        $visa->visa_entry_id = $values["visa_entry_id_$visa->id"];
        $visa->issue_date = $values["issue_date_$visa->id"];
        $visa->expiration_date = $values["expiration_date_$visa->id"];
        $visa->number = $values['number'];
        $visa->entry_duration = $values['entry_duration'];

        $visa = DatabaseHelpers::dbAddAudit($visa);
       ViewHelpers::flash($visa->save(), 'visa', 'updated');

        return redirect()->back();
    }
}
