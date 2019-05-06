<?php

/** @noinspection PhpMethodNamingConventionInspection */

namespace Tests\Browser;

use App\Passport;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EmployeeContactInformation;
use Tests\Browser\Pages\EmployeeCreateIdCard;
use Tests\Browser\Pages\EmployeeCreatePassport;
use Tests\Browser\Pages\EmployeeCreateVisa;
use Tests\Browser\Pages\EmployeeIdCard;
use Tests\Browser\Pages\EmployeeOfficialDocuments;
use Tests\Browser\Pages\EmployeePassport;
use Tests\Browser\Pages\EmployeeProfile;
use Tests\Browser\Pages\EmployeeUpdateIdCard;
use Tests\Browser\Pages\EmployeeVisa;
use Tests\PortalBaseTestCase;
use Throwable;

class EmployeeProfileTest extends PortalBaseTestCase
{
    /**
     * An employee can see and change their profile.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_see_and_change_their_profile()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeProfile($this->person->employee))
                ->submitProfileForm()
                ->submitProfilePicture()
                ->logout();
        });
    }


    /**
     * An employee can see and change their contact information.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_see_and_change_their_email_address()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeContactInformation($this->person->employee))
                ->updateEmailAddresses()
                ->logout();
        });
    }

    /**
     * An employee can see and change their contact information.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_see_and_change_their_phone_number()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeContactInformation($this->person->employee))
                ->addPhoneNumber()
                ->deletePhoneNumber()
                ->logout();
        });
    }

    /**
     * An employee can see and change their contact information.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_see_and_change_their_address()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeContactInformation($this->person->employee))
                ->addAddress()
                ->editAddress()
                ->deleteAddress()
                ->logout();
        });
    }

    /**
     * An employee can create a passport.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_create_a_passport()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeCreatePassport($this->person->employee))
                ->createPassport()
                ->logout();
        });
    }

    /**
     * An employee can see and change their visas.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_edit_their_passport()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeePassport($this->person->employee, true))
                ->updatePassport()
                ->logout();
        });
    }

    /**
     * An employee can see and change their passports.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_delete_and_cancel_passports()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeePassport($this->person->employee, true))
                ->cancelPassport()
                ->deletePassport()
                ->logout();
        });
    }

    /**
     * An employee can create a visa.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_create_a_visa()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeCreateVisa($this->person->employee))
                ->createVisa()
                ->logout();
        });
    }

    /**
     * An employee can see and change their visas.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_edit_their_visa()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeVisa($this->person->employee))
                ->updateVisa()
                ->logout();
        });
    }

    /**
     * An employee can see and change their visas.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_delete_and_cancel_visas()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeVisa($this->person->employee))
                ->cancelVisa()
                ->deleteVisa()
                ->logout();
        });
    }

    /**
     * An employee can create an ID Card.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_create_an_id_card()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeCreateIdCard($this->person->employee))
                ->createCard()
                ->logout();
        });
    }

    /**
     * An employee can update an ID Card.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_update_an_id_card()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeIdCard($this->person->employee))
                ->updateIdCard()
                ->visit(new EmployeeUpdateIdCard($this->person->employee))
                ->updateIdCard()
                ->logout();
        });
    }

    /**
     * An employee can cancel and delete an ID Card.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_cancel_and_delete_an_id_card()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeIdCard($this->person->employee))
                ->cancelIdCard()
                ->deleteIdCard()
                ->logout();
        });
    }

    /**
     * An employee can create official documents.
     *
     * @test
     */
    public function an_employee_can_create_official_documents()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeOfficialDocuments($this->person->employee))
                ->createOfficialDocument()
                ->logout();
        });
    }

    /**
     * An employee can delete an official documents.
     *
     * @test
     */
    public function an_employee_can_delete_an_official_documents()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new EmployeeOfficialDocuments($this->person->employee))
                ->deleteOfficialDocument()
                ->logout();
        });
    }
}
