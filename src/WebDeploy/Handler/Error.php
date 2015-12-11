<?php
namespace WebDeploy\Handler;

class Error extends ErrorHandler
{
    public static function handle($errno, $errstr, $errfile, $errline)
    {
        self::error($errno, $errstr, $errfile, $errline);
    }
}
