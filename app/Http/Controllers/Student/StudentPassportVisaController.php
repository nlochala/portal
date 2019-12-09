<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Visa;
use App\Country;
use App\Student;
use App\Passport;
use App\VisaType;
use App\VisaEntry;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class StudentPassportVisaController extends StudentController
{
    /**
     * Display the Passport and Visa information page.
     *
     * @param Student $student
     *
     * @return Factory|View
     */
    public function passportVisa(Student $student)
    {
        if ($student->person->passports->isEmpty()) {
            return redirect()->to('/student/'.$student->uuid.'/create_passport');
        }

        $visa_type_dropdown = VisaType::getDropdown();
        $entry_dropdown = VisaEntry::getDropdown();
        $status_dropdown = Visa::$statusRadio;

        $passports = $student->person->passports->load('visas')->sortByDesc('issue_date');

        return view('student.passport_visa', compact(
            'student',
            'passports',
            'visa_type_dropdown',
            'entry_dropdown',
            'status_dropdown'
        ));
    }

    /**
     * Display the passport update form.
     *
     * @param Student $student
     * @param Passport $passport
     *
     * @return Factory|View
     */
    public function updatePassportForm(Student $student, Passport $passport)
    {
        $country_dropdown = Country::getDropdown();
        $status_dropdown = Passport::$statusRadio;

        return view('student.passport_edit_form', compact(
            'student',
            'country_dropdown',
            'passport',
            'status_dropdown'
        ));
    }

    /**
     * Process the update passport form.
     *
     * @param Student $student
     * @param Passport $passport
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updatePassport(Student $student, Passport $passport)
    {
        $values = request()->all();
        $passport = DatabaseHelpers::dbAddAudit($passport);

        if (request()->has('upload')) {
            $filename = Str::slug('passport '.$student->person->fullName(true));

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

            return redirect()->to("/student/$student->uuid/passports_visas");
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
     * @param Student $student
     *
     * @return Factory|View
     */
    public function createPassport(Student $student)
    {
        $country_dropdown = Country::getDropdown();
        $image_data = Passport::getSampleImage();
        $status_dropdown = Passport::$statusRadio;

        return view('student.passport_form', compact(
            'student',
            'country_dropdown',
            'image_data',
            'status_dropdown'
        ));
    }

    /**
     * Store new passport information.
     *
     * @param Student $student
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function storePassport(Student $student)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $filename = Str::slug('passport '.$student->person->fullName(true));

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
        $values['person_id'] = $student->person->id;

        /* @noinspection PhpUndefinedMethodInspection */
       ViewHelpers::flash(Passport::create($values), 'passport');

        return redirect()->to('/student/'.$student->uuid.'/passports_visas');
    }

    /**
     * Store the visa for the given passport.
     *
     * @param Student $student
     * @param Passport $passport
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function storeVisa(Student $student, Passport $passport)
    {
        $old_values = DatabaseHelpers::dbAddAudit(request()->all());
        $filename = Str::slug('visa '.$student->person->fullName(true));
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
     * @param Student $student
     * @param Visa     $visa
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updateVisa(Student $student, Visa $visa)
    {
        $values = request()->all();
        $filename = Str::slug('visa '.$student->person->fullName(true));

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
