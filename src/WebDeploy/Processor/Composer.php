<?php
namespace WebDeploy\Processor;

use WebDeploy\Shell\Shell;
use WebDeploy\Router\Route;

class Composer extends Processor
{
    public function update()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'composer-install':
                $status = $this->composerInstall();
                break;

            default:
                return array();
        }

        return array($processor => $status);
    }

    protected function exec($cmd)
    {
        return (new Shell)
            ->baseCommand('export COMPOSER_HOME="'.config('git')['path'].'";')
            ->exec($cmd)
            ->getLog();
    }

    protected function composerInstall()
    {
        return $this->exec('composer install');
    }
}
