<?php
require __DIR__.'/src/WebDeploy/loader.php';

$router = new WebDeploy\Router\Router(getenv('REQUEST_URI'));

$router->toController()->show('layout.base');
