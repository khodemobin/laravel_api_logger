<?php

namespace KhodeMobin\LaravelApiLogger\Drivers;

use KhodeMobin\LaravelApiLogger\Contracts\ApiLoggerInterface;
use KhodeMobin\LaravelApiLogger\Models\ApiLog;

class Database extends BaseLoggerAbstract implements ApiLoggerInterface
{

    /**
     * Model for saving logs
     *
     * @var [type]
     */
    protected $logger;

    public function __construct(ApiLog $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }
    /**
     * return all models
     */
    public function get()
    {
        return $this->logger->all();
    }
    /**
     * save logs in database
     */
    public function save($request, $response)
    {
        $data = $this->logData($request, $response);

        $this->logger->fill($data);

        $this->logger->save();
    }
    /**
     * delete all logs
     */
    public function delete($id)
    {
        $this->logger->truncate();
    }

    public function deleteAll()
    {
        $this->logger->truncate();
    }
}
