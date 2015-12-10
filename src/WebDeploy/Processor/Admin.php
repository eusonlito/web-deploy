<?php
namespace WebDeploy\Processor;

use WebDeploy\Repository;
use WebDeploy\Router\Route;
use WebDeploy\Shell\Shell;

class Admin extends Git
{
    public function update()
    {
        if (!$this->check() || !($processor = input('processor'))) {
            return null;
        }

        switch ($processor) {
            case 'composer-install':
                return array($processor => $this->composerInstall());
        }

        return parent::update();
    }

    protected function exec($function, $parameter = null)
    {
        return (new Repository\Git(Route::getBasePath(), true))->$function($parameter)->getShellAndLog();
    }

    protected function composerInstall()
    {
        $path = Route::getBasePath();

        return (new Shell($path))
            ->baseCommand('export COMPOSER_HOME="'.$path.'";')
            ->exec('composer install')
            ->getLog();
    }
}
