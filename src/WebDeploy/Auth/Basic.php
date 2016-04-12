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
        return static::phpAuthUser() ?: static::httpAuthorization() ?: array('', '');
    }

    private static function phpAuthUser()
    {
        if (!empty($_SERVER['PHP_AUTH_USER'])) {
            return array($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        }
    }

    private static function httpAuthorization()
    {
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            return;
        }

        $auth = base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6));

        return strstr($auth, ':') ? explode(':', $auth) : null;
    }

    private static function checkAuth()
    {
        list($user, $password) = static::getUserPassword();

        foreach (config('auth')['basic'] as $basicUser => $basicPassword) {
            if (($basicUser === $user) && ($basicPassword === $password)) {
                return true;
            }
        }
    }

    private static function authHeaders()
    {
        header('WWW-Authenticate: Basic realm="'.__('Authentication').'"');
        header('HTTP/1.0 401 Unauthorized');

        echo __('Unauthorized');
    }
}
