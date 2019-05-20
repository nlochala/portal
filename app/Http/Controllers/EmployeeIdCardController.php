<?php

namespace App\Http\Controllers;

use App\File;
use App\IdCard;
use App\Employee;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class EmployeeIdCardController extends EmployeeController
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
     * Return the employee Id Card view.
     *
     * @param Employee $employee
     *
     * @return Factory|View
     */
    public function idCard(Employee $employee)
    {
        $id_cards = $employee->person->idCards;

        /* @noinspection PhpUndefinedMethodInspection */
        if ($id_cards->isEmpty()) {
            return redirect()->to("/employee/$employee->uuid/create_id_card");
        }

        return view('employee.id_card', compact(
            'employee',
            'id_cards'
        ));
    }

    /**
     * Display the ID Card Create Form.
     *
     * @param Employee $employee
     *
     * @return Factory|View
     */
    public function createForm(Employee $employee)
    {
        $status_dropdown = IdCard::$statusRadio;

        return view('employee.id_card_form', compact(
            'employee',
            'status_dropdown'
        ));
    }

    /**
     * Store a new ID Card.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function store(Employee $employee)
    {
        $values = Helpers::dbAddAudit(request()->all());
        $values['person_id'] = $employee->person->id;

        $uploads = ['front' => $values['upload_front'], 'back' => $values['upload_back']];
        foreach ($uploads as $key => $value) {
            $filename = Str::slug("ID Card $key ".$employee->person->fullName(true));

            if (! $file_id = $this->processImage($key, $value, $filename)) {
                return redirect()->back()->withInput();
            }
            $values[$key.'_image_file_id'] = $file_id;
        }

        /* @noinspection PhpUndefinedMethodInspection */
        Helpers::flash(IdCard::create($values), 'ID Card');

        return redirect()->to("/employee/$employee->uuid/id_card");
    }

    /**
     * Edit the given ID Card.
     *
     * @param Employee $employee
     * @param IdCard   $id_card
     *
     * @return Factory|View
     */
    public function editForm(Employee $employee, IdCard $id_card)
    {
        $status_dropdown = IdCard::$statusRadio;

        return view('employee.id_card_edit_form', compact(
            'employee',
            'status_dropdown',
            'id_card'
        ));
    }

    /**
     * Update the ID Card.
     *
     * @param Employee $employee
     * @param IdCard   $id_card
     *
     * @return RedirectResponse
     *
     * @throws FileNotFoundException
     */
    public function update(Employee $employee, IdCard $id_card)
    {
        $values = Helpers::dbAddAudit(request()->all());
        $uploads = [];

        ! isset($values['upload_front']) ?: $uploads['front'] = $values['upload_front'];
        ! isset($values['upload_back']) ?: $uploads['back'] = $values['upload_back'];

        foreach ($uploads as $key => $value) {
            $filename = Str::slug("ID Card $key ".$employee->person->fullName(true));
            if (! $file_id = $this->processImage($key, $value, $filename)) {
                return redirect()->back()->withInput();
            }

            $values[$key.'_image_file_id'] = $file_id;
        }

        Helpers::flash($id_card->update($values), 'ID Card', 'updated');

        return redirect()->to("/employee/$employee->uuid/id_card");
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
            Helpers::flashAlert(
                'danger',
                'Please upload a scanned image of the ID Card. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        if (! $file = File::getFile($value)) {
            Helpers::flashAlert(
                'danger',
                'Could not find the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        if (! $resized_file = File::saveAndResizeImage($file, $filename)) {
            Helpers::flashAlert(
                'danger',
                'Could not resize the uploaded image. Please try again.',
                'fa fa-info-circle mr-1');

            return false;
        }

        return $resized_file->id;
    }
}
