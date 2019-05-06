<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Helpers\TestHelpers;
use App\IdCard;
use Laravel\Dusk\Browser;

class EmployeeIdCard extends Page
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
        return '/employee/'.$this->employee->uuid.'/id_card';
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
            ->assertSee($this->employee->person->preferredName()."'s ID Cards");
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

    public function updateIdCard(Browser $browser)
    {
        $browser
            ->click('@btn-update-id-card-'.$this->idCard->id)
            ->on(new EmployeeUpdateIdCard($this->employee, $this->idCard))
            ->assertSee('ID Card #xxxxxx'.substr($this->idCard->number, -4));

    }

    /**
     * Cancel ID Card.
     *
     * @param Browser $browser
     */
    public function cancelIdCard(Browser $browser)
    {
        $browser
            ->assertSeeIn('@btn-id-card-status-'.$this->idCard->id, 'ACTIVE')
            ->assertSee($this->idCard->number)
            ->assertSee($this->idCard->issue_date->format('Y-m-d'))
            ->assertSee($this->idCard->expiration_date->format('Y-m-d'))
            ->click('@btn-cancel-id-card-'.$this->idCard->id)
            ->on($this)
            ->seeSuccessDialog()
            ->assertSeeIn('@btn-id-card-status-'.$this->idCard->id, 'CANCELLED');
    }

    /**
     * Delete ID Card.
     *
     * @param Browser $browser
     */
    public function deleteIdCard(Browser $browser)
    {
        $browser
            ->assertSeeIn('@btn-id-card-status-'.$this->idCard->id, 'CANCELLED')
            ->assertSee($this->idCard->number)
            ->assertSee($this->idCard->issue_date->format('Y-m-d'))
            ->assertSee($this->idCard->expiration_date->format('Y-m-d'))
            ->click('@btn-delete-id-card-'.$this->idCard->id)
            ->on(new EmployeeCreateIdCard($this->employee));
    }
}
