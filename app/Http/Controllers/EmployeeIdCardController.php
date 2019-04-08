<?php

namespace App\Http\Controllers;

use App\Employee;
use App\File;
use App\Helpers\Helpers;
use App\IdCard;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmployeeIdCardController extends EmployeeController
{
    //
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
     * Return the employee Id Card view
     *
     * @param Employee $employee
     * @return Factory|View
     */
    public function idCard(Employee $employee)
    {
        $id_cards = $employee->person->idCards;

        /** @noinspection PhpUndefinedMethodInspection */
        if ($id_cards->isEmpty()) {
            return redirect()->to("/employee/$employee->uuid/create_id_card");
        }

        return view('employee.id_card', compact(
            'employee',
            'id_cards'
        ));
    }

    /**
     * Display the ID Card Create Form
     *
     * @param Employee $employee
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
     * Store a new ID Card
     *
     * @param Employee $employee
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function store(Employee $employee)
    {
        $values = Helpers::dbAddAudit(request()->all());

        if (!request()->hasFile('front_image_file_id') || !request()->hasFile('back_image_file_id')) {
            Helpers::flashAlert(
                'danger',
                'Please upload both a front and back image of the ID Card. Please try again.',
                'fa fa-info-circle mr-1');
            return redirect()->back();
        }

        $front_image = File::saveAndResizeImage($values['front_image_file_id'],
            Str::slug('front id card ' . $employee->person->fullName(true)));
        $back_image = File::saveAndResizeImage($values['back_image_file_id'],
            Str::slug('back id card ' . $employee->person->fullName(true)));

        if(!$front_image || !$back_image){
            return redirect()->back();
        }

        $values['person_id'] = $employee->person->id;
        $values['front_image_file_id'] = $front_image->id;
        $values['back_image_file_id'] = $back_image->id;

        /** @noinspection PhpUndefinedMethodInspection */
        Helpers::flash(IdCard::create($values),'ID Card');

        return redirect()->to("/employee/$employee->uuid/id_card");
    }

    /**
     * Edit the given ID Card
     *
     * @param Employee $employee
     * @param IdCard $id_card
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
     * Update the ID Card
     *
     * @param Employee $employee
     * @param IdCard $id_card
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function update(Employee $employee, IdCard $id_card)
    {
        $values = Helpers::dbAddAudit(request()->all());

        if(request()->hasFile('front_image_file_id')){
            if(!$front_image = File::saveAndResizeImage($values['front_image_file_id'],
                Str::slug('front id card ' . $employee->person->fullName(true)))){
                return redirect()->back();
            }

            $values['front_image_file_id'] = $front_image->id;
        }

        if(request()->hasFile('back_image_file_id')){
            if(!$back_image = File::saveAndResizeImage($values['back_image_file_id'],
                Str::slug('back id card ' . $employee->person->fullName(true)))){
                return redirect()->back();
            }

            $values['back_image_file_id'] = $back_image->id;
        }

        Helpers::flash($id_card->update($values), 'ID Card', 'updated');
        return redirect()->to("/employee/$employee->uuid/id_card");
    }
}
