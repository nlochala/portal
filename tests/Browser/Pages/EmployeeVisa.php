<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Helpers\TestHelpers;
use App\Passport;
use App\Visa;
use App\VisaEntry;
use App\VisaType;
use Carbon\Carbon;
use Facebook\WebDriver\Exception\TimeOutException;
use Illuminate\Support\Arr;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\TestCase as PHPUnit;

class EmployeeVisa extends Page
{
    protected $employee;
    protected $passport;
    protected $visa;

    /**
     * EmployeeProfile constructor.
     *
     * @param Employee      $employee
     * @param Passport|null $passport
     */
    public function __construct(Employee $employee, Passport $passport = null)
    {
        parent::__construct();
        $this->employee = $employee;

        if ($passport) {
            $this->passport = $passport;
        } else {
            $this->passport = factory(Passport::class)->create([
                'person_id' => $this->employee->person->id,
                'image_file_id' => TestHelpers::getSampleImage()->id,
            ]);
            $this->visa = factory(Visa::class)->create([
                'passport_id' => $this->passport->id,
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
            ->assertPathIs($this->url());
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
     * Update the visa.
     *
     * @param Browser $browser
     *
     * @throws TimeOutException
     */
    public function updateVisa(Browser $browser)
    {
        // FORM FAKER FIELDS
        $is_active = 'Active';
        $visa_type = Arr::random(VisaType::getDropdown());
        $entry_type = Arr::random(VisaEntry::getDropdown());
        $number = $this->faker->randomNumber(8);
        $entry_duration = $this->faker->randomNumber(2);
        $issue_date = Carbon::now()->subMonths(6)->format('Y-m-d');
        $expiration_date = Carbon::now()->addMonths(16)->format('Y-m-d');

        // VIEW FORM (IF MODAL)
        $browser
            ->click('@btn-modal-block-visa-'.$this->visa->id)
            ->waitFor('@modal-block-visa-'.$this->visa->id)
            ->assertSeeIn('@modal-block-visa-'.$this->visa->id,
                'Edit Visa (#'.$this->visa->number.')')
            // FILL IN FORM
            ->selectDropdown('is_active_'.$this->visa->id, $is_active)
            ->selectDropdown('visa_type_id_'.$this->visa->id, $visa_type)
            ->selectDropdown('visa_entry_id_'.$this->visa->id, $entry_type)
            ->type('number', $number)
            ->type('entry_duration', $entry_duration)
            ->selectDate('issue_date_'.$this->visa->id, $issue_date)
            ->selectDate('expiration_date_'.$this->visa->id, $expiration_date)
            ->uploadFile('upload_'.$this->visa->id)
            // SUBMIT FORM
            ->submitForm('visa-edit-form-'.$this->visa->id)
            ->on($this)
            // SEE SUCCESS
            ->seeSuccessDialog()
            // SEE EXPECTED VALUES ON THE PAGE
            ->assertSeeIn('@table-is-active-visa-'.$this->visa->id, 'ACTIVE')
            ->assertSee($visa_type)
            ->assertSee($entry_type)
            ->assertSee($number)
            ->assertSee($issue_date)
            ->assertSee($expiration_date)
            ->assertSee($entry_duration);
    }

    /**
     * Cancel the the visa.
     *
     * @param Browser $browser
     */
    public function cancelVisa(Browser $browser)
    {
        $browser
            ->assertSeeIn('@table-is-active-visa-'.$this->visa->id, 'ACTIVE')
            ->assertSee($this->visa->number)
            ->assertSee($this->visa->issue_date->format('Y-m-d'))
            ->assertSee($this->visa->expiration_date->format('Y-m-d'))
            ->click('@btn-cancel-visa-'.$this->visa->id)
            ->on($this)
            ->seeSuccessDialog()
            ->assertSeeIn('@table-is-active-visa-'.$this->visa->id, 'Cancelled');
    }

    /**
     * Delete the visa.
     *
     * @param Browser $browser
     */
    public function deleteVisa(Browser $browser)
    {
        $browser
            ->assertSeeIn('@table-is-active-visa-'.$this->visa->id, 'Cancelled')
            ->assertSee($this->visa->number)
            ->assertSee($this->visa->issue_date->format('Y-m-d'))
            ->assertSee($this->visa->expiration_date->format('Y-m-d'))
            ->click('@btn-delete-visa-'.$this->visa->id)
            ->on($this)
            ->seeSuccessDialog();

        PHPUnit::assertCount(0, $this->passport->visas);
    }
}
