<?php

namespace Tests\Browser\Pages;

use App\Employee;
use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;

class EmployeeContactInformation extends Page
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
        return '/employee/'.$this->employee->uuid.'/contact';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertSee($this->employee->person->preferredName().'\'s Contact Information');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@email_modal' => '#modal-block-email',
        ];
    }

    /**
     * Submit the profile form.
     *
     * @param Browser $browser
     */
    public function submitProfileForm(Browser $browser)
    {
        // BIOGRAPHIC
        $browser->submitForm('admin-form')
            ->assertSee('field is required')
            ->selectDropdown('title', 'Dr.')
            ->type('given_name', 'Richard')
            ->type('family_name', 'Lochala')
            ->type('preferred_name', 'Nathan')
            ->selectRadio('Male')
            ->type('name_in_chinese', '乐天赐')
            ->selectDate('dob', '1983-11-09')
            // DEMOGRAPHIC
            ->selectDropdown('country_of_birth_id', 'United States')
            ->selectDropdown('language_primary_id', 'English')
            ->selectDropdown('language_secondary_id', 'Chinese (Mandarin)')
            ->selectDropdown('language_tertiary_id', 'Romanian')
            ->selectDropdown('ethnicity_id', 'Caucasian')
            // SUBMIT
            ->submitForm('admin-form')
            ->on(new EmployeeProfile($this->employee))
            ->seeSuccessDialog();
    }

    /**
     * @param Browser $browser
     * @throws TimeOutException
     */
    public function updateEmailAddresses(Browser $browser)
    {
        $test_email_primary = $this->faker->email;
        $test_email_secondary = $this->faker->email;

        $browser->assertSee($this->employee->person->email_school)
            ->click('button[data-target=modal-block-email')
            ->whenAvailable('@email_modal', function ($modal) {
                $modal->assertSee($this->employee->person->email_school);
            });

        // Click on the modal and wait until you see it.

        // Submit with no primary email, make sure you can see the required field error

        // Fill out the emails with the test_email_xxxx values and submit

        // Make sure you can see the success dialog and that the value persisted and are visible outside the modal.
    }
}
