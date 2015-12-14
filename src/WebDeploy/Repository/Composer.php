<?php
namespace WebDeploy\Repository;

use WebDeploy\Exception;
use WebDeploy\Shell\Shell;

class Composer extends Repository
{
    public static function check()
    {
        Shell::check();

        if (!(new Shell)->exec('which composer')->getLog()['success']) {
            throw new Exception\BadFunctionCallException(__('<strong>composer</strong> command is not installed'));
        }
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
