<?php

namespace Tests\Browser\Pages;

use App\Year;
use Laravel\Dusk\Browser;
use App\Http\Requests\StoreYearRequest;

class YearDatatables extends Page
{
    protected $current_year;

    public function __construct(Year $year)
    {
        parent::__construct();
        $this->current_year = $year;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/year/index';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertPathIs($this->url())
            ->assertSee('The current school year is: '.$this->current_year->name);
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@btn-create' => '#year_table_wrapper > div.dt-buttons.btn-group > button.btn.btn-secondary.buttons-create.btn-sm.btn-hero-primary',
            '@form-modal' => 'body > div.modal.fade.DTED.show > div > div',
            '@form' => 'form[data-dte-e=form]',
            '@form-submit-btn' => 'body > div.modal.fade.DTED.show > div > div > div > div.DTE_Footer.modal-footer > div.DTE_Form_Buttons > button',
        ];
    }

    public function viewYears(Browser $browser)
    {
        $years = Year::all()->take(5);

        foreach ($years as $year) {
            $browser
                ->assertSee($year->start_date)
                ->assertSee($year->end_date)
                ->assertSee($year->year_start)
                ->assertSee($year->year_end);
        }
    }

    public function canSearch(Browser $browser)
    {
        $year = Year::all()->random(1)->first();
        $browser
            ->searchTable('year_table', $year->start_date)
            ->assertSee($year->start_date)
            ->assertSee($year->end_date)
            ->assertSee($year->year_start)
            ->assertSee($year->year_end);
    }
}
