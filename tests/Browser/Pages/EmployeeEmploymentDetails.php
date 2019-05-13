<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Position;
use Carbon\Carbon;
use App\EmployeeStatus;
use Laravel\Dusk\Browser;
use Illuminate\Support\Arr;
use App\EmployeeClassification;
use Facebook\WebDriver\Exception\TimeOutException;
use App\Http\Requests\StoreEmployeeOverviewRequest;

class EmployeeEmploymentDetails extends Page
{
    protected $employee;

    /**
     * EmployeeProfile constructor.
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        parent::__construct();
        $this->employee = $employee;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/employee/'.$this->employee->uuid.'/employment_overview';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertPathIs($this->url())
            ->assertSee($this->employee->person->preferredName()."'s Employment Overview");
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
        ];
    }

    /**
     * Modify the employee's employment details.
     *
     * @param Browser $browser
     */
    public function employeeOverview(Browser $browser)
    {
        // FORM FAKER FIELDS
        $start_date = Carbon::now()->subMonths(12)->format('Y-m-d');
        $employee_classification = Arr::random(EmployeeClassification::getDropdown());
        $employee_status = Arr::random(EmployeeStatus::getDropdown());

        // FORM REQUEST
        $form_request = new StoreEmployeeOverviewRequest();
        $excluded_ids = [];

        // VIEW FORM (IF MODAL)
        $browser
            // TEST FOR VALIDATION MESSAGES
            ->submitForm('overview-form')
            ->assertHasRequiredInputErrors($form_request, $excluded_ids)

            // FILL IN FORM
            ->selectDate('start_date', $start_date)
            ->selectRadio($employee_classification)
            ->selectRadio($employee_status)

            // SUBMIT FORM
            ->submitForm('overview-form')
            ->on($this)

            // SEE SUCCESS
            ->seeSuccessDialog();
    }

    /**
     * Assign positions to the employee.
     *
     * @param Browser $browser
     * @throws TimeOutException
     */
    public function employeePositions(Browser $browser)
    {
        $positions = Position::all()->random(2);

        foreach ($positions as $position) {
            $browser
                ->click('@btn-modal-block-positions')
                ->waitFor('@modal-block-positions')
                ->searchTable('position_table', $position->name)
                ->click("@$position->uuid")
                ->on($this)
                ->seeSuccessDialog();
        }

        foreach ($positions as $position) {
            $browser
                ->assertSee($position->name)
                ->assertSee($position->type->name)
                ->assertSee($position->school->name)
                ->assertSee($position->stipend);
        }
    }
}
