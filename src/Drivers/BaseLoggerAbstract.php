<?php

namespace LaravelApiLogger\Drivers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;
use LaravelApiLogger\Contracts\Log;

abstract class BaseLoggerAbstract
{
    protected array $logs = [];

    /**
     * logs into associative array
     *
     * @param Request $request
     * @param  $response
     * @return Log|null
     * @throws \JsonException
     */
    public function generateLog(Request $request, $response): ?Log
    {
        $currentRouteAction = Route::currentRouteAction();

        $controller = "";
        $action = "";

        if ($currentRouteAction) {
            if (str_contains($currentRouteAction, '@')) {
                [$controller, $action] = explode('@', $currentRouteAction);
            } else if (is_string($currentRouteAction)) {
                [$controller, $action] = ["", $currentRouteAction];
            } else {
                // Otherwise force it to be some type of string using `json_encode`.
                [$controller, $action] = ["", (string)json_encode($currentRouteAction, JSON_THROW_ON_ERROR)];
            }
        }


        $endTime = microtime(true);
        $agent = new Agent();
        $agent->setHttpHeaders($request->header('User-Agent'));
        try {
            return new Log(
                created_at: now(),
                method: $request->method(),
                controller: $controller,
                action: $action,
                url: $request->path(),
                payload: json_encode($request->all(), JSON_THROW_ON_ERROR),
                response: json_encode($response, JSON_THROW_ON_ERROR),
                duration: number_format($endTime - LARAVEL_START, 3),
                ip: $request->ip(),
                realIP: $this->getIp(),
                device: $agent->device(),
                platform: $agent->platform(),
                platformVersion: $agent->version($agent->platform()),
                browser: $agent->browser(),
                browserVersion: $agent->version($agent->browser())
            );
        } catch (Exception) {
            return null;
        }
    }

    /**
     * get clint real ip
     *
     * @return string
     */
    private function getIp(): string
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return "";
    }
}
