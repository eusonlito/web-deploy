<?php
namespace WebDeploy\Controller;

use Exception;
use WebDeploy\Processor;
use WebDeploy\Repository;

class Ftp extends Controller
{
    private function check()
    {
        try {
            Repository\Ftp::check();
        } catch (Exception $e) {
            return self::error('ftp', $e->getMessage());
        }
    }

    public function index()
    {
        if (is_object($response = $this->check())) {
            return $response;
        }

        return self::content('ftp.index', array(
            'config' => config('ftp'),
            'path' => array('success' => config('project')['path']),
            'processor' => (new Processor\Ftp)->index()
        ));
    }

    public function update()
    {
        if (is_object($response = $this->check())) {
            return $response;
        }

        $config = config('ftp');
        $days = (int)input('days') ?: $config['days_history'];

        if (input('find') === 'true') {
            $files = (new Repository\Ftp)->getRecentFiles($days);
        } else {
            $files = array();
        }

        return self::content('ftp.update', array(
            'config' => $config,
            'days' => $days,
            'files' => $files,
            'processor' => (new Processor\Ftp)->update()
        ));
    }
}
