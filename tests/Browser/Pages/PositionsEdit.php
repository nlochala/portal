<?php

namespace Tests\Browser\Pages;

use App\School;
use App\Position;
use App\PositionType;
use Laravel\Dusk\Browser;
use Illuminate\Support\Arr;

class PositionsEdit extends Page
{
    protected $position;

    /**
     * PositionsEdit constructor.
     * @param $position
     */
    public function __construct($position)
    {
        parent::__construct();
        $this->position = $position;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/position/'.$this->position->uuid.'/edit';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertPathIs($this->url())
            ->assertSee($this->position->name);
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
     * Edit a given position.
     *
     * @param Browser $browser
     */
    public function editPosition(Browser $browser)
    {
        $name = $this->faker->words(4, true);
        $position_type = Arr::random(PositionType::getDropdown());
        $school = Arr::random(School::getDropdown());
        $supervisor_position = Arr::random(Position::getDropdown());
        $stipend = $this->faker->randomNumber(1).'000';
        $description = implode(' ', $this->faker->paragraphs(4));

        $browser
            // FILL IN FORM
            ->type('name', $name)
            ->selectDropdown('position_type_id', $position_type)
            ->selectRadio($school)
            ->selectDropdown('supervisor_position_id', $supervisor_position)
            ->type('stipend', $stipend)
            ->textArea('description', $description)

            // SUBMIT FORM
            ->submitForm('position-form')
            ->on(new PositionsView($this->position))

            // SEE SUCCESS
            ->seeSuccessDialog()

            // SEE EXPECTED VALUES ON THE PAGE
            ->assertSee($name)
            ->assertSee($position_type)
            ->assertSee($school)
            ->assertSee($stipend)
            ->assertSee($description);
    }
}
