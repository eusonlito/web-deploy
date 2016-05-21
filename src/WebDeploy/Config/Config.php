<?php
namespace WebDeploy\Config;

use WebDeploy\Router\Route;

class Config
{
    private static $config = array();

    public static function get($key)
    {
        if (!array_key_exists($key, self::$config)) {
            self::$config[$key] = self::loadFile($key);
        }

        return self::$config[$key];
    }

    public static function set($key, $value)
    {
        self::$config[$key] = $value;
    }

    private static function loadFile($key)
    {
        $path = Route::getConfigPath();
        $config = array();

        if (is_file($file = $path.'/'.$key.'.php')) {
            $config = require $file;
        }

        if (is_file($file = $path.'/custom/'.$key.'.php')) {
            $config = array_replace($config, require $file);
        }

        return $config;
    }
}
