<?php

namespace App\Http\Controllers;

use App\Country;
use App\Employee;
use App\Ethnicity;
use App\File;
use App\Helpers\Helpers;
use App\Language;
use App\Person;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use View;

class EmployeeProfileController extends EmployeeController
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
     * Display a listing of the resource.
     *
     * @param Employee $employee
     *
     * @return View
     */
    public function profile(Employee $employee)
    {
        $menu_list = Employee::getProfileMenu($employee);
        $title_dropdown = Person::$titleDropdown;
        $gender_dropdown = Person::$genderRadio;
        $language_dropdown = Language::getDropdown();
        $country_dropdown = Country::getDropdown();
        $ethnicity_dropdown = Ethnicity::getDropdown();
        $employee->load('person');

        $image_data = null;
        $image_size = 'N/A';
        $image_created = 'N/A';

        $original_image_size = 'N/A';
        $original_image_url = null;

        if ($employee->person->image) {
            $image_data = $employee->person->image->renderImage();
            $image_size = Helpers::formatBytes($employee->person->image->size);
            $image_created = $employee->person->image->created_at;

            $original_image_size = Helpers::formatBytes($employee->person->image->originalFile->size);
            $original_image_url = '/download_file/'.$employee->person->image->originalFile->uuid;
        }

        return view('employee.profile', compact(
            'title_dropdown',
            'gender_dropdown',
            'language_dropdown',
            'country_dropdown',
            'ethnicity_dropdown',
            'employee',
            'menu_list',
            'image_data',
            'image_size',
            'image_created',
            'original_image_size',
            'original_image_url'
        ));
    }

    /**
     * Update the basic profile on an employee.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updateProfile(Employee $employee)
    {
        $values = request()->all();

        if (!request()->has('dob') && !request()->has('upload')) {
            Helpers::flashAlert(
                'danger',
                'An image was not selected. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back();
        }

        if (request()->has('upload')) {
            Helpers::flash($this->processImage(json_decode($values['upload']), $employee), 'image', 'created');
            return redirect()->to('/employee/'.$employee->uuid.'/profile');
        }

        $values['dob'] = Carbon::createFromFormat('Y-m-d', $values['dob']);
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['title'] = Person::getTitle($values['title']);
        $values['gender'] = Person::getGender($values['gender']);

        Helpers::flash($employee->person->update($values), 'employee profile', 'updated');

        return redirect()->to('/employee/'.$employee->uuid.'/profile');
    }

    /**
     * @param array    $file_uuid
     * @param Employee $employee
     *
     * @return bool|RedirectResponse
     *
     * @throws FileNotFoundException
     */
    protected function processImage(array $file_uuid, Employee $employee)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $file = File::where('uuid', $file_uuid)->first();
        if (!$file) {
            return false;
        }

        if (!$resized_file = File::saveAndResizeImage($file)) {
            return false;
        }

        $employee->person->update(['image_file_id' => $resized_file->id]);
        return true;
    }
}
