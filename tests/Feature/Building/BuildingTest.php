<?php

namespace Tests\Feature\Building;

use App\Building;
use App\Http\Requests\StoreBuildingRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class BuildingTest extends TestCase
{

    use ModelCrud;

    protected string $store_route = '/api/building/ajaxstorebuilding';
    protected string $show_route = '/api/building/ajaxshowbuilding';

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'short_name',
            'name',
        ];

    /** @test */
    public function a_user_can_create_a_building()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Building::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Building::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('buildings', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_building()
    {
        $user = $this->signIn();

        $model = factory(Building::class)->create();
        $post_values = $this->prepareUpdatePostValues(Building::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Building::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('buildings', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_buildings()
    {
        $user = $this->signIn();

        $models = factory(Building::class, 3)->create();
        $response = $this->get($this->show_route);

        foreach($models as $model) {
            foreach($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_building()
    {
        $user = $this->signIn();

        $model = factory(Building::class)->create();
        static::assertNotNull(Building::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNull(Building::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_building()
    {
        $user = $this->signIn();

        $model = factory(Building::class)->create(['is_protected' => true]);
        static::assertNotNull(Building::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNotNull(Building::find($model->id));
    }

    /** @test */
    public function a_new_building_has_default_parameters()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Building::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Building::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_building_has_default_parameters()
    {
        $user = $this->signIn();

        $model = factory(Building::class)->create();
        $post_values = $this->prepareUpdatePostValues(Building::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Building::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $request = new StoreBuildingRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(Building::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}
