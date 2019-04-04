<?php

namespace App\Http\Controllers;

use App\Employee;
use App\IdCard;
use Illuminate\Contracts\View\Factory;
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

        if($id_cards->isEmpty()){
            return redirect()->to("/employee/$employee->id/create_id_card");
        }

        return view('employee.id_card', compact(
            'employee',
            'id_cards'
        ));
    }

    public function createForm(Employee $employee)
    {
        $status_dropdown = IdCard::$statusRadio;
        return view('employee.id_card_form', compact(
            'employee',
            'status_dropdown'
        ));
    }

    public function store(Employee $employee)
    {

    }

    public function editForm(Employee $employee, IdCard $idCard)
    {

    }

    public function update(Employee $employee, IdCard $idCard)
    {

    }
}
