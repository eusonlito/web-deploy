<?php
require __DIR__.'/src/WebDeploy/bootstrap.php';

WebDeploy\Auth\Auth::check();

(new WebDeploy\Router\Router(getenv('REQUEST_URI')))->toController()->show('layout.base');

exit;
