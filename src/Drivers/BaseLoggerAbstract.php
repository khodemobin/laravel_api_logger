<?php
namespace LaravelApiLogger\Drivers;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use LaravelApiLogger\Models\ApiLog;
use UserAgentParser\Exception\NoResultFoundException;
use UserAgentParser\Provider\WhichBrowser;


abstract class BaseLoggerAbstract
{

    protected $logs = [];

    protected $models = [];

    public function __construct()
    {
        $this->boot();
    }
    /**
     * starting method just for cleaning code
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('eloquent.*', function ($event, $models) {
            if (Str::contains($event, 'eloquent.retrieved')) {
                foreach (array_filter($models) as $model) {
                    $class = get_class($model);
                    $this->models[$class] = ($this->models[$class] ?? 0) + 1;
                }
            }
        });
    }

    /**
     * logs into associative array
     *
     * @param  $request
     * @param  $response
     * @return array
     * @throws \UserAgentParser\Exception\PackageNotLoadedException
     */
    public function logData($request, $response)
    {
        $currentRouteAction = Route::currentRouteAction();

        // Initialiaze controller and action variable before use them
        $controller = "";
        $action = "";

        /*
         * Some routes will not contain the `@` symbole (e.g. closures, or routes using a single action controller).
         */
        if ($currentRouteAction) {
            if (strpos($currentRouteAction, '@') !== false) {
                list($controller, $action) = explode('@', $currentRouteAction);
            } else {
                // If we get a string, just use that.
                if (is_string($currentRouteAction)) {
                    list($controller, $action) = ["", $currentRouteAction];
                } else {
                    // Otherwise force it to be some type of string using `json_encode`.
                    list($controller, $action) = ["", (string) json_encode($currentRouteAction)];
                }
            }
        }

        $endTime = microtime(true);

        $implode_models = $this->models;

        $models = implode(', ', $implode_models);
        $this->logs['created_at'] = Carbon::now();
        $this->logs['method'] = $request->method();
        $this->logs['url'] = $request->path();
        $this->logs['payload'] = json_encode($request->all());
        $this->logs['response'] = $response;
        $this->logs['duration'] = number_format($endTime - LARAVEL_START, 3);
        $this->logs['controller'] = $controller;
        $this->logs['action'] = $action;
        $this->logs['models'] = $models;
        $this->logs['ip'] = $request->ip();
        $this->logs['real_ip'] = $this->getIp();
        $this->logs['log'] = json_encode($this->createRequestLog());
        try {
            $provider = new WhichBrowser();
            $result = $provider->parse($request->header('User-Agent'));
            $this->logs['device'] = $result->getDevice()->getBrand() == null ? "" : $result->getDevice()->getModel() . "-" . $result->getDevice()->getModel() == null ? "" : $result->getDevice()->getModel();
            $this->logs['platform_version'] = $result->getOperatingSystem()->getVersion()->getComplete();
            $this->logs['platform'] = $result->getOperatingSystem()->getName();
            $this->logs['browser'] = $result->getBrowser()->getName();
            $this->logs['browser_version'] = $result->getBrowser()->getVersion()->getComplete();

            $result->getRenderingEngine()->getName();
        } catch (NoResultFoundException $ex) {
            // nothing found
        }

        return $this->logs;
    }
    /**
     * Helper method for mapping array into models
     *
     * @param array $data
     * @return ApiLog
     */
    public function mapArrayToModel(array $data)
    {
        $model = new ApiLog();
        $model->created_at = Carbon::make($data[0]);
        $model->method = $data[1];
        $model->url = $data[2];
        $model->payload = $data[3];
        $model->response = $data[4];
        $model->duration = $data[5];
        $model->controller = $data[6];
        $model->action = $data[7];
        $model->models = $data[8];
        $model->ip = $data[9];
        $model->real_ip = $data[10];
        $model->device = $data[11];
        $model->platform = $data[12];
        $model->platform_version = $data[13];
        $model->browser = $data[14];
        $model->browser_version = $data[15];
        $model->log = $data[16];
        return $model;
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

    private function createRequestLog()
    {
        $get_first = function ($x) {
            return $x[0];
        };
        // Same as getallheaders(), just with lowercase keys

        $body = request()->all();
        $headers = array_map($get_first, request()->headers->all());
        return [
            'body' => $body,
            'headers' => $headers
        ];
    }
}
