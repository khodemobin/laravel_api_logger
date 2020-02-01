<?php

namespace LaravelApiLogger\Drivers;

use LaravelApiLogger\Contracts\ApiLoggerInterface;
use LaravelApiLogger\Models\ApiLog;
use UserAgentParser\Exception\PackageNotLoadedException;

class Database extends BaseLoggerAbstract implements ApiLoggerInterface
{

    /**
     * Model for saving logs
     *
     * @var [type]
     */
    protected $logger;

    /**
     * Database constructor.
     * @param ApiLog $logger
     */
    public function __construct(ApiLog $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }

    /**
     * return all models
     * @return array
     */
    public function get(): array
    {
        return $this->logger->all();
    }

    /**
     * save logs in database
     * @param $request
     * @param $response
     * @throws PackageNotLoadedException
     */
    public function save($request, $response)
    {
        $data = $this->logData($request, $response);

        $this->logger->fill($data);

        $this->logger->save();
    }

    /**
     * delete all logs
     * @param $id
     */
    public function delete($id)
    {
        $log = ApiLog::find($id);
        if ($log) {
            $log->delete();
        }
    }

    public function deleteAll()
    {
        $this->logger->truncate();
    }
}
