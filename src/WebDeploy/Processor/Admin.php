<?php
namespace WebDeploy\Processor;

use WebDeploy\Repository;
use WebDeploy\Router\Route;

class Admin extends Git
{
    protected function exec($function, $parameter = null)
    {
        return (new Repository\Git(Route::getBasePath(), true))->$function($parameter)->getShellAndLog();
    }
}
