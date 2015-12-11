<?php
namespace WebDeploy\Auth;

class Auth
{
    public static function check()
    {
        $config = config('auth');

        if (empty($config['enabled'])) {
            return true;
        }

        $class = static::getClass($config['enabled']);

        return $class::check();
    }

    private static function getClass($class)
    {
        return __NAMESPACE__.'\\'.ucfirst($class);
    }
}
