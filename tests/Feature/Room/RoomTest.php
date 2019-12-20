<?php


namespace Tests\Feature\Room;

use App\Room;
use App\Http\Requests\StoreRoomRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class RoomTest extends TestCase
{

    use ModelCrud;

    protected string $store_route = '/api/room/ajaxstoreroom';
    protected string $show_route = '/api/room/ajaxshowroom';

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'number',
            'description',
            'room_type_id',
            'building_id',
            'phone_extension',
        ];

    /** @test */
    public function a_user_can_create_a_room()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Room::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Room::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('rooms', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_room()
    {
        $user = $this->signIn();

        $model = factory(Room::class)->create();
        $post_values = $this->prepareUpdatePostValues(Room::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Room::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('rooms', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_rooms()
    {
        $user = $this->signIn();

        $models = factory(Room::class, 3)->create();
        $response = $this->get($this->show_route);

        foreach ($models as $model) {
            foreach ($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_room()
    {
        $user = $this->signIn();

        $model = factory(Room::class)->create();
        static::assertNotNull(Room::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNull(Room::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_room()
    {
        $user = $this->signIn();

        $model = factory(Room::class)->create(['is_protected' => true]);
        static::assertNotNull(Room::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNotNull(Room::find($model->id));
    }

    /** @test */
    public function a_new_room_has_default_parameters()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Room::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Room::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_room_has_default_parameters()
    {
        $user = $this->signIn();

        $model = factory(Room::class)->create();
        $post_values = $this->prepareUpdatePostValues(Room::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Room::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $request = new StoreRoomRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(Room::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            if ($requirement !== 'required') {
                continue;
            }

            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}

