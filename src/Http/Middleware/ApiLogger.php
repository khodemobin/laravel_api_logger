<?php

namespace KhodeMobin\LaravelApiLogger\Http\Middleware;

use Closure;
use KhodeMobin\LaravelApiLogger\Contracts\ApiLoggerInterface;

class ApiLogger
{
    protected $logger;

    public function __construct(ApiLoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $this->logger->save($request, $response);
        return $response;
    }
}
