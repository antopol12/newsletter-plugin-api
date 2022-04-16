<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequest;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * for each key in the mapper we get that key from the object and map in a
     * new array as the value of the mapper.
     *
     * @param mixed $object
     * @param array $mapper
     *
     * @return array
     */
    protected function mapObject($object, array $mapper = [])
    {
        $mapped = [];

        foreach ($mapper as $field => $key)
            data_set($mapped, $key, data_get($object, $field));

        return $mapped;
    }

    /**
     * Create reponse
     *
     * @param $status
     * @param $data
     * @param $code
     * @param $message
     * @param $metaData
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function Response($status, $data = [], $code = 200, $message = '', $metaData = [])
    {
        return response()->json([
            'meta_data' => $metaData,
            'success'   => $status,
            'status'    => $code,
            'message'   => $message,
            'data'      => $data,
        ], $code);
    }
}
