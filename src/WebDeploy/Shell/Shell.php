<?php
namespace WebDeploy\Shell;

use WebDeploy\Router\Route;

class Shell
{
    private $base;
    private $log = false;
    private $logs = array();

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

        $this->cd($path ?: config('git')['path'] ?: Route::getBasePath());
    }

    public function cd($path)
    {
        $this->base = $path;

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
        return 'cd "'.escapeshellcmd($this->base).'";'
            .'export HOME="'.$this->base.'";'
            .'export LC_ALL=es_ES.UTF-8;'
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
