<?php

namespace LaravelApiLogger\Drivers;

use LaravelApiLogger\Contracts\ApiLoggerInterface;
use LaravelApiLogger\Models\ApiLog;

class Redis extends BaseLoggerAbstract implements ApiLoggerInterface
{

    public function save($request, $response)
    {
    }



    public function get()
    {
    }


    public function delete($id)
    {
    }


    public function deleteAll()
    {
    }
}
