<?php
namespace WebDeploy\Processor;

use WebDeploy\Router\Route;
use WebDeploy\Shell\Shell;

class Admin extends Git
{
    private function exec($cmd)
    {
        return (new Shell(Route::getBasePath()))->log(true)->exec($cmd)->getLogs()[0];
    }
}