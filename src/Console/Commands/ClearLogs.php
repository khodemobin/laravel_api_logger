<?php

namespace KhodeMobin\LaravelApiLogger\Console\Commands;

use Illuminate\Console\Command;
use KhodeMobin\LaravelApiLogger\Contracts\ApiLoggerInterface;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apilog:clear';

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
        $apiLogger->deleteAll();

        $this->info("All records are deleted");
    }
}
