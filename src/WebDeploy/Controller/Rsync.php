<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Repository;
use WebDeploy\Shell\Shell;

class Rsync extends Controller
{
    private function rsync()
    {
        return new Repository\Rsync;
    }

    public function index()
    {
        meta()->set('title', 'RSYNC Status');

        if (is_object($error = $this->check(true, false))) {
            return $error;
        }

        return self::content('rsync.index', array(
            'whoami' => (new Shell)->exec('whoami')->getLog(),
            'config' => config('rsync'),
            'path' => array('success' => config('project')['path']),
            'processor' => (new Processor\Rsync)->index()
        ));
    }

    public function update()
    {
        meta()->set('title', 'RSYNC Update');

        if (is_object($response = $this->check())) {
            return $response;
        }

        if (input('find') === 'true') {
            $files = (new Repository\Rsync)->getUpdatedFiles();
        } else {
            $files = array();
        }

        return self::content('rsync.update', array(
            'config' => config('rsync'),
            'files' => $files,
            'processor' => (new Processor\Rsync)->update()
        ));
    }
}
