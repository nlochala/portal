<?php

namespace App\Http\Controllers;

use View;
use App\File;
use App\Person;
use App\Country;
use App\Student;
use App\Language;
use App\Ethnicity;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class StudentProfileController extends StudentController
{
    /**
     * Display a listing of the resource.
     *
     * @param Student $student
     *
     * @return View
     */
    public function profile(Student $student)
    {
        $title_dropdown = Person::$titleDropdown;
        $gender_dropdown = Person::$genderRadio;
        $language_dropdown = Language::getDropdown();
        $country_dropdown = Country::getDropdown();
        $ethnicity_dropdown = Ethnicity::getDropdown();
        $student->load('person');

        $image_data = null;
        $image_size = 'N/A';
        $image_created = 'N/A';

        $original_image_size = 'N/A';
        $original_image_url = null;

        if ($student->person->image) {
            $image_data = $student->person->image->renderImage();
            $image_size = Helpers::formatBytes($student->person->image->size);
            $image_created = $student->person->image->created_at;

            $original_image_size = Helpers::formatBytes($student->person->image->originalFile->size);
            $original_image_url = '/download_file/'.$student->person->image->originalFile->uuid;
        }

        return view('student.profile', compact(
            'title_dropdown',
            'gender_dropdown',
            'language_dropdown',
            'country_dropdown',
            'ethnicity_dropdown',
            'student',
            'image_data',
            'image_size',
            'image_created',
            'original_image_size',
            'original_image_url'
        ));
    }

    /**
     * Update the basic profile on an student.
     *
     * @param Student $student
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updateProfile(Student $student)
    {
        $values = request()->all();

        if (! request()->has('dob') && ! request()->has('upload')) {
            Helpers::flashAlert(
                'danger',
                'An image was not selected. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back();
        }

        if (request()->has('upload')) {
            Helpers::flash($this->processImage(json_decode($values['upload']), $student), 'image');

            return redirect()->to('/student/'.$student->uuid.'/profile');
        }

        $values['dob'] = Carbon::createFromFormat('Y-m-d', $values['dob']);
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['gender'] = Person::getGender($values['gender']);

        Helpers::flash($student->person->update($values), 'student profile', 'updated');

        return redirect()->to('/student/'.$student->uuid.'/profile');
    }

    /**
     * @param array    $file_uuid
     * @param Student $student
     *
     * @return bool|RedirectResponse
     *
     * @throws FileNotFoundException
     */
    protected function processImage(array $file_uuid, Student $student)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $file = File::where('uuid', $file_uuid)->first();
        if (! $file) {
            return false;
        }

        if (! $resized_file = File::saveAndResizeImage($file)) {
            return false;
        }

        $student->person->update(['image_file_id' => $resized_file->id]);

        return true;
    }
}
