<?php
namespace WebDeploy\Middleware;

class AuthBasic
{
    public function handler($router, array $settings)
    {
        if (!$this->checkAuth($settings)) {
            die($this->authHeaders());
        }
    }

    private function checkAuth(array $settings)
    {
        if (empty($settings['enabled'])) {
            return true;
        }

        list($user, $password) = $this->getUserPassword();

        foreach ($settings['users'] as $basicUser => $basicPassword) {
            if (($basicUser === $user) && ($basicPassword === $password)) {
                return true;
            }
        }
    }

    private function getUserPassword()
    {
        return $this->authFromPhpAuthUser() ?: $this->authFromHttpAuthorization() ?: array('', '');
    }

    private function authFromPhpAuthUser()
    {
        if (!empty($_SERVER['PHP_AUTH_USER'])) {
            return array($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        }
    }

    private function authFromHttpAuthorization()
    {
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            if (empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                return;
            }

            $auth = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } else {
            $auth = $_SERVER['HTTP_AUTHORIZATION'];
        }

        $auth = base64_decode(substr($auth, 6));

        return strstr($auth, ':') ? explode(':', $auth) : null;
    }

    private function authHeaders()
    {
        header('WWW-Authenticate: Basic realm="'.__('Authentication').'"');
        header('HTTP/1.0 401 Unauthorized');

        echo __('Unauthorized');
    }
}
