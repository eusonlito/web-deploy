<?php
namespace WebDeploy\Command;

class Command
{
    public static function execute($command, $arguments = array())
    {
        if (empty($command)) {
            dd('Command not valid');
        }

        $class = self::getClass($command);

        self::classExists($class);

        (new $class)->run($arguments);
    }

    private static function getClass($command)
    {
        return __NAMESPACE__.'\\'.ucfirst(camelCase(basename($command)));
    }

    private static function classExists($class)
    {
        if (!class_exists($class)) {
            dd(__('Class %s not exists', $class));
        }
    }
}
