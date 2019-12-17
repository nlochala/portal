<?php


namespace Tests\Feature\Year;

use App\Year;
use App\Http\Requests\StoreYearRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class YearTest extends TestCase
{

    use ModelCrud;

    protected string $store_route = '/api/year/ajaxstoreyear';
    protected string $show_route = '/api/year/ajaxshowyear';

    /**
     * Parameters expected to be filled by the form.
     *
     * @var array
     */
    protected array $parameters =
        [
            'year_start',
            'year_end',
            'start_date',
            'end_date',
        ];

    /** @test */
    public function a_user_can_create_a_year()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Year::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Year::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('years', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_year()
    {
        $user = $this->signIn();

        $model = factory(Year::class)->create();
        $post_values = $this->prepareUpdatePostValues(Year::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Year::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('years', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_years()
    {
        $user = $this->signIn();

        $models = factory(Year::class, 3)->create();
        $response = $this->get($this->show_route);

        foreach ($models as $model) {
            foreach ($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_year()
    {
        $user = $this->signIn();

        $model = factory(Year::class)->create();
        static::assertNotNull(Year::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNull(Year::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_year()
    {
        $user = $this->signIn();

        $model = factory(Year::class)->create(['is_protected' => true]);
        static::assertNotNull(Year::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNotNull(Year::find($model->id));
    }

    /** @test */
    public function a_new_year_has_default_parameters()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Year::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Year::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_year_has_default_parameters()
    {
        $user = $this->signIn();

        $model = factory(Year::class)->create();
        $post_values = $this->prepareUpdatePostValues(Year::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Year::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $request = new StoreYearRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(Year::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }

}

