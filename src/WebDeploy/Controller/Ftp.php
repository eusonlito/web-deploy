<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;

class Ftp extends Controller
{
    private function check()
    {
        if (!function_exists('ftp_connect')) {
            return self::error('ftp', __('FTP PHP functions are not installed'));
        }

        $config = config('ftp');

        if (empty($config['host'])) {
            return self::error('ftp', __('You need configure FTP config file'));
        }

        return $config;
    }

    public function index()
    {
        if (is_object($config = $this->check())) {
            return $config;
        }

        return self::content('ftp.index', array(
            'config' => $config
        ));
    }
}
