<?php

namespace LaravelApiLogger\Console\Commands;

use Illuminate\Console\Command;
use LaravelApiLogger\Contracts\ApiLoggerInterface;
use LaravelApiLogger\Models\ApiLog;

class GetLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apilog:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush All Records of ApiLogger';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ApiLoggerInterface $apiLogger)
    {
        $headers = ['id', 'i[', 'url', 'method', 'duration', 'created_at'];

        $this->table([], ApiLog::select('id', 'ip', 'url', 'method', 'duration', 'created_at')->get());
    }
}
