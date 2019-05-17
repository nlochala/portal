<?php

namespace Tests\Browser;

use App\Year;
use Laravel\Dusk\Browser;
use Tests\PortalBaseTestCase;
use Tests\Browser\Pages\YearDatatables;

class YearCRUDTest extends PortalBaseTestCase
{
    /**
     * a_user_can_crud_school_years.
     *
     * @test
     */
    public function a_user_can_crud_school_years()
    {
        $current_school_year = Year::currentYear();

        $this->browse(function (Browser $browser) use ($current_school_year) {
            $browser->loginAs($this->user->id)
                ->visit(new YearDatatables($current_school_year))
                ->viewYears()
                ->canSearch()
                ->logout();
        });
    }
}
