<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Http\Requests\StoreEmployeeIdCardRequest;
use Carbon\Carbon;
use Laravel\Dusk\Browser;

class EmployeeCreateIdCard extends Page
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
        return '/employee/'.$this->employee->uuid.'/create_id_card';
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
            ->assertSee('New ID Card');
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

    public function createCard(Browser $browser)
    {
        // FORM FAKER FIELDS
        $is_active = 'Active';
        $name = '乐天赐';
        $number = $this->faker->randomNumber(8).
            $this->faker->randomNumber(8);
        $issue_date = Carbon::now()->subMonths(6)->format('Y-m-d');
        $expiration_date = Carbon::now()->addMonths(30)->format('Y-m-d');

        // FORM REQUEST
        $form_request = new StoreEmployeeIdCardRequest();
        $excluded_ids = [
            'upload_front',
            'upload_back',
        ];

        // VIEW FORM (IF MODAL)
        $browser
            // TEST FOR VALIDATION MESSAGES
            ->submitForm('id_card-form')
            ->assertHasRequiredInputErrors($form_request, $excluded_ids)

            // FILL IN FORM
            ->selectDropdown('is_active', $is_active)
            ->type('name', $name)
            ->type('number', $number)
            ->selectDate('issue_date', $issue_date)
            ->selectDate('expiration_date', $expiration_date)
            ->uploadFile('upload_front')
            ->uploadFile('upload_back')

            // SUBMIT FORM
            ->submitForm('id_card-form')
            ->on(new EmployeeIdCard($this->employee))

            // SEE SUCCESS
            ->seeSuccessDialog()

            // SEE EXPECTED VALUES ON THE PAGE
            ->assertSee($issue_date)
            ->assertSee($expiration_date)
            ->assertSee($name)
            ->assertSee($number);
    }
}
