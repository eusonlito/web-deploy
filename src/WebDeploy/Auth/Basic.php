<?php
namespace WebDeploy\Auth;

class Basic
{
    public static function check()
    {
        static::checkAuth() or die(static::authHeaders());
    }

    private static function getUserPassword()
    {
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            return array($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        }

        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        }

        return array('', '');
    }

    private static function checkAuth()
    {
        list($user, $password) = static::getUserPassword();

        $config = config('auth')['basic'];

        return (($config['user'] === $user) && ($config['password'] === $password));
    }

    private static function authHeaders()
    {
        header('WWW-Authenticate: Basic realm="'.__('Authentication').'"');
        header('HTTP/1.0 401 Unauthorized');

        echo __('Unauthorized');
    }
}
