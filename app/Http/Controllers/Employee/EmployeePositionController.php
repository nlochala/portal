<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Position;
use App\PositionType;
use App\EmployeeStatus;
use App\Helpers\Helpers;
use Illuminate\View\View;
use App\EmployeeClassification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class EmployeePositionController extends EmployeeController
{
    /**
     * @param Employee $employee
     *
     * @return Factory|View
     */
    public function employmentOverview(Employee $employee)
    {
        $classifications = EmployeeClassification::getDropdown();
        $statuses = EmployeeStatus::getDropdown();
        $types = PositionType::getDropdown();
        $positions = Position::all();
        $employee->load(['positions', 'positions.type', 'positions.school']);

        return view('employee.employee_overview', compact(
            'employee',
            'statuses',
            'types',
            'positions',
            'classifications'
        ));
    }

    /**
     * Show the list of positions with details.
     *
     * @param Employee $employee
     *
     * @return Factory|View
     */
    public function viewPositions(Employee $employee)
    {
        $employee->load(['positions', 'positions.type', 'positions.school', 'positions.supervisor']);

        return view('employee.positions_details', compact(
            'employee'
        ));
    }

    /**
     * Store the employee details.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function storeOverview(Employee $employee)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
       ViewHelpers::flash($employee->update($values), 'position details', 'updated');

        return redirect()->back();
    }

    /**
     * Add the position to the employee.
     *
     * @param Employee $employee
     * @param Position $position
     *
     * @return RedirectResponse
     */
    public function addPosition(Employee $employee, Position $position)
    {
        $employee->positions()->attach($position->id);
        ViewHelpers::flashAlert(
            'success',
            'The position has been successfully assigned.',
            'fa fa-check mr-1');

        return redirect()->back();
    }

    /**
     * Remove the position from the employee.
     *
     * @param Employee $employee
     * @param Position $position
     *
     * @return RedirectResponse
     */
    public function removePosition(Employee $employee, Position $position)
    {
        $employee->positions()->detach($position->id);
        ViewHelpers::flashAlert(
            'success',
            'The position has been successfully removed.',
            'fa fa-check mr-1');

        return redirect()->back();
    }
}
