<?php

namespace LaravelApiLogger\Contracts;

interface ApiLoggerInterface
{

    public function save($request, $response);

    public function get();

    public function delete($id);

    public function deleteAll();
}
