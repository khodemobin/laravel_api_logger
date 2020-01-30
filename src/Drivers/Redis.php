<?php

namespace KhodeMobin\LaravelApiLogger\Drivers;

use KhodeMobin\LaravelApiLogger\Contracts\ApiLoggerInterface;
use KhodeMobin\LaravelApiLogger\Models\ApiLog;

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
