<?php

namespace Tests\Browser\Pages;

use App\Employee;
use Laravel\Dusk\Browser;

class EmployeeProfile extends Page
{
    protected $employee;

    /**
     * EmployeeProfile constructor.
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/employee/'.$this->employee->uuid.'/profile';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertSee($this->employee->person->preferredName().'\'s Profile');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@filepond' => '#profile-form #filepond',
            '@filepond_input' => '.filepond--file-wrapper input[name=upload]',
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
     * Submit a profile picture.
     *
     * @param Browser $browser
     * @param $filepond_const
     */
    public function submitProfilePicture(Browser $browser, $filepond_const)
    {
        $browser->submitForm('profile-form')
            ->seeErrorDialog()
            ->assertVisible('@filepond')
            ->uploadFile('@filepond_input', $filepond_const, url('/storage/default-male.png'))
            ->submitForm('profile-form')
            ->on(new EmployeeProfile($this->employee))
            ->seeSuccessDialog()
            ->assertVisible('@profile-image');
    }
}
