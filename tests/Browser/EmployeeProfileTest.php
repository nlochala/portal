<?php

/** @noinspection PhpMethodNamingConventionInspection */

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EmployeeContactInformation;
use Tests\Browser\Pages\EmployeeProfile;
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
                ->submitProfilePicture('pond');
        });
    }

    /**
     * An employee can see and change their contact information.
     *
     * @test
     *
     * @throws Throwable
     */
    public function an_employee_can_see_and_change_their_contact_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new EmployeeContactInformation($this->person->employee))
                ->updateEmailAddresses();
        });
    }
}
