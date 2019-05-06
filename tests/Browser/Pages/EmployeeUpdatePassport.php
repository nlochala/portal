<?php

namespace Tests\Browser\Pages;

use App\Country;
use App\Employee;
use App\Helpers\TestHelpers;
use App\Passport;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\TestCase as PHPUnit;

class EmployeeUpdatePassport extends Page
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
        return '/employee/'.$this->employee->uuid.'/passport/'.$this->passport->uuid.'/update_passport';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
        ->assertSee('Update Passport (#'.$this->passport->number.')');
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
     * Update a passport.
     *
     * @param Browser $browser
     */
    public function updatePassport(Browser $browser)
    {
        // FORM FAKER FIELDS
        $country = Arr::random(Country::getDropdown());
        $family_name = $this->faker->lastName;
        $given_name = $this->faker->firstNameMale;
        $number = $this->faker->randomNumber(7);
        $issue_date = Carbon::now()->subMonths(3)->format('Y-m-d');
        $expiration_date = Carbon::now()->addMonths(32)->format('Y-m-d');

        $browser
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

        PHPUnit::assertEquals(1, $this->employee->person->passports->count());
    }
}
