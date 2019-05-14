<?php

namespace Tests\Browser\Pages;

use App\Position;
use Laravel\Dusk\Browser;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase as PHPUnit;

class PositionsView extends Page
{
    protected $position;

    /**
     * PositionsIndex constructor.
     * @param $position
     */
    public function __construct($position)
    {
        parent::__construct();
        $this->position = $position->fresh();
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/position/'.$this->position->uuid;
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
            ->assertSeeIn('@panel-'.Str::slug($this->position->name), $this->position->name);
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
     * See the expected position.
     *
     * @param Browser $browser
     */
    public function viewPosition(Browser $browser)
    {
        $browser
            ->assertSee($this->position->name)
            ->assertSee($this->position->type->name)
            ->assertSee($this->position->school->name)
            ->assertSee($this->position->stipend)
            ->assertSee($this->position->description)
            ->assertSee($this->position->supervisor->name);
    }

    /**
     * Archive the given position.
     *
     * @param Browser $browser
     */
    public function archivePosition(Browser $browser)
    {
        PHPUnit::assertNotNull(Position::find($this->position->id));

        $browser
            ->click('@btn-archive-'.$this->position->id)
            ->on(new PositionsIndex())
            ->seeSuccessDialog();

        PHPUnit::assertNull(Position::find($this->position->id));
    }

    /**
     * Initiate and edit on a position.
     *
     * @param Browser $browser
     */
    public function editPosition(Browser $browser)
    {
        $browser
            ->click('@btn-edit-'.$this->position->id)
            ->on(new PositionsEdit($this->position));
    }
}
