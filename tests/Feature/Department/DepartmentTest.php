<?php


namespace Tests\Feature\Department;

use App\Department;
use App\Http\Requests\StoreDepartmentRequest;
use Tests\Feature\TestCase;
use Tests\Traits\ModelCrud;
use App\Helpers\DatabaseHelpers;

class DepartmentTest extends TestCase
{

    use ModelCrud;

    protected string $store_route = '/api/department/ajaxstoredepartment';
    protected string $show_route = '/api/department/ajaxshowdepartment';

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
    public function a_user_can_create_a_department()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Department::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Department::findOrFail($expected_values->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        // Check for database
        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('departments', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_edit_a_department()
    {
        $user = $this->signIn();

        $model = factory(Department::class)->create();
        $post_values = $this->prepareUpdatePostValues(Department::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Department::findOrFail($model->id);

        $response->assertStatus(200);
        static::assertCount(0, $parsed['errors']);

        foreach ($this->parameters as $parameter) {
            static::assertEquals($expected_values->$parameter, $model->$parameter);
            static::assertDatabaseHas('departments', [$parameter => $model->$parameter]);
        }
    }

    /** @test */
    public function a_user_can_see_departments()
    {
        $user = $this->signIn();

        $models = factory(Department::class, 3)->create();
        $response = $this->get($this->show_route);

        foreach ($models as $model) {
            foreach ($this->parameters as $parameter) {
                $response->assertSeeText($model->$parameter);
            }
        }
    }

    /** @test */
    public function a_user_can_delete_a_department()
    {
        $user = $this->signIn();

        $model = factory(Department::class)->create();
        static::assertNotNull(Department::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNull(Department::find($model->id));
    }

    /** @test */
    public function a_user_cannot_delete_a_protected_department()
    {
        $user = $this->signIn();

        $model = factory(Department::class)->create(['is_protected' => true]);
        static::assertNotNull(Department::find($model->id));

        $post_values = $this->getDeleteAjaxRequest([$model->id => 0]);
        $response = $this->post($this->store_route, $post_values);

        $response->assertStatus(200);
        static::assertNotNull(Department::find($model->id));
    }

    /** @test */
    public function a_new_department_has_default_parameters()
    {
        $user = $this->signIn();

        $post_values = $this->prepareCreatePostValues(Department::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Department::findOrFail($expected_values->id);
        static::assertTrue($model->exists);

        foreach ($this->global_create_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function an_updated_department_has_default_parameters()
    {
        $user = $this->signIn();

        $model = factory(Department::class)->create();
        $post_values = $this->prepareUpdatePostValues(Department::class, $this->parameters, $model->id);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);
        $expected_values = $parsed['model'][0];
        $model = Department::findOrFail($model->id);

        foreach ($this->global_update_parameters as $parameter) {
            static::assertNotNull($model->$parameter);
        }
    }

    /** @test */
    public function a_user_must_include_the_required_fields()
    {
        $user = $this->signIn();

        $request = new StoreDepartmentRequest();
        $rules = $request->rules();

        $post_values = $this->prepareValidationPostValues(Department::class, $this->parameters);

        // Send to controller
        $response = $this->post($this->store_route, $post_values);
        $parsed = $this->parseAjaxResponse($response);

        foreach ($rules as $field => $requirement) {
            static::assertStringContainsString($field, json_encode($parsed['errors']));
        }
    }
}

