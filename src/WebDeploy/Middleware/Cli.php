<?php
namespace WebDeploy\Middleware;

class Cli
{
    public function handler()
    {
        if (PHP_SAPI !== 'cli') {
            die('Commands can only be executed from php-cli');
        }
    }
}
