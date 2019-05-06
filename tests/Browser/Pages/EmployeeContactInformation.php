<?php

namespace Tests\Browser\Pages;

use App\AddressType;
use App\Country;
use App\Employee;
use App\Http\Requests\StoreEmployeeAddressRequest;
use App\Http\Requests\StoreEmployeePhoneRequest;
use App\Phone;
use App\PhoneType;
use Facebook\WebDriver\Exception\TimeOutException;
use Illuminate\Support\Arr;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert as PHPUnit;

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
            '@phone_modal' => '#modal-block-phone',
        ];
    }

    /**
     * @param Browser $browser
     *
     * @throws TimeOutException
     */
    public function updateEmailAddresses(Browser $browser)
    {
        $test_email_primary = $this->faker->email;
        $test_email_secondary = $this->faker->email;
        $test_email_school = $this->faker->email;

        $browser->assertSee($this->employee->person->email_school)
            // GET MODAL
            ->click('@btn-modal-block-email')
            ->waitFor('@email_modal')
            // CHECK REQUIRED FIELDS
            ->submitForm('email-form')
            ->assertSee('field is required')
            // FILL OUT FORM
            ->type('email_primary', $test_email_primary)
            ->type('email_secondary', $test_email_secondary);

        // IF THE SCHOOL EMAIL IS SET IT NEEDS TO BE READONLY ON THE FORM
        if ($this->employee->person->email_school) {
            $input_attribute = $browser->attribute('input[name=email_school]', 'readonly');
            PHPUnit::assertEquals($input_attribute, 'true');
        } else {
            $browser->type('email_school', $test_email_school);
        }

        $browser->submitForm('email-form')
            ->waitForLocation($this->url())
            ->on(new EmployeeContactInformation($this->employee))
            // SEE SUCCESS
            ->seeSuccessDialog()
            // CONFIRM PERSISTENCE
            ->assertSee($test_email_primary)
            ->assertSee($test_email_secondary)
            ->assertSee($this->employee->person->email_school);
    }

    /**
     * Add a new phone number.
     *
     * @param Browser $browser
     *
     * @throws TimeOutException
     */
    public function addPhoneNumber(Browser $browser)
    {
        $phone_number = $this->faker->randomNumber(5).$this->faker->randomNumber(6);
        $extension = $this->faker->randomNumber(3);
        $phone_type = Arr::random(PhoneType::getDropdown());
        $country_code = Arr::random(Country::getCountryCodeDropdown());

        $form_request = new StoreEmployeePhoneRequest();

        $browser->click('@btn-modal-block-phone')
            ->waitFor('@phone_modal')
            ->submitForm('phone-form')
            ->assertHasRequiredInputErrors($form_request)
            ->selectDropdown('phone_type_id', $phone_type)
            ->selectDropdown('country_id_phone', $country_code)
            ->type('number', $phone_number)
            ->type('extension', $extension)
            ->submitForm('phone-form')
            ->waitForLocation($this->url())
            ->on(new EmployeeContactInformation($this->employee))
            // SEE SUCCESS
            ->seeSuccessDialog()
            ->assertSee($phone_number)
            ->assertSee($extension)
            ->assertSee($phone_type)
            ->assertSee($country_code);
    }

    /**
     * Delete a given phone number.
     *
     * @param Browser $browser
     * @throws TimeOutException
     */
    public function deletePhoneNumber(Browser $browser)
    {
        $phone_model = $this->employee->person->phones[0];
        $browser->click('@btn-delete-phone-'.$phone_model->uuid)
            ->waitForLocation($this->url())
            ->on(new EmployeeContactInformation($this->employee))
            ->seeSuccessDialog();

        PHPUnit::assertNull(Phone::find($phone_model->id));
    }

    /**
     * Create a new address.
     *
     * @param Browser $browser
     */
    public function addAddress(Browser $browser)
    {
        // FORM FAKER FIELDS
        $address_type = Arr::random(AddressType::getDropdown());
        $address_line_1 = $this->faker->streetAddress;
        $address_line_2 = 'Attn: '.$this->faker->name;
        $city = $this->faker->city;
        $province = strtoupper($this->faker->lexify('??'));
        $postal_code = $this->faker->postcode;
        $country = Arr::random(Country::getDropdown());

        // FORM REQUEST
        $form_request = new StoreEmployeeAddressRequest();
        $excluded_ids = [];

        // VIEW FORM (IF MODAL)
        $browser->clickButton('btn-modal-block-address-new')
            ->waitFor('#modal-block-address-new')
            // TEST FOR VALIDATION MESSAGES
            ->submitForm('address-form')
            ->assertHasRequiredInputErrors($form_request, $excluded_ids)
            // FILL IN FORM
            ->selectDropdown('address_type_id', $address_type)
            ->type('address_line_1', $address_line_1)
            ->type('address_line_2', $address_line_2)
            ->type('city', $city)
            ->type('province', $province)
            ->type('postal_code', $postal_code)
            ->selectDropdown('country_id', $country)
            // SUBMIT FORM
            ->submitForm('address-form')
            ->waitForLocation($this->url())
            ->on(new EmployeeContactInformation($this->employee))
            // SEE SUCCESS
            ->seeSuccessDialog()
            ->assertSee($address_type)
            ->assertSee($address_line_1)
            ->assertSee($address_line_2)
            ->assertSee($city)
            ->assertSee($province)
            ->assertSee($postal_code)
            ->assertSee($country);
    }

    /**
     * Edit the employee's address.
     *
     * @param Browser $browser
     */
    public function editAddress(Browser $browser)
    {
        $address_model = $this->employee->person->addresses[0];

        // FORM FAKER FIELDS
        $address_type = Arr::random(AddressType::getDropdown());
        $address_line_1 = $this->faker->streetAddress;
        $address_line_2 = 'Attn: '.$this->faker->name;
        $city = $this->faker->city;
        $province = strtoupper($this->faker->lexify('??'));
        $postal_code = $this->faker->postcode;
        $country = Arr::random(Country::getDropdown());

        // ADDRESS MODEL
        $browser->clickButton('btn-modal-block-address-'.$address_model->id)
            ->waitFor('#modal-block-address-'.$address_model->id);

        // FILL IN FORM
        $browser->selectDropdown('address_type_id_'.$address_model->id, $address_type)
            ->type('div[id=modal-block-address-'.$address_model->id.'] #address_line_1', $address_line_1)
            ->type('div[id=modal-block-address-'.$address_model->id.'] #address_line_2', $address_line_2)
            ->type('div[id=modal-block-address-'.$address_model->id.'] #city', $city)
            ->type('div[id=modal-block-address-'.$address_model->id.'] #province', $province)
            ->type('div[id=modal-block-address-'.$address_model->id.'] #postal_code', $postal_code)
            ->selectDropdown('country_id_'.$address_model->id, $country)
            // SUBMIT FORM
            ->submitForm('address-update-form')
            ->waitForLocation($this->url())
            ->on(new EmployeeContactInformation($this->employee))
            // SEE SUCCESS
            ->seeSuccessDialog()
            ->assertSee($address_type)
            ->assertSee($address_line_1)
            ->assertSee($address_line_2)
            ->assertSee($city)
            ->assertSee($province)
            ->assertSee($postal_code)
            ->assertSee($country);
    }

    /**
     * Delete the given address.
     *
     * @param Browser $browser
     */
    public function deleteAddress(Browser $browser)
    {
        $address_model = $this->employee->person->addresses[0];
        $browser->clickButton('btn-delete-address-'.$address_model->uuid)
            ->waitForLocation($this->url())
            ->on(new EmployeeContactInformation($this->employee))
            // SEE SUCCESS
            ->seeSuccessDialog();
    }
}
