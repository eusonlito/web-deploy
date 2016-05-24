<?php
require __DIR__.'/src/WebDeploy/bootstrap.php';

(new WebDeploy\App\App)
    ->router(getenv('REQUEST_URI'))
    ->middleware()
    ->controller()
    ->show('layout.base');

exit;
