<?php

namespace Tests\Browser\Pages;

use App\Position;
use Laravel\Dusk\Browser;

class PositionsIndex extends Page
{
    protected $position;

    /**
     * PositionsIndex constructor.
     * @param Position $position
     */
    public function __construct(Position $position = null)
    {
        parent::__construct();

        ! $position ?: $this->position = $position;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/position/index';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
            ->assertSee('Employee Positions - Index');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Show the table of positions.
     *
     * @param Browser $browser
     */
    public function showIndex(Browser $browser)
    {
        $browser
            ->searchTable('positions_table', $this->position->name)
            ->assertSee($this->position->name)
            ->assertSee($this->position->type->name)
            ->assertSee($this->position->school->name)
            ->assertSee($this->position->stipend)
            ->assertSee($this->position->supervisor->name);
    }

    /**
     * Show position details.
     *
     * @param Browser $browser
     */
    public function showPosition(Browser $browser)
    {
        $browser
            ->searchTable('positions_table', $this->position->name)
            ->click('@btn-show-'.$this->position->uuid)
            ->on(new PositionsView($this->position));
    }

    /**
     * Edit position details.
     *
     * @param Browser $browser
     */
    public function editPosition(Browser $browser)
    {
        $browser
            ->searchTable('positions_table', $this->position->name)
            ->click('@btn-edit-'.$this->position->uuid)
            ->on(new PositionsEdit($this->position));
    }

    /**
     * Archive position.
     *
     * @param Browser $browser
     */
    public function archivePosition(Browser $browser)
    {
        $browser
            ->searchTable('positions_table', $this->position->name)
            ->click('@btn-archive-'.$this->position->uuid)
            ->on(new PositionsIndex())
            ->seeSuccessDialog();
    }
}
