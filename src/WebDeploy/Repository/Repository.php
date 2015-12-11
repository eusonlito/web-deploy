<?php
namespace WebDeploy\Repository;

use WebDeploy\Shell\Shell;

abstract class Repository
{
    protected $path;
    protected $shell;

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
}