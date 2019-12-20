<?php


namespace Tests\Feature\Calendar;

use App\Year;
use App\Quarter;
use App\Http\Requests\StoreQuarterRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class QuarterTest extends TestCase
{

    use ModelCrud;

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'name',
            'year_id',
            'instructional_days',
            'start_date',
            'end_date',
        ];

    /**
     * Return the store route and any needed uuid's
     *
     * @param array $uuid_array
     * @return string
     */
    protected function getStoreRoute($uuid_array = [])
    {
        return '/api/quarter/ajaxstorequarter';
    }

    /**
     * Return the store route and any needed uuid's
     *
     * @param array $uuid_array
     * @return string
     */
    protected function getShowRoute($uuid_array = [])
    {
        return '/api/quarter/ajaxshowquarter';
    }

    /** @test */
    public function a_user_can_create_a_item()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $post_values = $this->prepareCreatePostValues(
            Quarter::class,
            $this->parameters,
            ['year_id' => $year->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Quarter::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('quarters', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_item()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $model = factory(Quarter::class)->create(
            ['year_id' => $year->id]
        );
        $post_values = $this->prepareUpdatePostValues(
            Quarter::class,
            $this->parameters,
            $model->id,
            ['year_id' => $year->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['year' => $year->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Quarter::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('quarters', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_items()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $models = factory(Quarter::class, 3)->create(
            ['year_id' => $year->id]
        );

        $response = $this->get($this->getShowRoute(['year' => $year->uuid]));

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

        $year = factory(Year::class)->create();
        $model = factory(Quarter::class)->create(
            ['year_id' => $year->id]
        );
        static::assertNotNull(Quarter::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->getStoreRoute(['year' => $year->uuid]), $post_values);

        $response->assertStatus(200);
        static::assertNull(Quarter::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_item()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $model = factory(Quarter::class)->create(
            ['year_id' => $year->id, 'is_protected' => true]
        );
        static::assertNotNull(Quarter::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->getStoreRoute(['year' => $year->uuid]), $post_values);

        $response->assertStatus(200);
        static::assertNotNull(Quarter::find($model->id));
    }

    /** @test */
    public function a_new_item_has_default_parameters()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $post_values = $this->prepareCreatePostValues(
            Quarter::class,
            $this->parameters,
            ['year_id' => $year->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['year' => $year->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Quarter::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_item_has_default_parameters()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $model = factory(Quarter::class)->create(
            ['year_id' => $year->id]
        );
        $post_values = $this->prepareUpdatePostValues(
            Quarter::class,
            $this->parameters,
            $model->id,
            ['year_id' => $year->id]
        );

        // Send to controller
        $response = $this->post($this->getStoreRoute(['year' => $year->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Quarter::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $year = factory(Year::class)->create();
        $request = new StoreQuarterRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(Quarter::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->getStoreRoute(['year' => $year->uuid]), $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}

