<?php


namespace Tests\Feature\Room;

use App\RoomType;
use App\Http\Requests\StoreRoomTypeRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class RoomTypeTest extends TestCase
{

    use ModelCrud;

    protected string $store_route = '/api/room_type/ajaxstoreroom_type';
    protected string $show_route = '/api/room_type/ajaxshowroom_type';

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'name',
            'description',
        ];

    /** @test */
    public function a_user_can_create_a_room_type()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(RoomType::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = RoomType::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('room_types', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_room_type()
    {
        $user = $this->signIn();

        $model = factory(RoomType::class)->create();
        $post_values = $this->prepareUpdatePostValues(RoomType::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = RoomType::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('room_types', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_room_types()
    {
        $user = $this->signIn();

        $models = factory(RoomType::class, 3)->create();
        $response = $this->get($this->show_route);

        foreach ($models as $model) {
            foreach ($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_room_type()
    {
        $user = $this->signIn();

        $model = factory(RoomType::class)->create();
        static::assertNotNull(RoomType::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNull(RoomType::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_room_type()
    {
        $user = $this->signIn();

        $model = factory(RoomType::class)->create(['is_protected' => true]);
        static::assertNotNull(RoomType::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNotNull(RoomType::find($model->id));
    }

    /** @test */
    public function a_new_room_type_has_default_parameters()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(RoomType::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = RoomType::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_room_type_has_default_parameters()
    {
        $user = $this->signIn();

        $model = factory(RoomType::class)->create();
        $post_values = $this->prepareUpdatePostValues(RoomType::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = RoomType::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $request = new StoreRoomTypeRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(RoomType::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}

