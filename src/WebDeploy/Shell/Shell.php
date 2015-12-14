<?php
namespace WebDeploy\Shell;

use WebDeploy\Exception;
use WebDeploy\Router\Route;

class Shell
{
    private $base;
    private $path;
    private $log = false;
    private $logs = array();

    public static function check()
    {
        if (!function_exists('shell_exec')) {
            throw new Exception\BadFunctionCallException(__('PHP function <strong>shell_exec</strong> not exists'));
        }

        if (in_array('exec', array_map('trim', explode(',', ini_get('disable_functions'))), true)) {
            throw new Exception\BadFunctionCallException(__('PHP function <strong>shell_exec</strong> is marked as disabled'));
        }
    }

    public function __construct($path = null)
    {
        $this->setUp($path);

        return $this;
    }

    private function setUp($path = null)
    {
        if (!is_dir($logs = Route::getStoragePath('/logs'))) {
            mkdir($logs, 0755, true);
        }

        $this->cd($path ?: config('project')['path'] ?: Route::getBasePath());
    }

    public function cd($path)
    {
        $this->path = $path;

        return $this;
    }

    public function baseCommand($cmd)
    {
        $this->base = $cmd;

        return $this;
    }

    public function log($status)
    {
        $this->log = ($status === true);

        return $this;
    }

    public function exec($cmd)
    {
        $log = $this->getLogFile();

        $success = $log.'.success';
        $error = $log.'.error';

        shell_exec($this->getCMD($cmd).' > "'.$success.'" 2> "'.$error.'"');

        $this->logs[] = [
            'command' => $cmd,
            'success' => trim(file_get_contents($success)),
            'error' => trim(file_get_contents($error)),
        ];

        if ($this->log === false) {
            unlink($success);
            unlink($error);
        }

        return $this;
    }

    private function getCMD($cmd)
    {
        return 'cd "'.escapeshellcmd($this->path).'";'
            .'export HOME="'.$this->path.'";'
            .'export LC_ALL=es_ES.UTF-8;'
            .$this->base
            .$cmd;
    }

    public function getLog()
    {
        return end($this->logs);
    }

    public function getLogs($offset = 0, $length = null)
    {
        if ($offset || $length) {
            return array_slice($this->logs, $offset, $length);
        }

        return $this->logs;
    }

    public function exists($cmd)
    {
        return (strlen($cmd) && $this->exec('which '.escapeshellcmd($cmd)));
    }

    private function getLogFile()
    {
        return Route::getStoragePath('/logs/'.microtime(true).'-'.uniqid());
    }
}
