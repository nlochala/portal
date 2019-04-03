<?php

namespace App\Http\Controllers;

use App\{Country, Employee, File, Helpers\Helpers, Passport, Visa, VisaEntry, VisaType};
use Illuminate\{Contracts\Filesystem\FileNotFoundException, Contracts\View\Factory, Http\RedirectResponse, View\View};
use Symfony\Component\Console\Helper\Helper;

class EmployeePassportVisaController extends EmployeeController
{
    /**
     * Display the Passport and Visa information page
     *
     * @param Employee $employee
     * @return Factory|View
     */
    public function passportVisa(Employee $employee)
    {
        if ($employee->person->passports->isEmpty()) {
            return redirect()->to('/employee/' . $employee->id . '/create_passport');
        }

        $visa_type_dropdown = VisaType::getDropdown();
        $entry_dropdown = VisaEntry::getDropdown();
        $status_dropdown = Visa::$statusRadio;

        $passports = $employee->person->passports->load('visas')->sortByDesc('issue_date');

        return view('employee.passport_visa', compact(
            'employee',
            'passports',
            'visa_type_dropdown',
            'entry_dropdown',
            'status_dropdown'
        ));
    }

    /**
     * Display the passport update form
     *
     * @param Employee $employee
     * @param Passport $passport
     * @return Factory|View
     */
    public function updatePassportForm(Employee $employee, Passport $passport)
    {
        $country_dropdown = Country::getDropdown();
        $status_dropdown = Passport::$statusRadio;

        return view('employee.passport_edit_form', compact(
            'employee',
            'country_dropdown',
            'passport',
            'status_dropdown'
        ));
    }

    /**
     * Process the update passport form
     *
     * @param Employee $employee
     * @param Passport $passport
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function updatePassport(Employee $employee, Passport $passport)
    {
        $values = request()->all();

        if(request()->hasFile('image_file')){
            if(!$resized_image = File::saveAndResizeImage($values['image_file'])){
                Helpers::flashAlert(
                    'danger',
                    'There was an error processing your image. Please try again.',
                    'fa fa-info-circle mr-1');
                return redirect()->back();
            }

            $passport->image_file_id = $resized_image->id;
        }

        $passport = Helpers::dbAddAudit($passport);
        if($passport->update($values)){
            Helpers::flashAlert(
                'success',
                'The passport has been updated.',
                'fa fa-check mr-1');

            return redirect()->to("/employee/$employee->id/passports_visas");
        }

        Helpers::flashAlert(
            'danger',
            'There was a problem updating your passport. Please try again.',
            'fa fa-info-circle mr-1');

        return redirect()->back();
    }

    /**
     * Display the passport creation form
     *
     * @param Employee $employee
     * @return Factory|View
     */
    public function createPassport(Employee $employee)
    {
        $country_dropdown = Country::getDropdown();
        $image_data = Passport::getSampleImage();
        $status_dropdown = Passport::$statusRadio;

        return view('employee.passport_form', compact(
            'employee',
            'country_dropdown',
            'image_data',
            'status_dropdown'
        ));
    }

    /**
     * Store new passport information
     *
     * @param Employee $employee
     * @return void
     * @throws FileNotFoundException
     */
    public function storePassport(Employee $employee)
    {
        $values = Helpers::dbAddAudit(request()->all());

        if (!request()->hasFile('image_file')) {
            Helpers::flashAlert(
                'danger',
                'Please upload a scanned image of the passport. Please try again.',
                'fa fa-info-circle mr-1');
            return redirect()->back();
        }

        $resized_image = File::saveAndResizeImage($values['image_file']);
        $values['image_file_id'] = $resized_image->id;
        $values['person_id'] = $employee->person->id;

        /** @noinspection PhpUndefinedMethodInspection */
        Helpers::flash(Passport::create($values), 'passport');

        return redirect()->to('/employee/' . $employee->id . '/passports_visas');
    }

    /**
     * Store the visa for the given passport
     *
     * @param Employee $employee
     * @param Passport $passport
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function storeVisa(Employee $employee, Passport $passport)
    {
        $old_values = Helpers::dbAddAudit(request()->all());
        $values = [];

        foreach($old_values as $key => $value){
            $values[explode('__' . $passport->id, $key)[0]] = $value;
        }

        if (!request()->hasFile('image_file_id')) {
            Helpers::flashAlert(
                'danger',
                'Please upload a scanned image of the visa. Please try again.',
                'fa fa-info-circle mr-1');
            return redirect()->back();
        }

        if(!$resized_image = File::saveAndResizeImage($values['image_file_id'])){
            return redirect()->back();
        }

        $values['image_file_id'] = $resized_image->id;
        $values['passport_id'] = $passport->id;

        /** @noinspection PhpUndefinedMethodInspection */
        Helpers::flash(Visa::create($values), 'visa');

        return redirect()->back();
    }

    /**
     * Store the updated visa
     *
     * @param Employee $employee
     * @param Visa $visa
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function updateVisa(Employee $employee, Visa $visa)
    {
        $values = request()->all();

        if(request()->hasFile('image_file_id')){
            if(!$resized_image = File::saveAndResizeImage($values['image_file_id'])){
                Helpers::flashAlert(
                    'danger',
                    'There was an error processing your image. Please try again.',
                    'fa fa-info-circle mr-1');
                return redirect()->back();
            }

            $visa->image_file_id = $resized_image->id;
        }
        $visa->is_active = $values["is_active_$visa->id"];
        $visa->visa_type_id = $values["visa_type_id_$visa->id"];
        $visa->visa_entry_id = $values["visa_entry_id_$visa->id"];
        $visa->issue_date = $values["issue_date_$visa->id"];
        $visa->expiration_date = $values["expiration_date_$visa->id"];
        $visa->number = $values['number'];
        $visa->entry_duration = $values['entry_duration'];

        $visa = Helpers::dbAddAudit($visa);
        Helpers::flash($visa->save(),'visa','updated');

        return redirect()->back();
    }

}
