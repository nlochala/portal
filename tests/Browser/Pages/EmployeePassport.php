<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\File;
use App\Helpers\TestHelpers;
use App\Passport;
use Laravel\Dusk\Browser;

class EmployeePassport extends Page
{
    protected $employee;
    protected $passport;

    /**
     * EmployeeProfile constructor.
     *
     * @param Employee $employee
     * @param bool     $setup_model
     */
    public function __construct(Employee $employee, $setup_model = false)
    {
        parent::__construct();
        $this->employee = $employee;

        if ($setup_model) {
            $this->passport = factory(Passport::class)->create([
                'person_id' => $this->employee->person->id,
                'image_file_id' => TestHelpers::getSampleImage()->id,
            ]);
        }
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/employee/'.$this->employee->uuid.'/passports_visas';
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
            ->assertSee($this->employee->person->preferredName().'\'s Passports and Visas');
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
     * Cancel a passport.
     *
     * @param Browser $browser
     */
    public function cancelPassport(Browser $browser)
    {
        $browser
            ->assertSee($this->passport->country->name)
            ->assertSee($this->passport->family_name)
            ->assertSee($this->passport->given_name)
            ->assertSee($this->passport->number)
            ->assertSee($this->passport->issue_date->format('Y-m-d'))
            ->assertSee($this->passport->expiration_date->format('Y-m-d'))
            ->assertSeeIn('@btn-active-'.$this->passport->id, 'ACTIVE')
//
            // Cancel Passport
            ->click('@btn-cancel-passport-'.$this->passport->id)
            ->on($this)
            // SEE SUCCESS
            ->seeSuccessDialog()
            ->assertSeeIn('@btn-cancelled-'.$this->passport->id, 'CANCELLED')
            ->assertSee('CANCELLED');
    }

    public function updatePassport(Browser $browser)
    {
        $browser
            ->assertSee($this->passport->country->name)
            ->assertSee($this->passport->family_name)
            ->assertSee($this->passport->given_name)
            ->assertSee($this->passport->number)
            ->assertSee($this->passport->issue_date->format('Y-m-d'))
            ->assertSee($this->passport->expiration_date->format('Y-m-d'))
            ->click('@btn-update-passport-'.$this->passport->id)
            ->on(new EmployeeUpdatePassport($this->employee, $this->passport));

        $browser
            ->visit(new EmployeeUpdatePassport($this->employee, $this->passport))
            ->updatePassport();
    }

    /**
     * Delete a passport.
     *
     * @param Browser $browser
     */
    public function deletePassport(Browser $browser)
    {
        $browser
            ->assertSeeIn('@btn-cancelled-'.$this->passport->id, 'CANCELLED')
            ->assertSee('CANCELLED')
            ->click('@btn-delete-passport-'.$this->passport->id)
            ->on(new EmployeeCreatePassport($this->employee));
    }
}
