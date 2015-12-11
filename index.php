<?php
require __DIR__.'/src/WebDeploy/loader.php';

(new WebDeploy\Router\Router(getenv('REQUEST_URI')))
    ->toController()
    ->show('layout.base');

exit;
