<?php

namespace LaravelApiLogger\Drivers;

use LaravelApiLogger\Contracts\ApiLoggerInterface;
use LaravelApiLogger\Models\ApiLog;
use UserAgentParser\Exception\PackageNotLoadedException;

class Database extends BaseLoggerAbstract implements ApiLoggerInterface
{

    protected $logger;

    public function __construct(ApiLog $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }


    public function get(): array
    {
        return $this->logger::query()->latest()->get();
    }


    public function save($request, $response): void
    {
        $data = $this->logData($request, $response);

        $this->logger->fill($data);

        $this->logger->save();
    }

    public function delete($id): void
    {
        ApiLog::query()->where('id', $id)->delete();
    }

    public function deleteAll(): void
    {
        $this->logger->truncate();
    }
}
