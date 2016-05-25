<?php
namespace WebDeploy\Command;

use WebDeploy\Middleware;

class Command
{
    public function __construct()
    {
        (new Middleware\Cli)->handler();
    }

    public function execute($command, $arguments = array())
    {
        if (empty($command)) {
            dd('Command not valid');
        }

        $class = $this->getClass($command);

        $this->classExists($class);

        (new $class)->run($arguments);
    }

    private function getClass($command)
    {
        return __NAMESPACE__.'\\'.ucfirst(camelCase(basename($command)));
    }

    private function classExists($class)
    {
        if (!class_exists($class)) {
            dd(__('Class %s not exists', $class));
        }
    }
}
