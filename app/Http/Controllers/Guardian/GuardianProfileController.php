<?php

namespace App\Http\Controllers;

use View;
use App\File;
use App\Person;
use App\Country;
use App\Guardian;
use App\Language;
use App\Ethnicity;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GuardianProfileController extends GuardianController
{
    /**
     * Display a listing of the resource.
     *
     * @param Guardian $guardian
     *
     * @return View
     */
    public function profile(Guardian $guardian)
    {
        $title_dropdown = Person::$titleDropdown;
        $gender_dropdown = Person::$genderRadio;
        $language_dropdown = Language::getDropdown();
        $country_dropdown = Country::getDropdown();
        $ethnicity_dropdown = Ethnicity::getDropdown();
        $guardian->load('person');

        $image_data = null;
        $image_size = 'N/A';
        $image_created = 'N/A';

        $original_image_size = 'N/A';
        $original_image_url = null;

        if ($guardian->person->image) {
            $image_data = $guardian->person->image->renderImage();
            $image_size = Helpers::formatBytes($guardian->person->image->size);
            $image_created = $guardian->person->image->created_at;

            $original_image_size = Helpers::formatBytes($guardian->person->image->originalFile->size);
            $original_image_url = '/download_file/'.$guardian->person->image->originalFile->uuid;
        }

        return view('guardian.profile', compact(
            'title_dropdown',
            'gender_dropdown',
            'language_dropdown',
            'country_dropdown',
            'ethnicity_dropdown',
            'guardian',
            'image_data',
            'image_size',
            'image_created',
            'original_image_size',
            'original_image_url'
        ));
    }

    /**
     * Update the basic profile on an guardian.
     *
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function updateProfile(Guardian $guardian)
    {
        $values = request()->all();

        if (! request()->has('family_name') && ! request()->has('upload')) {
            Helpers::flashAlert(
                'danger',
                'An image was not selected. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back();
        }

        if (request()->has('upload')) {
            Helpers::flash($this->processImage(json_decode($values['upload']), $guardian), 'image');

            return redirect()->to('/guardian/'.$guardian->uuid.'/profile');
        }

        $values['title'] = Person::getTitle($values['title']);
        $values['user_created_id'] = auth()->id();
        $values['user_created_ip'] = Helpers::getUserIp();
        $values['gender'] = Person::getGender($values['gender']);

        Helpers::flash($guardian->person->update($values), 'guardian profile', 'updated');
        $guardian->searchable();

        if ($guardian->person->employee) {
            $guardian->person->employee->searchable();
        }

        return redirect()->to('/guardian/'.$guardian->uuid.'/profile');
    }

    /**
     * @param array    $file_uuid
     * @param Guardian $guardian
     *
     * @return bool|RedirectResponse
     *
     * @throws FileNotFoundException
     */
    protected function processImage(array $file_uuid, Guardian $guardian)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $file = File::where('uuid', $file_uuid)->first();
        if (! $file) {
            return false;
        }

        if (! $resized_file = File::saveAndResizeImage($file)) {
            return false;
        }

        $guardian->person->update(['image_file_id' => $resized_file->id]);

        return true;
    }
}
