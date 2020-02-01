<?php

namespace LaravelApiLogger\Http\Controllers;

use LaravelApiLogger\Models\ApiLog;

class ApiLogController
{
    public function index()
    {
        $logs = ApiLog::query()->latest()->get();
        return view('apilog::index',compact('logs'));
    }

    public function delete()
    {

    }

    public function deleteAll()
    {

    }
}
