<?php
require __DIR__.'/../src/PHPDeploy/loader.php';

$router = new PHPDeploy\Router\Router(getenv('REQUEST_URI'));

$router->toController()->show('layout.base');
