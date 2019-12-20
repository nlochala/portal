<?php

namespace Tests\Traits;

use App\User;
use Illuminate\Foundation\Testing\TestResponse;

trait ModelCrud
{
    /**
     * These are the parameters that will always be
     * present when an entry is written into the DB.
     *
     * @var array
     */
    protected array $global_create_parameters =
        [
            'uuid',
            'created_at',
            'user_created_id',
            'user_created_ip',
        ];

    /**
     * These are the parameters that will always be
     * present when an entry is updated in the DB.
     *
     * @var array
     */
    protected array $global_update_parameters =
        [
            'updated_at',
            'user_updated_id',
            'user_updated_ip',
        ];

    /**
     * @param $values
     * @return array
     */
    protected function getCreateAjaxRequest(array $values)
    {
        return
            [
                'action' => 'create',
                'data' => [$values]
            ];
    }

    /**
     * @param $values
     * @return array
     */
    protected function getUpdateAjaxRequest(array $values)
    {
        return
            [
                'action' => 'edit',
                'data' => $values
            ];
    }

    /**
     * @param $values
     * @return array
     */
    protected function getDeleteAjaxRequest(array $values)
    {
        return
            [
                'action' => 'remove',
                'data' => $values
            ];
    }

    /**
     * Parse and return the details of an ajax post request.
     *
     * @param TestResponse $response
     * @return array
     */
    protected function parseAjaxResponse(TestResponse $response)
    {
        $model_attributes = json_decode($response->getContent())->data;
        $errors = [];

        if (isset(json_decode($response->getContent())->fieldErrors)) {
            $errors = json_decode($response->getContent())->fieldErrors;
        }

        return ['model' => $model_attributes, 'errors' => $errors];
    }

    /**
     * Construct post values that can be sent to the controller.
     *
     * @param $class_name
     * @param $parameters
     * @param array $factory_override
     * @return array
     */
    protected function prepareCreatePostValues($class_name, $parameters, $factory_override = [])
    {
        $values_array = [];
        $model = factory($class_name)->make($factory_override);

        foreach($parameters as $parameter) {
            $values_array[$parameter] = $model->$parameter;
        }

        return $this->getCreateAjaxRequest($values_array);
    }

    /**
     * Construct post values that can be sent to the controller.
     *
     * @param $class_name
     * @param $parameters
     * @param $model_id
     * @param array $factory_override
     * @return array
     */
    protected function prepareUpdatePostValues($class_name, $parameters, $model_id, $factory_override = [])
    {
        $values_array = [];
        $model = factory($class_name)->make($factory_override);

        foreach($parameters as $parameter) {
            $values_array[$model_id][$parameter] = $model->$parameter;
        }

        return $this->getUpdateAjaxRequest($values_array);
    }

    /**
     * Construct post values that can be sent to the controller.
     *
     * @param $class_name
     * @param $parameters
     * @return array
     */
    protected function prepareValidationPostValues($class_name, $parameters)
    {
        $values_array = [];

        foreach($parameters as $parameter) {
            $values_array[$parameter] = null;
        }

        return $this->getCreateAjaxRequest($values_array);
    }
}
