<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Position;
use Laravel\Dusk\Browser;

class EmployeePositionDetails extends Page
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
        return '/employee/'.$this->employee->uuid.'/position/view_details';
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
            ->assertSee($this->employee->person->preferredName()."'s Position Details");
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
     * When there are no positions added to an employee.
     *
     * @param Browser $browser
     */
    public function noPositionsAdded(Browser $browser)
    {
        if ($this->employee->positions->isEmpty()) {
            $browser
                ->assertSee('This employee does not have any positions assigned to them, yet.');
        }
    }

    /**
     * Show position details.
     *
     * @param Browser $browser
     */
    public function showPositions(Browser $browser)
    {
        $positions = Position::all()->random(4);
        $this->employee->positions()->sync($positions);

        $browser
            ->refresh();

        foreach ($positions as $position) {
            $browser
                ->within('@panel-table-of-contents', function (Browser $browser) use ($position) {
                    $browser->assertSeeLink($position->name);
                })
                ->assertSee($position->name)
                ->assertSee($position->description)
                ->assertSee($position->type->name)
                ->assertSee($position->school->name)
                ->assertSee($position->stipend);
        }
    }
}
