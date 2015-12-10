<?php
namespace WebDeploy\Controller;

use WebDeploy\Shell\Shell;

class Index extends Controller
{
    public function index()
    {
        if (empty((new Shell)->exec('whoami')->getLogs()[0]['success'])) {
            return self::template('body', 'molecules.error', array(
                'message' => __('Commands are not supported')
            ));
        }

        return self::page('body', 'index.index', array(
            'whoami' => (new Shell)->exec('whoami')->getLogs()[0]
        ));
    }
}
