<?php

namespace Tests\Browser;

use Throwable;
use App\Position;
use Laravel\Dusk\Browser;
use Tests\PortalBaseTestCase;
use Tests\Browser\Pages\PositionsEdit;
use Tests\Browser\Pages\PositionsView;
use Tests\Browser\Pages\PositionsIndex;
use Tests\Browser\Pages\PositionsCreate;

class EmployeePositionsCRUDTest extends PortalBaseTestCase
{
    /**
     * A position can be created.
     *
     * @test
     * @throws Throwable
     */
    public function a_position_can_be_created()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsCreate())
                ->createPosition()
                ->logout();
        });
    }

    /**
     * A position can be viewed.
     *
     * @test
     */
    public function a_position_can_be_viewed()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');
        $position = Position::all()->random(1)->first();

        $this->browse(function (Browser $browser) use ($position) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsView($position))
                ->viewPosition()
                ->archivePosition()
                ->logout();
        });
    }

    /**
     * a_position_can_be_edited.
     *
     * @test
     * @throws Throwable
     */
    public function a_position_can_be_edited()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');
        $position = Position::all()->random(1)->first();

        $this->browse(function (Browser $browser) use ($position) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsEdit($position))
                ->editPosition()
                ->logout();
        });
    }

    /**
     * view_index_of_positions.
     *
     * @test
     * @throws Throwable
     */
    public function view_index_of_positions()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');
        $position = Position::all()->random(1)->first();

        $this->browse(function (Browser $browser) use ($position) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsIndex($position))
                ->showIndex()
                ->logout();
        });
    }

    /**
     * view_index_of_positions.
     *
     * @test
     * @throws Throwable
     */
    public function view_index_of_positions_click_details()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');
        $position = Position::all()->random(1)->first();

        $this->browse(function (Browser $browser) use ($position) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsIndex($position))
                ->showPosition()
                ->logout();
        });
    }

    /**
     * Click edit button on position.
     *
     * @test
     * @throws Throwable
     */
    public function view_index_of_positions_click_edit()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');
        $position = Position::all()->random(1)->first();

        $this->browse(function (Browser $browser) use ($position) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsIndex($position))
                ->editPosition()
                ->logout();
        });
    }

    /**
     * view_index_of_positions.
     *
     * @test
     * @throws Throwable
     */
    public function view_index_of_positions_click_archive()
    {
        $this->artisan('db:seed --class=PositionsFakerTableSeeder');
        $position = Position::all()->random(1)->first();

        $this->browse(function (Browser $browser) use ($position) {
            $browser->loginAs($this->user->id)
                ->visit(new PositionsIndex($position))
                ->archivePosition()
                ->logout();
        });
    }
}
