<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\IdCard;
use App\Guardian;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GuardianIdCardController extends GuardianController
{

    /**
     * Return the guardian Id Card view.
     *
     * @param Guardian $guardian
     *
     * @return Factory|View
     */
    public function idCard(Guardian $guardian)
    {
        $id_cards = $guardian->person->idCards;

        /* @noinspection PhpUndefinedMethodInspection */
        if ($id_cards->isEmpty()) {
            return redirect()->to("/guardian/$guardian->uuid/create_id_card");
        }

        return view('guardian.id_card', compact(
            'guardian',
            'id_cards'
        ));
    }

    /**
     * Display the ID Card Create Form.
     *
     * @param Guardian $guardian
     *
     * @return Factory|View
     */
    public function createForm(Guardian $guardian)
    {
        $status_dropdown = IdCard::$statusRadio;

        return view('guardian.id_card_form', compact(
            'guardian',
            'status_dropdown'
        ));
    }

    /**
     * Store a new ID Card.
     *
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function store(Guardian $guardian)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $values['person_id'] = $guardian->person->id;

        $uploads = ['front' => $values['upload_front'], 'back' => $values['upload_back']];
        foreach ($uploads as $key => $value) {
            $filename = Str::slug("ID Card $key ".$guardian->person->fullName(true));

            if (! $file_id = $this->processImage($key, $value, $filename)) {
                return redirect()->back()->withInput();
            }
            $values[$key.'_image_file_id'] = $file_id;
        }

        /* @noinspection PhpUndefinedMethodInspection */
       ViewHelpers::flash(IdCard::create($values), 'ID Card');

        return redirect()->to("/guardian/$guardian->uuid/id_card");
    }

    /**
     * Edit the given ID Card.
     *
     * @param Guardian $guardian
     * @param IdCard   $id_card
     *
     * @return Factory|View
     */
    public function editForm(Guardian $guardian, IdCard $id_card)
    {
        $status_dropdown = IdCard::$statusRadio;

        return view('guardian.id_card_edit_form', compact(
            'guardian',
            'status_dropdown',
            'id_card'
        ));
    }

    /**
     * Update the ID Card.
     *
     * @param Guardian $guardian
     * @param IdCard   $id_card
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function update(Guardian $guardian, IdCard $id_card)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $uploads = [];

        ! isset($values['upload_front']) ?: $uploads['front'] = $values['upload_front'];
        ! isset($values['upload_back']) ?: $uploads['back'] = $values['upload_back'];

        foreach ($uploads as $key => $value) {
            $filename = Str::slug("ID Card $key ".$guardian->person->fullName(true));
            if (! $file_id = $this->processImage($key, $value, $filename)) {
                return redirect()->back()->withInput();
            }

            $values[$key.'_image_file_id'] = $file_id;
        }

       ViewHelpers::flash($id_card->update($values), 'ID Card', 'updated');

        return redirect()->to("/guardian/$guardian->uuid/id_card");
    }

    /**
     * Process an ID Card Image.
     *
     * @param $key
     * @param $value
     * @param $filename
     *
     * @return bool
     *
     * @throws FileNotFoundException
     */
    protected function processImage($key, $value, $filename)
    {
        if (! request()->has("upload_$key")) {
            ViewHelpers::flashAlert(
                'danger',
                'Please upload a scanned image of the ID Card. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        if (! $file = File::getFile($value)) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not find the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        if (! $resized_file = File::saveAndResizeImage($file, $filename)) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not resize the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        return $resized_file->id;
    }
}
