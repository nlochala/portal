<?php

namespace Tests\Browser\Pages;

use App\School;
use App\Position;
use App\PositionType;
use Laravel\Dusk\Browser;
use Illuminate\Support\Arr;
use App\Http\Requests\StorePositionRequest;

class PositionsCreate extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/position/create';
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
            ->assertSee('New Position');
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

    public function createPosition(Browser $browser)
    {
        // FORM FAKER FIELDS
        $name = $this->faker->words(4, true);
        $position_type = Arr::random(PositionType::getDropdown());
        $school = Arr::random(School::getDropdown());
        $supervisor_position = Arr::random(Position::getDropdown());
        $stipend = $this->faker->randomNumber(1).'000';
        $description = implode(' ', $this->faker->paragraphs(4));

        // FORM REQUEST
        $form_request = new StorePositionRequest(); // REQUEST CLASS
        $excluded_ids = [];

        $browser
            // TEST FOR VALIDATION MESSAGES
            ->submitForm('position-form')
            ->assertHasRequiredInputErrors($form_request, $excluded_ids)

            // FILL IN FORM
            ->type('name', $name)
            ->selectDropdown('position_type_id', $position_type)
            ->selectRadio($school)
            ->selectDropdown('supervisor_position_id', $supervisor_position)
            ->type('stipend', $stipend)
            ->textArea('description', $description)

            // SUBMIT FORM
            ->submitForm('position-form');

        $position = Position::all()->last();

        $browser
            ->on(new PositionsView($position))

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
