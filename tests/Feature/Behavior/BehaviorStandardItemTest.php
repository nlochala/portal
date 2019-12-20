<?php


namespace Tests\Feature\Behavior;

use App\BehaviorStandard;
use App\BehaviorStandardItem;
use App\Http\Requests\StoreBehaviorStandardItemRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class BehaviorStandardItemTest extends TestCase
{

    use ModelCrud;

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'behavior_standard_id',
            'name',
            'description',
            'value'
        ];

    /**
     * Return the store route and any needed uuid's
     *
     * @param array $uuid_array
     * @return string
     */
    protected function getStoreRoute($uuid_array = [])
    {
        return '/api/behavior/standard/' . $uuid_array['standard'] . '/ajaxstoreitem';
    }

    /**
     * Return the store route and any needed uuid's
     *
     * @param array $uuid_array
     * @return string
     */
    protected function getShowRoute($uuid_array = [])
    {
        return '/api/behavior/standard/' . $uuid_array['standard'] . '/ajaxshowitem';
    }

    /** @test */
    public function a_user_can_create_a_item()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $post_values = $this->prepareCreatePostValues(
            BehaviorStandardItem::class,
            $this->parameters,
            ['behavior_standard_id' => $standard->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandardItem::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('behavior_standard_items', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_item()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $model = factory(BehaviorStandardItem::class)->create(
            ['behavior_standard_id' => $standard->id]
        );
        $post_values = $this->prepareUpdatePostValues(
            BehaviorStandardItem::class,
            $this->parameters,
            $model->id,
            ['behavior_standard_id' => $standard->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandardItem::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('behavior_standard_items', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_items()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $models = factory(BehaviorStandardItem::class, 3)->create(
            ['behavior_standard_id' => $standard->id]
        );
        $response = $this->get($this->getShowRoute(['standard' => $standard->uuid]));

        foreach ($models as $model) {
            foreach ($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_item()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $model = factory(BehaviorStandardItem::class)->create(
            ['behavior_standard_id' => $standard->id]
        );
        static::assertNotNull(BehaviorStandardItem::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);

        $response->assertStatus(200);
        static::assertNull(BehaviorStandardItem::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_item()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $model = factory(BehaviorStandardItem::class)->create(
            ['behavior_standard_id' => $standard->id, 'is_protected' => true]
        );
        static::assertNotNull(BehaviorStandardItem::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);

        $response->assertStatus(200);
        static::assertNotNull(BehaviorStandardItem::find($model->id));
    }

    /** @test */
    public function a_new_item_has_default_parameters()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $post_values = $this->prepareCreatePostValues(
            BehaviorStandardItem::class,
            $this->parameters,
            ['behavior_standard_id' => $standard->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandardItem::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_item_has_default_parameters()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $model = factory(BehaviorStandardItem::class)->create(
            ['behavior_standard_id' => $standard->id]
        );
        $post_values = $this->prepareUpdatePostValues(
            BehaviorStandardItem::class,
            $this->parameters,
            $model->id,
            ['behavior_standard_id' => $standard->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = BehaviorStandardItem::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $standard = factory(BehaviorStandard::class)->create();
        $request = new StoreBehaviorStandardItemRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(BehaviorStandardItem::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->getStoreRoute(['standard' => $standard->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}

