<?php
namespace WebDeploy\Controller;

use WebDeploy\Processor;
use WebDeploy\Shell\Shell;

class Composer extends Controller
{
    private function check()
    {
        if ((new Shell)->exec('which composer')->getLog()['success']) {
            return true;
        }

        return self::template('body', 'molecules.error', array(
            'message' => __('Composer is not installed')
        ));
    }

    public function index()
    {
        meta()->meta('title', 'Composer Update');

        if (is_object($error = $this->check())) {
            return $error;
        }

        return self::page('body', 'composer.index', array(
            'processor' => (new Processor\Composer)->update()
        ));
    }
}
