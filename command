#!/usr/bin/env php
<?php
require __DIR__.'/src/WebDeploy/loader.php';

use WebDeploy\Command\Command;

array_shift($argv);

Command::execute(array_shift($argv), $argv);

exit;
