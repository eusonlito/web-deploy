<?php
namespace WebDeploy\Processor;

use WebDeploy\Router\Router;

abstract class Processor
{
    protected function check()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
}
