<?php

namespace Tests\Browser\Pages;

use App\Country;
use App\Employee;
use App\Http\Requests\StoreEmployeePassportRequest;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laravel\Dusk\Browser;

class EmployeeCreatePassport extends Page
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
        return '/employee/'.$this->employee->uuid.'/create_passport';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertSee('Add New Passport');
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
     * Create a passport.
     *
     * @param Browser $browser
     */
    public function createPassport(Browser $browser)
    {
        // FORM FAKER FIELDS
        $country = Arr::random(Country::getDropdown());
        $family_name = $this->faker->lastName;
        $given_name = $this->faker->firstNameMale;
        $number = $this->faker->randomNumber(7);
        $issue_date = Carbon::now()->subMonths(3)->format('Y-m-d');
        $expiration_date = Carbon::now()->addMonths(32)->format('Y-m-d');

        // FORM REQUEST
        $form_request = new StoreEmployeePassportRequest();
        // is_active is selected by default. We won't see an error there.
        $excluded_ids = ['upload', 'is_active'];

        $browser
            // TEST FOR VALIDATION MESSAGES
            ->submitForm('passport-form')
            ->assertHasRequiredInputErrors($form_request, $excluded_ids)
            // FILL IN FORM
            ->selectDropdown('country_id', $country)
            ->type('family_name', $family_name)
            ->type('given_name', $given_name)
            ->type('number', $number)
            ->selectDate('issue_date', $issue_date)
            ->selectDate('expiration_date', $expiration_date)
            ->uploadFile('upload', url('/storage/sample-passport.jpg'))
//             SUBMIT FORM
            ->submitForm('passport-form')
            ->on(new EmployeePassport($this->employee))
//             SEE SUCCESS
            ->seeSuccessDialog()
//             SEE EXPECTED VALUES ON THE PAGE
            ->assertSee($country)
            ->assertSee($family_name)
            ->assertSee($given_name)
            ->assertSee($number)
            ->assertSee($issue_date)
            ->assertSee($expiration_date);
    }
}
