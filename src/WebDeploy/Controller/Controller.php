<?php
namespace WebDeploy\Controller;

use WebDeploy\Template\Template;
use WebDeploy\Router\Router;

class Controller
{
    public function __construct(Router $router)
    {
        template()->share(array(
            'ROUTE' => $router->getRoute()
        ));
    }
}