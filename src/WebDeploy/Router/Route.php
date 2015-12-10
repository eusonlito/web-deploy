<?php
namespace WebDeploy\Router;

use WebDeploy\Exception;

class Route
{
    private static $routes;

    private static function load()
    {
        if (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) === 'on')) {
            static::$routes['connection_scheme'] = 'https';
        } else {
            static::$routes['connection_scheme'] = 'http';
        }

        static::$routes['server_name'] = getenv('SERVER_NAME');
        static::$routes['document_root'] = preg_replace('|/$|', '', getenv('DOCUMENT_ROOT'));
        static::$routes['base_path'] = preg_replace('|/$|', '', realpath(__DIR__.'/../../..'));
        static::$routes['src_path'] = static::$routes['base_path'].'/src';
        static::$routes['public_path'] = preg_replace('|^'.static::$routes['document_root'].'|i', '', static::$routes['base_path']) ?: '/';
        static::$routes['public_url'] = preg_replace('|/$|', '', static::$routes['connection_scheme'].'://'.getenv('SERVER_NAME').static::$routes['public_path']);
        static::$routes['template_path'] = self::$routes['src_path'].'/templates';
        static::$routes['storage_path'] = self::$routes['base_path'].'/storage';
        static::$routes['config_path'] = self::$routes['base_path'].'/config';
    }

    public static function __callStatic($name, array $arguments)
    {
        if (strpos($name, 'get') !== 0) {
            throw new Exception\BadFunctionCallException('Please, callme with getRouteName');
        }

        if (empty(self::$routes)) {
            static::load();
        }

        $route = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', str_replace('get', '', $name))), '_');

        if (!array_key_exists($route, static::$routes)) {
            throw new Exception\BadFunctionCallException(__('Route %s not exists', $route));
        }

        return static::$routes[$route].implode('', $arguments);
    }
}
