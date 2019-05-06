<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Helpers\TestHelpers;
use App\IdCard;
use Carbon\Carbon;
use Laravel\Dusk\Browser;

class EmployeeUpdateIdCard extends Page
{
    protected $employee;
    protected $idCard;

    /**
     * EmployeeProfile constructor.
     *
     * @param Employee $employee
     * @param IdCard   $id_card
     */
    public function __construct(Employee $employee, IdCard $id_card = null)
    {
        parent::__construct();
        $this->employee = $employee;

        if ($id_card) {
            $this->idCard = $id_card;
        } else {
            $this->idCard = factory(IdCard::class)->create([
                'person_id' => $this->employee->person->id,
                'front_image_file_id' => TestHelpers::getSampleImage()->id,
                'back_image_file_id' => TestHelpers::getSampleImage()->id,
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
        return '/employee/'.$this->employee->uuid.'/id_card/'.$this->idCard->uuid.'/update_id_card';
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
            ->assertSee('ID Card #xxxxxx'.substr($this->idCard->number, -4));
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
     * Edit the ID Card.
     *
     * @param Browser $browser
     */
    public function updateIdCard(Browser $browser)
    {
        // FORM FAKER FIELDS
        $is_active = 'Active';
        $name = '王大山';
        $number = $this->faker->randomNumber(8).
            $this->faker->randomNumber(8);
        $issue_date = Carbon::now()->subMonths(6)->format('Y-m-d');
        $expiration_date = Carbon::now()->addMonths(30)->format('Y-m-d');

        $browser
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
            ->on(new EmployeeIdCard($this->employee, $this->idCard))
            // SEE SUCCESS
            ->seeSuccessDialog()
            // SEE EXPECTED VALUES ON THE PAGE
            ->assertSee($issue_date)
            ->assertSee($expiration_date)
            ->assertSee($name)
            ->assertSee($number);
    }
}
