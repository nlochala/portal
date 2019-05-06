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

class EmployeeCreateVisa extends Page
{
    protected $employee;
    protected $passport;

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
     * Create a visa.
     *
     * @param Browser $browser
     *
     * @throws TimeOutException
     */
    public function createVisa(Browser $browser)
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
            ->click('@btn-modal-block-visa-form-'.$this->passport->id)
            ->waitFor('@modal-block-visa-form-'.$this->passport->id)
            ->assertSeeIn('@modal-block-visa-form-'.$this->passport->id,
                'New Visa for Passport (#'.$this->passport->number.')')
            // FILL IN FORM
            ->selectDropdown('is_active__'.$this->passport->id, $is_active)
            ->selectDropdown('visa_type_id__'.$this->passport->id, $visa_type)
            ->selectDropdown('visa_entry_id__'.$this->passport->id, $entry_type)
            ->type('number', $number)
            ->type('entry_duration', $entry_duration)
            ->selectDate('issue_date__'.$this->passport->id, $issue_date)
            ->selectDate('expiration_date__'.$this->passport->id, $expiration_date)
            ->uploadFile('upload')
            // SUBMIT FORM
            ->submitForm('visa-form-'.$this->passport->id)
            ->on($this)
            // SEE SUCCESS
            ->seeSuccessDialog();
        // SEE EXPECTED VALUES ON THE PAGE
        $visa = $this->passport->visas->first();

        $browser
            ->assertSeeIn('@table-is-active-visa-'.$visa->id, 'ACTIVE')
            ->assertSee($visa_type)
            ->assertSee($entry_type)
            ->assertSee($number)
            ->assertSee($issue_date)
            ->assertSee($expiration_date)
            ->assertSee($entry_duration);
    }
}
