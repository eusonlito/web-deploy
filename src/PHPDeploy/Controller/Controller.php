<?php
namespace PHPDeploy\Controller;

use PHPDeploy\Template\Template;
use PHPDeploy\Router\Router;

class Controller
{
    public function __construct(Router $router)
    {
        template()->set('base', 'base', array(
            'ROUTE' => $router->getRoute()
        ));
    }
}