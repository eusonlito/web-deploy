<?php
namespace WebDeploy\Controller;

use WebDeploy\Shell\Shell;

class Index extends Controller
{
    private function check()
    {
        $whoami = (new Shell)->exec('whoami')->getLogs()[0];

        if (empty($whoami['success'])) {
            return self::error('index', __('Commands are not supported'));
        }

        return $whoami;
    }

    public function index()
    {
        if (is_object($whoami = $this->check())) {
            return $whoami;
        }

        return self::content('index.index', array(
            'whoami' => $whoami
        ));
    }
}
