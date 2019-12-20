<?php


namespace Tests\Feature\Behavior;

use App\BehaviorStandard;
use App\Http\Requests\StoreBehaviorStandardRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class BehaviorStandardTest extends TestCase
{

    use ModelCrud;

    protected string $store_route = '/api/behavior/standard/ajaxstorestandard';
    protected string $show_route = '/api/behavior/standard/ajaxshowstandard';

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'name',
            'description'
        ];

    /** @test */
    public function a_user_can_create_a_behavior_standard()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(BehaviorStandard::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandard::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('behavior_standards', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_behavior_standard()
    {
        $user = $this->signIn();

        $model = factory(BehaviorStandard::class)->create();
        $post_values = $this->prepareUpdatePostValues(BehaviorStandard::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandard::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('behavior_standards', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_behavior_standards()
    {
        $user = $this->signIn();

        $models = factory(BehaviorStandard::class, 3)->create();
        $response = $this->get($this->show_route);

        foreach ($models as $model) {
            foreach ($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_behavior_standard()
    {
        $user = $this->signIn();

        $model = factory(BehaviorStandard::class)->create();
        static::assertNotNull(BehaviorStandard::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNull(BehaviorStandard::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_behavior_standard()
    {
        $user = $this->signIn();

        $model = factory(BehaviorStandard::class)->create(['is_protected' => true]);
        static::assertNotNull(BehaviorStandard::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNotNull(BehaviorStandard::find($model->id));
    }

    /** @test */
    public function a_new_behavior_standard_has_default_parameters()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(BehaviorStandard::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandard::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_behavior_standard_has_default_parameters()
    {
        $user = $this->signIn();

        $model = factory(BehaviorStandard::class)->create();
        $post_values = $this->prepareUpdatePostValues(BehaviorStandard::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandard::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $request = new StoreBehaviorStandardRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(BehaviorStandard::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}

