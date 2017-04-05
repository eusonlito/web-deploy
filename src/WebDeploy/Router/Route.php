<?php
namespace WebDeploy\Router;

use WebDeploy\Exception;

class Route
{
    private static $routes;

    private static function load()
    {
        if (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) === 'on')) {
            self::$routes['connection_scheme'] = 'https';
        } else {
            self::$routes['connection_scheme'] = 'http';
        }

        self::$routes['server_name'] = getenv('SERVER_NAME');
        self::$routes['document_root'] = rtrim(realpath(getenv('DOCUMENT_ROOT')), '/');
        self::$routes['base_path'] = WD_BASE_PATH;
        self::$routes['libs_path'] = WD_LIBS_PATH;
        self::$routes['public_path'] = preg_replace('|^'.self::$routes['document_root'].'|i', '', self::$routes['base_path']) ?: '/';
        self::$routes['public_url'] = rtrim(self::$routes['connection_scheme'].'://'.getenv('SERVER_NAME').self::$routes['public_path'], '/');
        self::$routes['storage_path'] = self::$routes['base_path'].'/storage';
        self::$routes['config_path'] = self::$routes['base_path'].'/config';
        self::$routes['template_path'] = WD_BASE_PATH.'/src/templates';
    }

    public static function __callStatic($name, array $arguments)
    {
        if (strpos($name, 'get') !== 0) {
            throw new Exception\BadFunctionCallException('Please, callme with getRouteName');
        }

        if (empty(self::$routes)) {
            self::load();
        }

        $route = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', str_replace('get', '', $name))), '_');

        if (!array_key_exists($route, self::$routes)) {
            throw new Exception\BadFunctionCallException(__('Route %s not exists', $route));
        }

        return self::$routes[$route].implode('', $arguments);
    }
}
