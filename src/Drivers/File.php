<?php

namespace LaravelApiLogger\Drivers;

use LaravelApiLogger\Contracts\ApiLoggerInterface;
use LaravelApiLogger\Models\ApiLog;
use Illuminate\Support\Facades\File as FileFacade;

class File extends BaseLoggerAbstract implements ApiLoggerInterface
{

    /**
     * file path to save the logs
     */
    protected $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = storage_path('logs/apilogs');
    }

    /**
     * read files from log directory
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function get()
    {
        //check if the directory exists
        if (is_dir($this->path)) {
            //scan the directory
            $files = scandir($this->path);
            $contentCollection = [];
            //loop each files
            foreach ($files as $file) {
                if (!is_dir($file)) {
                    $lines = file($this->path . DIRECTORY_SEPARATOR . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    foreach ($lines as $line) {
                        $contentarr = explode(";", $line);
                        $contentCollection[] = $this->mapArrayToModel($contentarr);
                    }
                }
            }
            return collect($contentCollection);
        }

        return [];
    }

    /**
     * write logs to file
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     * @throws \UserAgentParser\Exception\PackageNotLoadedException
     */
    public function save($request, $response)
    {
        $data = $this->logData($request, $response);
        $filename = $this->getLogFilename();

        $contents = implode(";", $data);

        FileFacade::makeDirectory($this->path, 0777, true, true);


        FileFacade::append(($this->path . DIRECTORY_SEPARATOR . $filename), $contents . PHP_EOL);
    }

    /**
     * get log file if defined in constants
     *
     * @return string
     */
    public function getLogFilename()
    {
        // original default filename
        $filename = date('Y-m-d') . '.log';

        $configFilename = config('apilog.filename');
        preg_match('/{(.*?)}/', $configFilename, $matches, PREG_OFFSET_CAPTURE);
        if (sizeof($matches) > 0) {
            $filename = str_replace($matches[0][0], date("{$matches[1][0]}"), $configFilename);
        }
        return $filename;
    }

    public function delete($id)
    {

    }


    /**
     * delete all api log  files
     *
     * @return void
     */
    public function deleteAll()
    {
        if (is_dir($this->path)) {
            FileFacade::deleteDirectory($this->path);
        }
    }
}
