<?php
namespace WebDeploy\Repository;

use WebDeploy\Shell\Shell;

class Composer extends Repository
{
    public static function exists()
    {
        return (new Shell)->exec('which composer')->getLog()['success'];
    }

    public function __construct($path = null, $log = false)
    {
        parent::__construct($path, $log);

        $this->shell->baseCommand('export COMPOSER_HOME="'.$path.'";');

        return $this;
    }

    public function install()
    {
        return $this->exec('composer install');
    }

    public function getInstall()
    {
        return $this->install()->getShellAndLog();
    }
}
