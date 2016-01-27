<?php
namespace WebDeploy\Repository;

use WebDeploy\Shell\Shell;

abstract class Repository
{
    protected $path;
    protected $shell;
    protected $config = array();

    public function __construct($path = null, $log = false)
    {
        $this->path = $path;
        $this->shell = (new Shell($path))->log($log);

        return $this;
    }

    public function getShell()
    {
        return $this->shell;
    }

    public function getShellAndLogs()
    {
        return $this->shell->getLogs();
    }

    public function getShellAndLog()
    {
        return $this->shell->getLog();
    }

    protected function exec($cmd)
    {
        $this->shell->exec($cmd);

        return $this;
    }

    protected function loadConfig($file)
    {
        $this->config = array_merge(config('project'), config($file));

        if (isset($this->config['path'])) {
            $this->config['path'] = rtrim($this->config['path'], '/').'/';
        }

        if (isset($this->config['remote_path'])) {
            $this->config['remote_path'] = rtrim($this->config['remote_path'], '/').'/';
        }

        return $this;
    }
}